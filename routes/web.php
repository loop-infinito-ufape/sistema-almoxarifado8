<?php

use App\Http\Controllers\Auth\FuncionarioRegisterController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\PatrimonioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\TipoEquipamentoController;
use Illuminate\Support\Facades\Auth;
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
//Route::get('funcionario/cadastrar', [FuncionarioController::class, 'prepararCadastro']);
//Route::post('funcionario/cadastrar', [FuncionarioController::class, 'cadastrar'])->name('funcionario.criar');

//servidor
//Route::get('servidor/cadastrar', [ServidorController::class, 'prepararCadastro']);
//Route::post('servidor/cadastrar', [ServidorController::class, 'cadastrar'])->name('servidor.criar');

//sala
Route::get('sala/cadastrar', [SalaController::class, 'prepararCadastro']);
Route::post('sala/cadastrar', [SalaController::class, 'cadastrar'])->name('sala.criar');

//Tipo Equipamento
Route::get('tipoEquipamento/cadastrar', [TipoEquipamentoController::class, 'prepararCadastro']);
Route::post('tipoEquipamento/cadastrar', [TipoEquipamentoController::class, 'cadastrar'])->name('tipoEquipamento.criar');

//Patrimonio
Route::get('patrimonio/cadastrar', [PatrimonioController::class, 'prepararCadastro']);
Route::post('patrimonio/cadastrar', [PatrimonioController::class, 'cadastrar'])->name('patrimonio.criar');

//Patrimonio
Route::get('pedido/cadastrar', [PedidoController::class, 'prepararCadastro']);
Route::post('pedido/cadastrar', [PedidoController::class, 'cadastrar'])->name('pedido.criar');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/funcionarioRegister', [FuncionarioRegisterController::class, 'showRegistrationForm']);
Route::post('/funcionarioRegister', [FuncionarioRegisterController::class, 'register'])->name('funcionario.register');


//funcionario
Route::get('/funcionario/editar', [FuncionarioController::class, 'prepararEditar'])->middleware('auth');
Route::post('/funcionario/editar', [FuncionarioController::class, 'editar'])->name('funcionario.editar');
