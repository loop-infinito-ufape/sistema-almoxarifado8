<?php

namespace Database\Factories;

use App\Models\Sala;
use App\Models\Servidor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ServidorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Servidor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $if = strval($this->faker->randomDigit).strval($this->faker->randomDigit).strval($this->faker->randomDigit);
        return [
            'if' => $if,
            'sala_id' => Sala::factory()->create(),
            'user_id' => User::factory()->create()
        ];
    }
}
