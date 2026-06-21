<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'show_code' => true,
            'show_company' => true,
            'show_phone' => true,
            'show_address' => true,
            'show_maps' => true,
        ]);
    }
}
