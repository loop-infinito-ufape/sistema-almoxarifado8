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
})->name('welcome');

//sala
Route::get('sala/cadastrar', [SalaController::class, 'prepararCadastro']);
Route::post('sala/cadastrar', [SalaController::class, 'cadastrar'])->name('sala.criar');

//Tipo Equipamento
Route::get('tipoEquipamento/cadastrar', [TipoEquipamentoController::class, 'prepararCadastro'])->name('tipoEquipamento.prepararCriar');
Route::post('tipoEquipamento/cadastrar', [TipoEquipamentoController::class, 'cadastrar'])->name('tipoEquipamento.criar');

//Patrimonio
Route::get('patrimonio/cadastrar', [PatrimonioController::class, 'prepararCadastro']);
Route::post('patrimonio/cadastrar', [PatrimonioController::class, 'cadastrar'])->name('patrimonio.criar');

//Pedido
Route::get('pedido/pedidosconcluidos', [PedidoController::class, 'listarPedidosConcluidos'])->name('pedido.listaconcluidos');
Route::get('pedido/preparar', [PedidoController::class, 'prepararCadastro'])->name('pedido.preparar');
Route::get('pedido/editar', [PedidoController::class, 'editar'])->name('pedido.editar');
Route::get('pedido/cadastrar', [PedidoController::class, 'cadastrar'])->name('pedido.criar');
Route::get('pedido/finalizar', [PedidoController::class, 'prepararFinalizacaoPedido'])->name('pedido.prepararfinalizacao');
Route::post('pedido/finalizar', [PedidoController::class, 'concluirFinalizacaoPedido'])->name('pedido.concluirfinalizacao');
Route::post('pedido/cadastrar', [PedidoController::class, 'cadastrarTemporariamente'])->name('pedido.criarTemporiamente');
Route::get('pedido/parcial/remover/{id}',[PedidoController::class,'removerParcial'])->name('pedido.removerparcial');

//Anexar patrimonios
Route::post('/pedido/finalizar/anexarPatrimonio',[PedidoController::class,'anexarPatrimonio'])->name('patrimonio.anexar');
Route::get('/teste',[PedidoController::class,'teste'])->name('teste');
Route::get('/remover/patrimonio/{id}/{id_pedido}',[PedidoController::class,'removerPatrimonio'])->name('remover.patrimonio');
Auth::routes();

Route::get('/funcionarioRegister', [FuncionarioRegisterController::class, 'showRegistrationForm']);
Route::post('/funcionarioRegister', [FuncionarioRegisterController::class, 'register'])->name('funcionario.register');

//funcionario
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=> 'FuncionarioMiddleware'], function() {

    Route::get('/funcionario/editar', [FuncionarioController::class, 'prepararEditar']);
    Route::post('/funcionario/editar', [FuncionarioController::class, 'editar'])->name('funcionario.editar');
    Route::get('/listar/servidores',[FuncionarioController::class, 'listarServidores'])->name('funcionario.lista.servidor');
    Route::get('/listar/funcionarios',[FuncionarioController::class, 'listarFuncionarios'])->name('funcionario.lista.funcionario');
    Route::get('pedido/pedidospedentes', [PedidoController::class, 'listarPedidosPendentes'])->name('pedido.listapendetes');

});
Route::group(['middleware'=> 'ServidorMiddleware'], function() {
    Route::get('pedido/listar',[PedidoController::class, 'listarMeusPedidos'])->name('pedido.listar');
    Route::get('pedido/concluidos', [PedidoController::class, 'listarMeusPedidosConcluidos'])->name('pedido.concluidos');

});

//servidor
Route::get('/servidor/editar', [ServidorController::class, 'prepararEditar']);
Route::post('/servidor/editar', [ServidorController::class, 'editar'])->name('servidor.editar');

//ListarEquipamento
Route::get('/tipoEquipamento/listar',[TipoEquipamentoController::class,'listar'])->name('listarEquipamentos');

//AdicionarEquipamento
Route::get('/tipoEquipamento/adicionar',[TipoEquipamentoController::class,'prepararAdicionar'])->name('prepararAdicionar');
Route::post('/tipoEquipamento/adicionar',[TipoEquipamentoController::class,'adicionar'])->name('adicionar');
Route::post('/tipoEquipamento/anexar',[TipoEquipamentoController::class,'anexar'])->name('anexar');
Route::get('/tipoEquipamento/remover/{id}',[TipoEquipamentoController::class,'remover'])->name('remover');


//Enviar email
Route::get('/email/{id}',[FuncionarioController::class,'enviarEmail'])->name('enviarEmail');
