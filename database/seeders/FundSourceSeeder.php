<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FundSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\FundSource::factory(20)->create();
    }
}
