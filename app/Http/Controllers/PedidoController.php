<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Servidor;
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
            $pedidos = $request->session()->get('pedidos');
            foreach ($pedidos as $pedido) {
                PedidoValidator::validate($pedido);
                Pedido::create($pedido);
            }
            $mensagem = '';
            if(count($pedidos) > 0) {
                $mensagem = 'Pedido(s) adicionados';
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

        if(array_key_exists($id, $pedidos)) {
            $pedidos[$id]['quantidade_pedida'] = $request->quantidade_pedida;
            $pedidos[$id]['descricao'] = $request->descricao;
        } else {
            $dados = $request->all();
            $tipo_equipamento = TipoEquipamento::find($id);
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
        }

        $request->session()->put('pedidos', $pedidos);

        $tiposEquipamentos = TipoEquipamento::all();

        return view('formCadastrarPedido')->with([
                "tiposEquipamentos" => $tiposEquipamentos,
                "quantidade_pedida" => '',
                "descricao" => '',
                "tipo_equipamento_id" => '',
                "mensagem" => '',
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
}
