<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class CompanySettingsSeeder extends Seeder
{
    public function run()
    {
        $defaults = [
            'company_name' => 'Nafu Services',
            'company_legal_name' => '',
            'company_tax_id' => '',
            'company_email' => 'admin@nafuservices.com',
            'company_hotline' => '0481 818 836',
            'company_address' => '265 Exhibition St, Melbourne VIC 3000',
            'company_tagline' => 'Trusted care for every home',
            'company_logo' => 'assets/nafu/nafu-logo.png',
            'company_footer_description' => 'A local Melbourne team for apartment repairs, painting, flooring and maintenance. Professional service, clear prices and care for every detail.',
            'company_copyright' => '© ' . date('Y') . ' Nafu Home Care. All rights reserved.',
            'company_footer_watermark' => 'Nafu',
        ];

        $legacyDefaults = [
            'company_name' => ['FEB Digi', 'FEB Studio'],
            'company_email' => ['hello@feb.com'],
            'company_hotline' => ['+84 912 345 678'],
            'company_copyright' => ['© 2026 FEB Studio.'],
        ];

        foreach ($defaults as $key => $value) {
            $setting = System::firstOrCreate(
                ['key' => $key],
                ['content' => $value, 'active' => true, 'order' => 10]
            );

            // Replace only known template defaults; preserve custom company data.
            if (in_array($setting->content, $legacyDefaults[$key] ?? [], true)) {
                $setting->update(['content' => $value]);
            }
        }

        app(\App\Support\SystemSettings::class)->forget();
    }
}
