<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Support\AdminJwt;

use Exception;


class LoginController extends Controller
{
    protected $redirectTo = 'admin/login';

    public function login(Request $request, AdminJwt $jwt)
    {
        try {
            $admin = $jwt->authenticate($request);
            if ($admin) {
                return redirect()->route('admin.dashboard.index');
            }
            return response()->view('admin.login.login');
        } catch (Exception $e) {
            return response()->json(
                array(
                    'status' => 400,
                    'errors' => $e->getMessage()
                )
            );
        }
    }

    public function logout(Request $request, AdminJwt $jwt)
    {
        try {
            $cookies = $jwt->revoke($request);
            auth()->guard('admin')->logout();
            $request->session()->regenerate(true);
            $request->session()->regenerateToken();
            $response = redirect()->route('admin.login')->with('success', __('label.logout_successfully'));
            foreach ($cookies as $cookie) $response->headers->setCookie($cookie);
            return $response;
        } catch (Exception $e) {
            return response()->json(
                array(
                    'status' => 400,
                    'errors' => $e->getMessage()
                )
            );
        }
    }

    public function refresh(Request $request, AdminJwt $jwt)
    {
        $result = $jwt->rotate($request);
        if (!$result) return response()->json(['message' => 'Session expired. Please sign in again.'], 401);
        [$admin, $access, $refresh] = $result;
        auth()->guard('admin')->login($admin);
        $response = response()->json(['redirect_url' => route('admin.dashboard.index', [], false)]);
        $response->headers->setCookie($access);
        $response->headers->setCookie($refresh);
        return $response;
    }

    public function postlogin(Request $request, AdminJwt $jwt)
    {
        try {
            $input = $request->only(
                [
                    'email',
                    'password',]
            );

            $rules = [
                'email' => 'required|max:255',
                'password' => 'required|max:20|min:4',
            ];

            $messages = [
                'email.required' => __('admin/login.required', ['field' => 'Email']),
                'email.max' => __('admin/login.max_255', ['field' => 'Email']),
                'password.required' => __('admin/login.required', ['field' => 'Password']),
                'password.max' => __('admin/login.max_255', ['field' => 'Password']),
                'password.min' => __('admin/login.min_4', ['field' => 'Password']),
            ];

            $validator = Validator::make(
                $input,
                $rules,
                $messages
            );

            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(
                    array(
                        'status' => 400,
                        'errors' => $errs
                    )
                );
            }

            $remember = $request->filled('remember');
            if (auth()->guard('admin')->attempt(
                [
                    'email' => $input['email'],
                    'password' => $input['password']
                ],
                false
            )) {
                $user = auth()->guard('admin')->user();

                if ($user->active != 1) {
                    auth()->guard('admin')->logout();
                    return response()->json(
                        array(
                            'status' => 403,
                            'errors' => __('label.inactive_account')
                        )
                    );
                }

                $jwt->revoke($request);
                $request->session()->regenerate(true);
                $cookies = $jwt->start($request, $user, $remember);

                $response = response()->json(
                    array(
                        'status' => 200,
                        'success' => __('label.success_login'),
                        'redirect_url' => route('admin.dashboard.index', [], false)
                    )
                );
                foreach ($cookies as $cookie) $response->headers->setCookie($cookie);
                return $response;
            } else {
                return response()->json(
                    array(
                        'status' => 400,
                        'errors' => __('label.error_login')
                    )
                );
            }
        } catch (Exception $e) {
            return response()->json(
                array(
                    'status' => 400,
                    'errors' => $e->getMessage()
                )
            );
        }
    }
}
