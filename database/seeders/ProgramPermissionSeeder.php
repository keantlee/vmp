<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProgramPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ProgramPermission::factory(10)->create();
    }
}
