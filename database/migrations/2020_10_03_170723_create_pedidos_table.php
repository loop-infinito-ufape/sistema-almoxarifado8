<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->nullable();
            $table->integer('quantidade_pedida');
            $table->integer('quantidade_despachadada');
            $table->dateTime('data_inicial');
            $table->dateTime('data_final')->nullable();
            $table->integer('status');
            $table->string('observacao')->nullable();
            
            $table->integer('funcionario_id')->unsigned()->nullable();
            $table->integer('servidor_id')->unsigned();
            
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');
            $table->foreign('servidor_id')->references('id')->on('servidors');

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
        Schema::dropIfExists('pedidos');
    }
}
