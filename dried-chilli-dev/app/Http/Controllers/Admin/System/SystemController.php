<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\System\SystemRepositoryInterface;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Hash;
use App\Models\System;

class SystemController extends Controller
{
    private $system;

    public function __construct(
        SystemRepositoryInterface $system,
    ) {
        $this->system = $system;
    }

    public function index()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.edit", compact("data"));
    }

    public function general()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.generals", compact("data"));
    }

    public function socials()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.socials", compact("data"));
    }

    public function contacts()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.contacts", compact("data"));
    }

    public function opengraphs()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.opengraphs", compact("data"));
    }

    public function pages()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.pages", compact("data"));
    }

    public function apis()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.apis", compact("data"));
    }

    public function consoles()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.consoles", compact("data"));
    }

    public function configshareholders()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.bookings", compact("data"));
    }
    public function configContracts()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.contracts", compact("data"));
    }

    public function otps()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.otps", compact("data"));
    }

    public function notifications()
    {
        $data = $this->system
            ->all()
            ->keyBy('key')
            ->toArray();
        return view("admin.systems.notifications", compact("data"));
    }

    public function update(Request $request)
    {
        if ($request->input('settings_section') === 'general') {
            $rules = [];
            foreach ([
                'company_name', 'company_legal_name', 'company_tax_id',
                'company_email', 'company_hotline', 'company_address',
                'company_tagline', 'company_logo', 'company_footer_description',
                'company_copyright', 'company_footer_watermark', 'google_site_verification',
            ] as $key) {
                $rules[$key] = ['nullable', 'string', 'max:5000'];
            }
            $rules['company_email'][] = 'email';
            $rules['company_logo'] = ['nullable', 'string', 'max:7500000'];

            $validated = $request->validate($rules);
            if (str_starts_with((string) ($validated['company_logo'] ?? ''), 'data:image/')) {
                $validated['company_logo'] = \App\Support\Base64ImageStore::store($validated['company_logo'], 'company-images');
            }
            foreach ($validated as $key => $value) {
                System::updateOrCreate(['key' => $key], ['content' => $value]);
            }

            app(\App\Support\SystemSettings::class)->forget();
            return back()->with('success', 'Company settings updated successfully.');
        }

        $input = $request->all();
        if ($request->has('contract_defaults')) {
            $rules = ['contract_defaults' => ['required', 'array']];
            foreach (config('website-contract.fields') as $fields) {
                foreach ($fields as $key => $label) { $rules['contract_defaults.' . $key] = ['nullable', 'string', 'max:5000']; }
            }
            $defaults = $request->validate($rules)['contract_defaults'];
            foreach (config('website-contract.fields') as $fields) {
                foreach ($fields as $key => $label) {
                    if (array_key_exists($key, $defaults)) { System::updateOrCreate(['key' => 'contract_default_' . $key], ['content' => $defaults[$key]]); }
                }
            }
            app(\App\Support\SystemSettings::class)->forget();
            unset($input['contract_defaults']);
        }
        if ($request->has('page_paths')) {
            $rules = ['page_paths' => ['required', 'array']];
            foreach (\App\Support\PagePathMap::DEFAULTS as $page => $default) {
                $rules['page_paths.' . $page] = ['required', 'array'];
                foreach (['en'] as $locale) {
                    $rules["page_paths.{$page}.{$locale}"] = ['present', 'nullable', 'string', 'max:100'];
                }
            }
            $validated = $request->validate($rules);
            try {
                $paths = \App\Support\PagePaths::map()->updated($validated['page_paths']);
            } catch (\InvalidArgumentException $exception) {
                throw \Illuminate\Validation\ValidationException::withMessages(['page_paths' => $exception->getMessage()]);
            }
            System::updateOrCreate(['key' => 'public_page_paths'], ['content' => json_encode($paths, JSON_UNESCAPED_UNICODE)]);
            app(\App\Support\SystemSettings::class)->forget();
            unset($input['page_paths']);
        }

        if (isset($input['homepage']) && is_array($input['homepage'])) {
            $allowedKeys = collect(config('homepage', []))
                ->flatMap(fn ($fields) => collect($fields)->keys())
                ->flatMap(fn ($key) => ["home_{$key}_en"])
                ->flip();

            foreach ($input['homepage'] as $key => $content) {
                if (!$allowedKeys->has($key)) {
                    continue;
                }

                System::updateOrCreate(
                    ['key' => $key],
                    ['content' => $content, 'active' => true]
                );
            }

            unset($input['homepage']);
        }


        if (isset($input['page_content']) && is_array($input['page_content'])) {
            $allowedKeys = collect(config('page-content', []))
                ->flatMap(function ($page) {
                    $prefix = $page['prefix'];
                    return collect($page['sections'] ?? [])->flatMap(function ($fields) use ($prefix) {
                        return collect($fields)->keys()
                            ->flatMap(fn ($key) => ["{$prefix}_{$key}_en"]);
                    });
                })
                ->flip();

            foreach ($input['page_content'] as $key => $content) {
                if (!$allowedKeys->has($key)) {
                    continue;
                }

                System::updateOrCreate(
                    ['key' => $key],
                    ['content' => $content, 'active' => true]
                );
            }

            unset($input['page_content']);
        }
        if (isset($input['api_user_password']) && !empty($input['api_user_password'])) {
            $input['api_user_password'] = Hash::make($input['api_user_password']);
        }

        $this->system->update($input);
        app(\App\Support\SystemSettings::class)->forget();
        session()->flash('success', 'Settings updated successfully.');
        return redirect()->back();
    }

    public function runConsoles()
    {
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return response()->json(['message' => 'Cache refreshed successfully.'], 200);
    }
}
