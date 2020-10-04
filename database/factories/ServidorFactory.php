<?php

namespace Database\Factories;

use App\Models\Sala;
use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $telefone = "";
        for($i = 0; $i < 11; $i++){
            $telefone = $telefone . strval($this->faker->randomDigit);
        }
        $if = strval($this->faker->randomDigit).strval($this->faker->randomDigit).strval($this->faker->randomDigit);
        return [
            'nome'=>$this->faker->name,
            'cpf' => $this->faker->cpf(false),
            'telefone' => $telefone,
            'email' => $this->faker->unique()->freeEmail,
            'senha' => $this->faker->password(8,200),
            'if' => $if,
            'sala_id' => Sala::factory()->create()
        ];
    }
}
