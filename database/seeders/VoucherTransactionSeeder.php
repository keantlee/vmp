<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VoucherTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\VoucherTransaction::factory(50)->create();
    }
}
