<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private const BACKUP_KEY = 'nafu_home_jojo_redesign_backup_20261115';

    private const FIELDS = [
        'page_layout_home_slide_1_01',
        'page_layout_home_slide_1_02',
        'page_layout_home_slide_1_03',
        'page_layout_home_slide_1_04',
        'page_layout_home_slide_1_05',
        'page_layout_home_image_slide_1',
        'page_layout_home_image_alt_1',
        'page_layout_home_link_slide_1',
        'page_layout_home_story_visible',
        'page_layout_home_story_image',
        'page_layout_home_story_image_alt_text',
        'page_layout_home_story_label',
        'page_layout_home_story_title',
        'page_layout_home_story_description',
        'page_layout_home_story_button_text',
        'page_layout_home_story_button_link',
    ];

    public function up(): void
    {
        DB::transaction(function (): void {
            $backup = DB::table('systems')->where('key', self::BACKUP_KEY)->value('content');
            if ($backup !== null) {
                $this->apply(json_decode($backup, true, 512, JSON_THROW_ON_ERROR));
                return;
            }

            $groups = json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR);
            $fields = array_merge(...array_values($groups));
            $changes = [];
            foreach (self::FIELDS as $field) {
                $key = 'nafu_home_' . $field;
                $row = DB::table('systems')->where('key', $key)->first(['content']);
                if ($row !== null) {
                    $changes[$key] = [
                        'before' => $row->content,
                        'applied' => (string) $fields[$field]['value'],
                    ];
                }
            }

            DB::table('systems')->insert([
                'key' => self::BACKUP_KEY,
                'content' => json_encode($changes, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->apply($changes);
        });
    }

    public function down(): void
    {
        DB::transaction(function (): void {
            $backup = DB::table('systems')->where('key', self::BACKUP_KEY)->value('content');
            if ($backup === null) {
                return;
            }

            $canDeleteBackup = true;
            foreach (json_decode($backup, true, 512, JSON_THROW_ON_ERROR) as $key => $value) {
                $current = DB::table('systems')->where('key', $key)->value('content');
                if ($current === $value['applied']) {
                    DB::table('systems')->where('key', $key)
                        ->update(['content' => $value['before'], 'updated_at' => now()]);
                } elseif ($current !== $value['before']) {
                    $canDeleteBackup = false;
                }
            }
            if ($canDeleteBackup) {
                DB::table('systems')->where('key', self::BACKUP_KEY)->delete();
            }
        });
    }

    private function apply(array $changes): void
    {
        foreach ($changes as $key => $value) {
            DB::table('systems')->where('key', $key)
                ->where(function ($query) use ($value): void {
                    $query->where('content', $value['before'])->orWhere('content', $value['applied']);
                })
                ->update(['content' => $value['applied'], 'updated_at' => now()]);
        }
    }
};
