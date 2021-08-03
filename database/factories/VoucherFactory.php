<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Voucher;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class VoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Voucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'voucher_id' => Uuid::uuid4(),
            'rsbsa_no' => Uuid::uuid4(),
            'control_no' => Uuid::uuid4(),
            'reference_no' => Uuid::uuid4(),
            'program_id' => $this->faker->randomElement(array('212a7b35-b251-48a6-9928-3f689321d8b1', '42383225-3a4e-4e18-8cda-deed9a62775f', '9fdb5700-6534-4133-8624-f321afb249cf')),
            'fund_id' => DB::table('fund_source')->select('fund_id')->get('fund_id')->random()->fund_id,
            'type' => 'Commonwealth',
            'first_name' =>$this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'ext_name' => $this->faker->randomElement(array('JR', 'SR', NULL,)),
            'sex' => $this->faker->randomElement(array('MALE', 'FEMALE')),
            'birthday' => '',
            'birth_place' => '',
            'mother_maiden' => $this->faker->firstName.' '.$this->faker->lastName.' '.$this->faker->lastName,
            'contact_no' => $this->faker->phoneNumber,
            'civil_status' => $this->faker->randomElement(array(1, 0)),
            'geo_code' => DB::table('geo_map')->select('geo_code')->get('geo_code')->random()->geo_code,
            'reg' => DB::table('geo_map')->select('reg_code')->get('reg_code')->random()->reg_code,
            'prv' => DB::table('geo_map')->select('prov_code')->get('prov_code')->random()->prov_code,
            'mun' => DB::table('geo_map')->select('mun_code')->get('mun_code')->random()->mun_code,
            'brgy' => DB::table('geo_map')->select('bgy_code')->get('bgy_code')->random()->bgy_code,
            'farm_area' => NULL,
            'seed_class' => $this->faker->randomElement(array(1, 0)),
            'sub_project' => $this->faker->randomElement(array(1, 0)),
            'rrp_fertilizer_kind' => $this->faker->randomElement(array('YES', 'NO')),
            'amount' => $this->faker->numberBetween($min = 1000, $max = 20000),
            'encode_agency' => DB::table('agency')->select('agency_shortname')->get('agency_shortname')->random()->agency_shortname,
            'encoded_by_id' => Uuid::uuid4(),
            'encoded_by_fullname' => $this->faker->firstName.' '.$this->faker->lastName.' '.$this->faker->lastName,
        ];
    }
}
