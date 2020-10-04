<?php

use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\TipoEquipamentoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//funcionario
Route::get('funcionario/cadastrar', [FuncionarioController::class, 'prepararCadastro']);
Route::post('funcionario/cadastrar', [FuncionarioController::class, 'cadastrar'])->name('funcionario.criar');

//servidor
Route::get('servidor/cadastrar', [ServidorController::class, 'prepararCadastro']);
Route::post('servidor/cadastrar', [ServidorController::class, 'cadastrar'])->name('servidor.criar');

//sala
Route::get('sala/cadastrar', [SalaController::class, 'prepararCadastro']);
Route::post('sala/cadastrar', [SalaController::class, 'cadastrar'])->name('sala.criar');

//Tipo Equipamento
Route::get('tipoEquipamento/cadastrar', [TipoEquipamentoController::class, 'prepararCadastro']);
Route::post('tipoEquipamento/cadastrar', [TipoEquipamentoController::class, 'cadastrar'])->name('tipoEquipamento.criar');
