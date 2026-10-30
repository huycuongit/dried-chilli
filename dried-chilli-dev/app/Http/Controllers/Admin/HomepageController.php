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

    public function addSection(Request $request)
    {
        // === SAVE CURRENT FORM DATA FIRST ===
        $sections = json_decode(file_get_contents(config_path('nafu-home-content.json')), true, 512, JSON_THROW_ON_ERROR);
        $rules = [];
        foreach ($sections as $fields) {
            foreach ($fields as $key => $field) {
                if (preg_match('/\.(css|js)(\?.*)?$/i', $field['value'] ?? '')) continue;
                if (str_contains($key, '_image_')) {
                    $rules['content.'.$key] = ['present', 'nullable', 'string', 'max:7500000'];
                } else {
                    $rules['content.'.$key] = ['present', 'nullable', 'string', 'max:10000'];
                }
            }
        }
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $content = $validator->validated()['content'] ?? [];
            foreach ($content as $key => &$val) {
                if (str_contains($key, '_image_') && str_starts_with((string) $val, 'data:image/')) {
                    $val = \App\Support\Base64ImageStore::store($val, 'page-images');
                }
            }
            unset($val);
            foreach ($content as $key => $val) {
                System::updateOrCreate(['key' => 'nafu_home_'.$key], ['content' => $val ?? '']);
            }
        }
        // === END SAVE ===

        $type = $request->input('type');
        $page = $request->input('page', 'About Us');
        $validTypes = ['text-image', 'card'];
        if (!in_array($type, $validTypes)) {
            return back()->with('error', 'Invalid section type selected.');
        }

        $configPath = config_path('nafu-home-content.json');
        $json = json_decode(file_get_contents($configPath), true, 512, JSON_THROW_ON_ERROR);

        // Find next section index for this page
        $nextIndex = 1;
        while (isset($json["{$page} - Section {$nextIndex}"])) {
            $nextIndex++;
        }

        $newSectionKey = "{$page} - Section {$nextIndex}";
        $prefix = 'page_' . \Illuminate\Support\Str::slug($page, '_') . "_sec{$nextIndex}";
        
        $newSectionData = [
            "{$prefix}_active" => [
                "value" => "1",
                "label" => "[Section {$nextIndex}] Status",
                "type" => "select",
                "options" => [
                    "1" => "Show Section",
                    "0" => "Hide Section"
                ]
            ],
            "{$prefix}_type" => [
                "value" => $type,
                "label" => "[Section {$nextIndex}] Section Type",
                "type" => "select",
                "options" => [
                    "text-image" => "Text & Image",
                    "card" => "Feature Cards"
                ]
            ]
        ];

        if ($type === 'text-image') {
            $newSectionData = array_merge($newSectionData, [
                "{$prefix}_layout" => [
                    "value" => "normal",
                    "label" => "[Section {$nextIndex}] Image Position",
                    "type" => "select",
                    "options" => [
                        "normal" => "Image Left, Text Right",
                        "reverse" => "Image Right, Text Left",
                        "full-text" => "Full Text (Centered)"
                    ]
                ],
                "{$prefix}_image" => [
                    "value" => "",
                    "label" => "[Section {$nextIndex}] Image"
                ],
                "{$prefix}_title" => [
                    "value" => "New Section {$nextIndex}",
                    "label" => "[Section {$nextIndex}] Title"
                ],
                "{$prefix}_text" => [
                    "value" => "New section content...",
                    "label" => "[Section {$nextIndex}] Text",
                    "type" => "editor"
                ]
            ]);
        } else {
            $newSectionData = array_merge($newSectionData, [
                "{$prefix}_title" => [
                    "value" => "Feature Section {$nextIndex}",
                    "label" => "[Section {$nextIndex}] Main Title"
                ],
                "{$prefix}_text" => [
                    "value" => "Optional section description...",
                    "label" => "Section Text (Optional)"
                ]
            ]);
            for ($c = 1; $c <= 3; $c++) {
                $newSectionData = array_merge($newSectionData, [
                    "{$prefix}_icon_{$c}" => [
                        "value" => "✨",
                        "label" => "Item {$c} Icon"
                    ],
                    "{$prefix}_title_{$c}" => [
                        "value" => "Card {$c} Title",
                        "label" => "Item {$c} Title"
                    ],
                    "{$prefix}_text_{$c}" => [
                        "value" => "Card {$c} description...",
                        "label" => "Item {$c} Text"
                    ]
                ]);
            }
        }

        // Insert exactly after the last section for this page or at the end
        $newJson = [];
        $inserted = false;
        foreach ($json as $key => $val) {
            $newJson[$key] = $val;
            if (str_starts_with($key, "{$page} - Section ") && !$inserted) {
                // If the next key is not a section for this page, insert here
                $keys = array_keys($json);
                $currentIndex = array_search($key, $keys);
                $nextKey = $keys[$currentIndex + 1] ?? null;
                if (!$nextKey || !str_starts_with($nextKey, "{$page} - Section ")) {
                    $newJson[$newSectionKey] = $newSectionData;
                    $inserted = true;
                }
            }
        }
        if (!$inserted) {
            $newJson[$newSectionKey] = $newSectionData;
        }

        file_put_contents($configPath, json_encode($newJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return back()->with('success', "Section {$nextIndex} added successfully!");
    }
    public function deleteSection(Request $request)
    {
        $sectionKey = $request->input('section');
        if (!$sectionKey || !str_contains($sectionKey, ' - Section ')) {
            return back()->with('error', 'Invalid section to delete.');
        }

        $configPath = config_path('nafu-home-content.json');
        $json = json_decode(file_get_contents($configPath), true, 512, JSON_THROW_ON_ERROR);

        if (!isset($json[$sectionKey])) {
            return back()->with('error', 'Section not found.');
        }

        $fields = $json[$sectionKey];
        unset($json[$sectionKey]);
        file_put_contents($configPath, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $dbKeys = array_map(fn($k) => 'nafu_home_'.$k, array_keys($fields));
        \App\Models\System::whereIn('key', $dbKeys)->delete();
        app(SystemSettings::class)->forget();

        return back()->with('success', 'Section deleted successfully.');
    }
}
