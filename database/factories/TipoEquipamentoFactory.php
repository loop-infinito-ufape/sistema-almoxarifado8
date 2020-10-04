<?php

namespace Database\Factories;

use App\Models\TipoEquipamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoEquipamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoEquipamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->text,
            'quantidade'=>$this->faker->randomDigit
        ];
    }
}
