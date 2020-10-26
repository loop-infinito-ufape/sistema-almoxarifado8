<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Servidor;
use App\Models\Patrimonio;
use App\Models\User;
use App\Models\TipoEquipamento;
use App\Validator\PedidoValidator;
use App\Validator\ValidationException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

//pegar a data/hora do brasil
date_default_timezone_set('America/Sao_Paulo');

class PedidoController extends Controller
{
    public function prepararCadastro(Request $request){
        $tiposEquipamentos = TipoEquipamento::all();
        $request->session()->put('pedidos', []);

        return view("formCadastrarPedido")->with([
            "tiposEquipamentos" => $tiposEquipamentos,
            "quantidade_pedida" => '',
            "descricao" => '',
            "tipo_equipamento_id" => '',
            "mensagem" => '',
        ]);
    }

    // salva no banco de dados os pedidos
    public function cadastrar(Request $request){
        try {
            $mensagem = '';
            $pedidos = $request->session()->get('pedidos');
            if ($pedidos) {
                foreach ($pedidos as $pedido) {
                    PedidoValidator::validate($pedido);
                    Pedido::create($pedido);
                    // $tipo_equipamento = TipoEquipamento::find($pedido['tipo_equipamento_id']);
                    // $tipo_equipamento['quantidade'] = $tipo_equipamento['quantidade'] - $pedido['quantidade_pedida'];
                    // $tipo_equipamento->save();
                }
                if(count($pedidos) > 0) {
                    $mensagem = 'Pedido(s) adicionados';
                }
            }
            $request->session()->put('pedidos', []);
            $tiposEquipamentos = TipoEquipamento::all();
            return view("formCadastrarPedido")->with([
                "tiposEquipamentos" => $tiposEquipamentos,
                "quantidade_pedida" => '',
                "descricao" => '',
                "tipo_equipamento_id" => '',
                "mensagem" => $mensagem,
            ]);
        }catch (ValidationException $exception){
            $tiposEquipamentos = TipoEquipamento::all();

            //to passando um array com todos os servidores pra validacao.
            //remover quando adicionar autenticacao
            $Servidores = Servidor::all();
            return redirect(route('pedido.criar'))
                ->with(["tiposEquipamentos" => $tiposEquipamentos,
                        "Servidores" => $Servidores
                ])
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }

    // salva na lista temporaria, mas não salva no banco de dados
    public function cadastrarTemporariamente(Request $request) {
        if($request->session()->has('pedidos')) {
            $pedidos = $request->session()->get('pedidos');
        } else {
            $pedidos = array();
        }
        $id = $request->tipo_equipamento_id;

        $mensagem = '';

        if(array_key_exists($id, $pedidos)) {
            $pedidos[$id]['quantidade_pedida'] += $request->quantidade_pedida;
            $pedidos[$id]['descricao'] = $request->descricao;
        } else {
            $dados = $request->all();
            $tipo_equipamento = TipoEquipamento::find($id);
            if ($dados['quantidade_pedida'] <= $tipo_equipamento['quantidade']) {
                $pedido = array(
                    'quantidade_despachadada' => 0,
                    'data_inicial' => Date::now(),
                    'status' => 0,
                    'servidor_id' => Servidor::getServidorPorIdUser(Auth::user()->id),
                    'descricao' => $dados['descricao'],
                    'quantidade_pedida' => $dados['quantidade_pedida'],
                    'tipo_equipamento_id' => $dados['tipo_equipamento_id'],
                    'nome_equipamento' => $tipo_equipamento->nome,
                );
                $pedidos[$id] = $pedido;
            } else {
                $mensagem = 'Error: Não temos a quantidade suficiente desse produto';
            }
        }

        $request->session()->put('pedidos', $pedidos);

        $tiposEquipamentos = TipoEquipamento::all();

        return view('formCadastrarPedido')->with([
                "tiposEquipamentos" => $tiposEquipamentos,
                "quantidade_pedida" => '',
                "descricao" => '',
                "tipo_equipamento_id" => '',
                "mensagem" => $mensagem,
            ]);;
    }

    // edita um pedido da lista temporaria
    public function editar(Request $request) {
        $tiposEquipamentos = TipoEquipamento::all();
        $dados = $request->all();
        return view('formCadastrarPedido')->with([
            "quantidade_pedida" => $dados['quantidade_pedida'],
            "descricao" => $dados['descricao'],
            "tipo_equipamento_id" => $dados['tipo_equipamento_id'],
            "tiposEquipamentos" => $tiposEquipamentos,
            "mensagem" => '',
        ]);;
    }

    public function listarPedidosPendentes(){
        $pedidos = Pedido::all();
        $pedidosAux = [];

        foreach ($pedidos as $pedido) {
            if($pedido['status'] == 0 || $pedido['status'] == 1) {
                $tipo_equipamento = TipoEquipamento::find($pedido['tipo_equipamento_id']);
                $pedidoAux = null;
                if(isset(Auth::user()->servidor)) {
                    $pedidoAux = array(
                        'data_inicial' => $pedido['data_inicial'],
                        'quantidade' => $pedido['quantidade_pedida'],
                        'nome_equipamento' => $tipo_equipamento->nome,
                    );
                } else {
                    $servidor = Servidor::find($pedido['servidor_id']);
                    $user = User::find($servidor->user_id);
                    $pedidoAux = array(
                        'id_pedido' => $pedido['id'],
                        'id_equipamento' => $pedido['tipo_equipamento_id'],
                        'descricao' => $pedido['descricao'],
                        'data_inicial' => $pedido['data_inicial'],
                        'quantidade' => $pedido['quantidade_pedida'],
                        'nome_equipamento' => $tipo_equipamento->nome,
                        'nome_servidor' => $user->name,
                        'status' => $pedido['status'] == 0 ? 'Pendente' : 'Parcial',
                    );
                }
                array_push($pedidosAux, $pedidoAux);
            }
        }

        if(isset(Auth::user()->servidor)) {
            return view("servidor.listarPedidosPendentes")->with([
                "pedidos" => $pedidosAux,
            ]);
        } else {
            return view("funcionario.listarPedidosPendentes")->with([
                "pedidos" => $pedidosAux,
            ]);
        }
    }

    public function listarPedidosConcluidos(){
        $pedidos = Pedido::all();
        $pedidosAux = [];

        foreach ($pedidos as $pedido) {
            if($pedido['status'] == 2) {
                $tipo_equipamento = TipoEquipamento::find($pedido['tipo_equipamento_id']);
                $pedidoAux = null;
                if(isset(Auth::user()->servidor)) {
                    $pedidoAux = array(
                        'data_final' => $pedido['data_final'],
                        'data_inicial' => $pedido['data_inicial'],
                        'quantidade' => $pedido['quantidade_pedida'],
                        'nome_equipamento' => $tipo_equipamento->nome,
                    );
                } else {
                    $servidor = Servidor::find($pedido['servidor_id']);
                    $user = User::find($servidor->user_id);
                    $pedidoAux = array(
                        'data_final' => $pedido['data_final'],
                        'data_inicial' => $pedido['data_inicial'],
                        'quantidade' => $pedido['quantidade_pedida'],
                        'nome_equipamento' => $tipo_equipamento->nome,
                        'nome_servidor' => $user->name,
                    );
                }
                array_push($pedidosAux, $pedidoAux);
            }
        }

        if(isset(Auth::user()->servidor)) {
            return view("servidor.listarPedidosConcluidos")->with([
                "pedidos" => $pedidosAux,
            ]);
        } else {
            return view("funcionario.listarPedidosConcluidos")->with([
                "pedidos" => $pedidosAux,
            ]);
        }
    }

    public function prepararFinalizacaoPedido(Request $request){
        $dados = $request->all();
        $patrimonios = Patrimonio::getPatrimoniosPorIdEquipamento($dados['id_equipamento']);
        return view('formFinalizarPedido')->with([
            "id_pedido" => $dados['id_pedido'],
            "id_equipamento" => $dados['id_equipamento'],
            "nome_equipamento" => $dados['nome_equipamento'],
            "quantidade_solicitada" => $dados['quantidade'],
            "descricao" => $dados['descricao'],
            "patrimonios" => $patrimonios,
            "mensagem" => '',
        ]);
    }

    public function concluirFinalizacaoPedido(Request $request){
        $dados = $request->all();
        $pedido = Pedido::find($dados['id_pedido']);
        $tipo_equipamento = TipoEquipamento::find($dados['id_equipamento']);
        $mensagem = '';

        if ($pedido->status == 2) {
            $mensagem = 'Error: Esse pedido já foi concluído';
        }
        elseif ($dados['quantidade_enviada'] > $tipo_equipamento['quantidade']) {
            $mensagem = 'Error: Temos apenas ' . $tipo_equipamento['quantidade'] . ' unidades desse equipamento';
        } else {
            if ($pedido->quantidade_pedida == $dados['quantidade_enviada']) {
                $tipo_equipamento['quantidade'] = $tipo_equipamento['quantidade'] - $pedido->quantidade_pedida;
                $tipo_equipamento->save();
                $pedido->status = 2;
                $pedido->observacao = $dados['resposta_pedido'];
                $pedido->quantidade_despachadada = $pedido->quantidade_pedida;
                $pedido->data_final = Date::now();
                $pedido->save();
            } else {
                $tipo_equipamento['quantidade'] = $tipo_equipamento['quantidade'] - $dados['quantidade_enviada'];
                $tipo_equipamento->save();

                $novo_pedido = array(
                    'quantidade_despachadada' => $dados['quantidade_enviada'],
                    'data_inicial' => $pedido->data_inicial,
                    'data_final' => Date::now(),
                    'status' => 2,
                    'servidor_id' => $pedido->servidor_id,
                    'descricao' => $pedido['descricao'],
                    'quantidade_pedida' => $dados['quantidade_enviada'],
                    'tipo_equipamento_id' => $dados['id_equipamento'],
                    'observacao' => $dados['resposta_pedido'],
                    'pedido_anterior_id' => $dados['id_pedido'],
                );
                Pedido::create($novo_pedido);

                $pedido->status = 1;
                $pedido->quantidade_pedida = $pedido->quantidade_pedida - $dados['quantidade_enviada'];
                $pedido->save();
            }

            $mensagem = "Operação concluída com sucesso";
        }

        $patrimonios = Patrimonio::getPatrimoniosPorIdEquipamento($dados['id_equipamento']);
        return view('formFinalizarPedido')->with([
            "id_pedido" => $dados['id_pedido'],
            "id_equipamento" => $dados['id_equipamento'],
            "nome_equipamento" => $tipo_equipamento->nome,
            "quantidade_solicitada" => $pedido->quantidade_pedida,
            "descricao" => $pedido['descricao'],
            "patrimonios" => $patrimonios,
            "mensagem" => $mensagem,
        ]);
    }
}
