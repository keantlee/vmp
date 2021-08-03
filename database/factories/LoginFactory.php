<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
// use App\Modules\Login\Models\Login;
use App\Models\Login;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class LoginFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Login::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => Uuid::uuid4(),
            'agency' => $this->faker->randomElement(array(1, 2, 3, 4, 5)),
            'agency_loc' => $this->faker->randomElement(array('CO', 'RFO')),
            'username' => $this->faker->userName,
            'password' => bcrypt('secret'),
            'password_reset_status' => 0,
            'email' => $this->faker->unique()->safeEmail(),
            'geo_code' => DB::table('geo_map')->select('geo_code')->get('geo_code')->random()->geo_code,
            'reg' => DB::table('geo_map')->select('reg_code')->get('reg_code')->random()->reg_code,
            'prov' => DB::table('geo_map')->select('prov_code')->get('prov_code')->random()->prov_code,
            'mun' => DB::table('geo_map')->select('mun_code')->get('mun_code')->random()->mun_code,
            'bgy' => DB::table('geo_map')->select('bgy_code')->get('bgy_code')->random()->bgy_code,
            'first_name' =>$this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'ext_name' => $this->faker->randomElement(array('JR', 'SR', NULL,)),
            'contact_no' => $this->faker->phoneNumber,
        ];
    }
}
