<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FundSource;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FundSourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FundSource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fund_id' => Uuid::uuid4(),
            'program_id' => $this->faker->randomElement(array('212a7b35-b251-48a6-9928-3f689321d8b1', '42383225-3a4e-4e18-8cda-deed9a62775f', '9fdb5700-6534-4133-8624-f321afb249cf')),
            'fund_name' => $this->faker->company,
            'fund_cluster' => $this->faker->company,
            'amount' => $this->faker->numberBetween($min = 1000000, $max = 20000000),
            'reg' => DB::table('geo_map')->select('reg_code')->get('reg_code')->random()->reg_code,
            'particulars' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
