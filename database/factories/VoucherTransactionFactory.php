<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VoucherTransaction;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VoucherTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VoucherTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = $this->faker->randomElement(array(1, 2, 3));
        $amount = $this->faker->randomElement(array(1000, 2000, 3000));

        return [
            'voucher_details_id' => Uuid::uuid4(),
            'reference_no' => DB::table('voucher')->select('reference_no')->get('reference_no')->random()->reference_no,
            'supplier_id' => DB::table('supplier')->select('supplier_id')->get('supplier_id')->random()->supplier_id,
            'sub_program_id' => DB::table('supplier_programs')->select('sub_id')->get('sub_id')->random()->sub_id,
            'fund_id' => DB::table('fund_source')->select('fund_id')->get('fund_id')->random()->fund_id,
            'quantity' => $quantity,
            'amount' => $amount,
            'total_amount' => $quantity * $amount,
            'latitude' => $this->faker->latitude($min = -90, $max = 90) ,
            'longitude' => $this->faker->longitude($min = -180, $max = 180),
            'payout' => 1,
            'payout_date' => Carbon::now('GMT+8'),
        ];
    }
}
