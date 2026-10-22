<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create databases first
         */
        $this->call(RolePermissionSeeder::class);
        $this->call(AdminRoleSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(HomepageSeeder::class);
        $this->call(PageContentSeeder::class);

        $this->call(SettingSeeder::class);
        $this->call(CompanySettingsSeeder::class);
        $this->call(SampleProductsSeeder::class);
        // $this->call(BranchesTableSeeder::class);
    }
}
