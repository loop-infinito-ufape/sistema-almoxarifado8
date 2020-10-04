<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Servidor;
use App\Models\TipoEquipamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantidade = $this->faker->randomDigitNotNull;
        $agora = date('d/m/Y H:i');
        return [
            'descricao'=>$this->faker->text,
            'quantidade_pedida'=>$quantidade,
            'quantidade_despachadada' => $quantidade,
            'data_inicial' =>$agora,
            'status' => 0,
            'observacao' => $this->faker->text,
            'servidor_id' => Servidor::factory()->create(),
            'tipo_equipamento_id' => TipoEquipamento::factory()->create()
        ];
    }
}
