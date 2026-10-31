<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Support\SystemSettings;
use App\Support\PageContentGroups;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class HomepageController extends Controller
{
    public function index()
    {
        $sections = PageContentGroups::sections();
        $values = app(SystemSettings::class)->all();
        $faqs = request()->query('page') === 'FAQ' ? \App\Models\Faq::orderBy('sort_order')->orderBy('id')->get() : collect();
        return view('admin.homepage', compact('sections', 'values', 'faqs'));
    }

    private function preparePageContent(Request $request, array $sections): array
    {
        $pages = PageContentGroups::fromSections($sections);
        $page = $request->validate(['selected_page' => ['required', 'string', Rule::in(array_keys($pages))]])['selected_page'];
        $rules = ['content' => ['required', 'array']];
        foreach ($pages[$page] as $fields) {
            foreach ($fields as $key => $field) {
                if (preg_match('/\.(css|js)(\?.*)?$/i', $field['value'] ?? '')) {
                    continue;
                }
                $isImage = ($field['type'] ?? null) === 'image' || (str_contains($key, '_image') && !str_contains($key, '_alt_') && !str_contains($key, '_description'));
                $max = $isImage ? 7500000 :
                    ((str_contains($key, '_content') || str_contains($key, '_text') || str_contains($key, '_editor') || str_contains($key, '_desc')) ? 1000000 : 50000);
                $rules['content.' . $key] = ['present', 'nullable', 'string', 'max:' . $max];
            }
        }
        $content = $request->validate($rules)['content'];
        $rows = [];
        $timestamp = now();
        foreach ($content as $key => $value) {
            if (!isset($rules['content.' . $key])) {
                continue;
            }
            if (str_contains($key, '_image') && !str_contains($key, '_alt_') && !str_contains($key, '_description') && str_starts_with((string) $value, 'data:image/')) {
                $value = \App\Support\Base64ImageStore::store($value, 'page-images');
            }
            $rows[] = ['key' => 'nafu_home_' . $key, 'content' => $value ?? '', 'created_at' => $timestamp, 'updated_at' => $timestamp];
        }
        usort($rows, fn ($left, $right) => strcmp($left['key'], $right['key']));
        return $rows;
    }

    private function saveEditor(Request $request, array $sections): void
    {
        $faqEntries = [];
        if ($request->input('selected_page') === 'FAQ') {
            $faqEntries = $request->validate([
                'faq_entries' => ['nullable', 'array'],
                'faq_entries.*.id' => ['nullable', 'integer', 'distinct', 'exists:faqs,id'],
                'faq_entries.*.question' => ['required', 'string', 'max:500'],
                'faq_entries.*.answer' => ['required', 'string', 'max:20000'],
                'faq_entries.*.is_active' => ['required', 'boolean'],
                'faq_entries.*.sort_order' => ['required', 'integer', 'min:0', 'max:100000'],
                'faq_entries.*.delete' => ['nullable', 'boolean'],
            ])['faq_entries'] ?? [];
        }
        $rows = $this->preparePageContent($request, $sections);
        $preparedContent = [];
        foreach ($rows as $row) $preparedContent[substr($row['key'], strlen('nafu_home_'))] = $row['content'];
        $request->merge(['content' => $preparedContent]);
        \Illuminate\Support\Facades\DB::transaction(function () use ($rows, $faqEntries) {
            if ($rows) System::upsert($rows, ['key'], ['content', 'updated_at']);
            foreach ($faqEntries as $entry) {
                if (!empty($entry['delete'])) {
                    if (!empty($entry['id'])) \App\Models\Faq::whereKey($entry['id'])->delete();
                    continue;
                }
                $faq = !empty($entry['id']) ? \App\Models\Faq::findOrFail($entry['id']) : new \App\Models\Faq();
                $faq->fill(collect($entry)->only(['question', 'answer', 'is_active', 'sort_order'])->all())->save();
            }
        }, 3);
        app(SystemSettings::class)->forget();
    }

    public function update(Request $request)
    {
        try {
            $this->saveEditor($request, PageContentGroups::sections());
        } catch (QueryException $exception) {
            if (!$this->isLockConflict($exception)) throw $exception;
            return back()->withInput($request->except('_token'))->with('error', 'The page is being updated by another request. Please try saving again.');
        }
        return back()->with('success', 'Page updated successfully.');
    }

    private function isLockConflict(QueryException $exception): bool
    {
        return (string) $exception->getCode() === '40001' || in_array((int) ($exception->errorInfo[1] ?? 0), [1205, 1213], true);
    }

    public function addSection(Request $request)
    {
        $type = $request->input('type');
        $page = $request->input('page', 'About Us');
        $validTypes = ['text-image', 'card'];
        if ($page !== $request->input('selected_page')) {
            return back()->with('error', 'The selected page does not match the section.');
        }
        if (!in_array($type, $validTypes) || !in_array($page, PageContentGroups::CUSTOM_PAGES, true)) {
            return back()->with('error', 'Invalid section type selected.');
        }

        try {
            $this->saveEditor($request, PageContentGroups::sections());
        } catch (QueryException $exception) {
            if (!$this->isLockConflict($exception)) throw $exception;
            return back()->withInput($request->except('_token'))->with('error', 'The page is being updated by another request. Please try saving again.');
        }

        $configPath = config_path('dried-chilli-home-content.json');
        $json = PageContentGroups::customPageSections($page);

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

        System::updateOrCreate(['key' => PageContentGroups::customSchemaKey($page)], ['content' => json_encode($newJson, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)]);
        app(SystemSettings::class)->forget();
        return back()->with('success', "Section {$nextIndex} added successfully!");
    }
    public function deleteSection(Request $request)
    {
        $sectionKey = $request->input('section');
        if (!$sectionKey || !str_contains($sectionKey, ' - Section ')) {
            return back()->with('error', 'Invalid section to delete.');
        }

        $configPath = config_path('dried-chilli-home-content.json');
        $page = collect(PageContentGroups::CUSTOM_PAGES)->first(fn ($candidate) => str_starts_with($sectionKey, $candidate . ' - Section '));
        if (!$page) return back()->with('error', 'Invalid section to delete.');
        $json = PageContentGroups::customPageSections($page);

        if (!isset($json[$sectionKey])) {
            return back()->with('error', 'Section not found.');
        }

        $fields = $json[$sectionKey];
        unset($json[$sectionKey]);
        System::updateOrCreate(['key' => PageContentGroups::customSchemaKey($page)], ['content' => json_encode($json, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)]);

        $dbKeys = array_map(fn($k) => 'nafu_home_' . $k, array_keys($fields));
        foreach (array_keys($fields) as $key) {
            if (str_ends_with($key, '_active')) $dbKeys[] = 'nafu_home_' . substr($key, 0, -7) . '_published';
        }
        \App\Models\System::whereIn('key', $dbKeys)->delete();
        app(SystemSettings::class)->forget();

        return back()->with('success', 'Section deleted successfully.');
    }
}
