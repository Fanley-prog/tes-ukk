<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\templates;
use App\Models\websites;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'password' => '123',
            'role' => 'superadmin',
        ]);

        templates::create([
            'id_template' => 1,
            'name_template' => 'Template 1'
        ]);
    }
}
