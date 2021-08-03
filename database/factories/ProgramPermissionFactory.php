<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProgramPermission;

class ProgramPermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProgramPermission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => $this->faker->randomElement(array(1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17)),
            'program_id' => $this->faker->randomElement(array('212a7b35-b251-48a6-9928-3f689321d8b1', '42383225-3a4e-4e18-8cda-deed9a62775f', '9fdb5700-6534-4133-8624-f321afb249cf')),
            'user_id' => DB::table('users')->select('user_id')->get()->random()->user_id,
            'other_info' => $this->faker->randomElement(array('cc738261-5944-48a2-86da-612dd32dcdce', 'd348516e-b7d0-4712-8e65-a2cb75071e5f')),
            'status' => 1,
            'permitted_by_agency' => null,
            'permitted_by_id' => null,
            'permitted_by_fullname' => null,
        ];
    }
}
