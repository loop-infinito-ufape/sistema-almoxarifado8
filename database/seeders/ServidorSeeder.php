<?php

namespace Database\Seeders;

use App\Models\Servidor;
use Illuminate\Database\Seeder;

class ServidorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servidor::factory()->count(5)->create();
    }
}
