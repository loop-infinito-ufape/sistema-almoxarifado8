<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatrimoniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->integer('status');
            
            $table->integer('pedido_id')->unsigned()->nullable();
            $table->integer('tipo_equipamento_id')->unsigned();

            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('tipo_equipamento_id')->references('id')->on('tipo_equipamentos');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrimonios');
    }
}
