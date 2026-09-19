<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Support\SystemSettings;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $sections = json_decode(file_get_contents(config_path('nafu-home-content.json')), true, 512, JSON_THROW_ON_ERROR);
        $values = app(SystemSettings::class)->all();
        return view('admin.homepage', compact('sections', 'values'));
    }

    public function update(Request $request)
    {
        $sections = json_decode(file_get_contents(config_path('nafu-home-content.json')), true, 512, JSON_THROW_ON_ERROR);
        $rules = [];
        foreach ($sections as $fields) {
            foreach ($fields as $key => $field) {
                if (preg_match('/\.(css|js)(\?.*)?$/i', $field['value'] ?? '')) {
                    continue;
                }
                if (str_contains($key, '_image_')) {
                    $rules['content.'.$key] = ['present', 'nullable', 'string', 'max:7500000'];
                } else {
                    $rules['content.'.$key] = ['present', 'nullable', 'string', 'max:10000'];
                }
            }
        }
        $content = $request->validate($rules)['content'];
        foreach ($content as $key => &$value) {
            if (str_contains($key, '_image_') && str_starts_with((string) $value, 'data:image/')) {
                $value = \App\Support\Base64ImageStore::store($value, 'page-images');
            }
        }
        unset($value);
        foreach ($content as $key => $value) {
            System::updateOrCreate(['key' => 'nafu_home_'.$key], ['content' => $value ?? '']);
        }
        app(SystemSettings::class)->forget();
        return back()->with('success', 'Pages updated successfully.');
    }
}
