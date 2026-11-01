<?php

namespace App\Support;

use App\Models\Admin;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminJwt
{
    public const COOKIE = 'admin_access_token';
    public const REFRESH_COOKIE = 'admin_refresh_token';
    private const SESSION_KEY = 'admin_auth_session_id';
    private const ACCESS_TTL = 900;

    private function key(): string
    {
        $key = (string) config('app.key');
        if (str_starts_with($key, 'base64:')) $key = base64_decode(substr($key, 7), true) ?: '';
        if (strlen($key) < 32) throw new \RuntimeException('APP_KEY must contain at least 32 bytes.');
        return hash_hmac('sha256', 'dried-chilli:admin-jwt:v2', $key, true);
    }

    private function fingerprint(Admin $admin): string
    {
        return hash_hmac('sha256', $admin->getAuthPassword(), $this->key());
    }

    private function cookie(Request $request, string $name, string $value, int $minutes)
    {
        return cookie($name, $value, $minutes, '/', config('session.domain'),
            (bool) (config('session.secure') ?? $request->isSecure()), true, false, 'lax');
    }

    private function accessCookie(Request $request, Admin $admin, string $sid)
    {
        $now = time();
        $token = JWT::encode(['iss'=>'dried-chilli-admin', 'aud'=>'admin', 'sub'=>(string) $admin->getAuthIdentifier(),
            'sid'=>$sid, 'iat'=>$now, 'nbf'=>$now, 'exp'=>$now+self::ACCESS_TTL], $this->key(), 'HS256');
        return $this->cookie($request, self::COOKIE, $token, self::ACCESS_TTL / 60);
    }

    public function start(Request $request, Admin $admin, bool $remember): array
    {
        $sid = (string) Str::uuid();
        $secret = bin2hex(random_bytes(32));
        $expires = now()->addMinutes($remember ? 30 * 24 * 60 : 8 * 60);
        DB::table('admin_auth_sessions')->insert(['id'=>$sid, 'admin_id'=>$admin->id, 'refresh_hash'=>hash('sha256', $secret),
            'password_fingerprint'=>$this->fingerprint($admin), 'remember'=>$remember, 'expires_at'=>$expires,
            'created_at'=>now(), 'updated_at'=>now()]);
        $request->session()->put(self::SESSION_KEY, $sid);
        return [$this->accessCookie($request, $admin, $sid), $this->cookie($request, self::REFRESH_COOKIE, $sid.'.'.$secret, $remember ? 30*24*60 : 0)];
    }

    public function authenticate(Request $request): ?Admin
    {
        $token = $request->cookie(self::COOKIE);
        if (!is_string($token)) return null;
        try {
            $claims = JWT::decode($token, new Key($this->key(), 'HS256'));
            if (($claims->iss ?? null) !== 'dried-chilli-admin' || ($claims->aud ?? null) !== 'admin' ||
                !is_string($claims->sid ?? null) || !is_string($claims->sub ?? null) || !isset($claims->exp, $claims->iat, $claims->nbf)) return null;
            $session = DB::table('admin_auth_sessions')->where('id', $claims->sid)->where('admin_id', $claims->sub)
                ->whereNull('revoked_at')->where('expires_at', '>', now())->first();
            if (!$session) return null;
            $admin = Admin::find($session->admin_id);
            return $admin && (int) $admin->active === 1 && hash_equals($session->password_fingerprint, $this->fingerprint($admin)) ? $admin : null;
        } catch (\UnexpectedValueException | \DomainException $exception) {
            return null;
        }
    }

    private function refreshParts(Request $request): ?array
    {
        $token = $request->cookie(self::REFRESH_COOKIE);
        if (!is_string($token) || !preg_match('/^([0-9a-f-]{36})\.([0-9a-f]{64})$/D', $token, $matches)) return null;
        return [$matches[1], hash('sha256', $matches[2])];
    }

    public function rotate(Request $request): ?array
    {
        $parts = $this->refreshParts($request);
        if (!$parts) return null;
        [$sid, $oldHash] = $parts;
        $session = DB::table('admin_auth_sessions')->where('id', $sid)->whereNull('revoked_at')->where('expires_at', '>', now())->first();
        if (!$session || !hash_equals($session->refresh_hash, $oldHash)) return null;
        $admin = Admin::find($session->admin_id);
        if (!$admin || (int) $admin->active !== 1 || !hash_equals($session->password_fingerprint, $this->fingerprint($admin))) return null;
        $newSecret = bin2hex(random_bytes(32));
        $updated = DB::table('admin_auth_sessions')->where('id', $sid)->where('refresh_hash', $oldHash)
            ->whereNull('revoked_at')->where('expires_at', '>', now())
            ->update(['refresh_hash'=>hash('sha256', $newSecret), 'updated_at'=>now()]);
        if ($updated !== 1) return null;
        $request->session()->put(self::SESSION_KEY, $sid);
        return [$admin, $this->accessCookie($request, $admin, $sid),
            $this->cookie($request, self::REFRESH_COOKIE, $sid.'.'.$newSecret, $session->remember ? max(1, now()->diffInMinutes(\Carbon\Carbon::parse($session->expires_at), false)) : 0)];
    }

    public function revoke(Request $request): array
    {
        $sid = $request->session()->get(self::SESSION_KEY);
        if (is_string($sid)) DB::table('admin_auth_sessions')->where('id', $sid)->whereNull('revoked_at')->update(['revoked_at'=>now()]);
        $parts = $this->refreshParts($request);
        if ($parts) DB::table('admin_auth_sessions')->where('id', $parts[0])->where('refresh_hash', $parts[1])->whereNull('revoked_at')->update(['revoked_at'=>now()]);
        $request->session()->forget(self::SESSION_KEY);
        return [cookie()->forget(self::COOKIE, '/', config('session.domain')), cookie()->forget(self::REFRESH_COOKIE, '/', config('session.domain'))];
    }
}
