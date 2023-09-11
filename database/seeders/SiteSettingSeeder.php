<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SiteSettingEloquentModel;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSettingEloquentModel::insert([
            'site_name'  => 'Tiggie Kids',
            'ssl' => '',
            'site_time_zone' => 'UTC',
            'site_locale' => 'locale',
            'email' => 'admin@tiggiekid.com',
            'contact_number' => '6512345678',
            'url' => 'https://tiggiekid.com',
            'website_logo' => '',
            'website_favicon' => ''
        ]);
    }
}
