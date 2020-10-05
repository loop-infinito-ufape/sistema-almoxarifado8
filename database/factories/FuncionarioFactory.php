<?php

namespace Database\Factories;

use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class FuncionarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Funcionario::class;

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

        return [
            'nome' => $this->faker->name,
            'cpf' => $this->faker->cpf(false),
            'telefone' => $telefone,
            'email' => $this->faker->unique()->freeEmail,
            'senha' => Hash::make('password')
        ];
    }
}
