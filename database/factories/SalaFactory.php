<?php

namespace Database\Factories;

use App\Models\Sala;
use Illuminate\Database\Eloquent\Factories\Factory;
use function GuzzleHttp\Psr7\str;

class SalaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sala::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sala = strval($this->faker->randomLetter).strval($this->faker->randomDigitNotNull);
        $ramal = strval($this->faker->randomDigitNotNull).strval($this->faker->randomDigitNotNull).strval($this->faker->randomDigitNotNull);
        $predio = "professores".strval($this->faker->randomDigitNotNull);
        return [
            'nome' =>$sala,
            'ramal'=>$ramal,
            'predio'=>$predio
        ];
    }
}
