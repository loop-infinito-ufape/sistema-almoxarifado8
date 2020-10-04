<?php

namespace Database\Seeders;

use App\Models\TipoEquipamento;
use Illuminate\Database\Seeder;

class TipoEquipamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEquipamento::factory()->count(5)->create();
    }
}
