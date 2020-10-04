<?php

namespace Database\Factories;

use App\Models\Patrimonio;
use App\Models\TipoEquipamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatrimonioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patrimonio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $numero = "";
        for($i = 0; $i < 8; $i++){
            $numero = $numero . strval($this->faker->randomDigit);
        }
        return [
            'numero' => $numero,
            'status'=>0,
            'tipo_equipamento_id' => TipoEquipamento::factory()->create()
        ];
    }
}
