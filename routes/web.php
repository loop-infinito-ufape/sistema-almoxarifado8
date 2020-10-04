<?php

use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\ServidorController;
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
