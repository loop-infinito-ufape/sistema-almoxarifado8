<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
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
use PhpParser\Node\Expr\Array_;

//pegar a data/hora do brasil
date_default_timezone_set('America/Sao_Paulo');

class PedidoController extends Controller
{
    public function prepararCadastro(Request $request){
        $tiposEquipamentos = TipoEquipamento::all();
        if($request->session()->has('pedidos')) {
            $pedidos = $request->session()->get('pedidos');
        } else {
            $pedidos = array();
        }
        $request->session()->put('pedidos',$pedidos);

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
            if (count($pedidos) > 0) {
                $mensagem = 'Pedido(s) adicionados';
            }
        }
        $request->session()->put('pedidos', []);
        $tiposEquipamentos = TipoEquipamento::all();
        return redirect(route('pedido.listar'));
        /*return view("formCadastrarPedido")->with([
            "tiposEquipamentos" => $tiposEquipamentos,
            "quantidade_pedida" => '',
            "descricao" => '',
            "tipo_equipamento_id" => '',
            "mensagem" => $mensagem,
        ]);*/

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
            $pedidos[$id]['quantidade_pedida'] = $request->quantidade_pedida;
            $pedidos[$id]['descricao'] = $request->descricao;
        } else {
            $dados = $request->all();
            $tipo_equipamento = TipoEquipamento::find($id);

            $pedido = array();
            if(isset(Auth::user()->servidor)) {
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
            } else {
                $tipo_equipamento = TipoEquipamento::find($dados['tipo_equipamento_id']);

                $tipo_equipamento['quantidade'] = $tipo_equipamento['quantidade'] - $dados['quantidade_pedida'];
                $tipo_equipamento->save();

                $pedido = array(
                    'quantidade_despachadada' => $dados['quantidade_pedida'],
                    'data_inicial' => Date::now(),
                    'status' => 2,
                    'descricao' => $dados['descricao'],
                    'quantidade_pedida' => $dados['quantidade_pedida'],
                    'tipo_equipamento_id' => $dados['tipo_equipamento_id'],
                    'nome_equipamento' => $tipo_equipamento->nome,
                    'funcionario_id' => Funcionario::getFuncionarioPorIdUser(Auth::user()->id)->id,
                    'data_final' => Date::now(),
                );
            }

            $pedidos[$id] = $pedido;
        }

        $request->session()->put('pedidos', $pedidos);

        $tiposEquipamentos = TipoEquipamento::all();

        return view('formCadastrarPedido')->with([
                "tiposEquipamentos" => $tiposEquipamentos,
                "quantidade_pedida" => '',
                "descricao" => '',
                "tipo_equipamento_id" => '',
                "mensagem" => $mensagem,
            ]);
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
                    if($servidor != null){
                        $user = User::find($servidor->user_id);
                        $pedidoAux = array(
                            'data_final' => $pedido['data_final'],
                            'data_inicial' => $pedido['data_inicial'],
                            'quantidade' => $pedido['quantidade_pedida'],
                            'nome_equipamento' => $tipo_equipamento->nome,
                            'nome_servidor' => $user->name,
                        );
                    }else{
                        $pedidoAux = array(
                            'data_final' => $pedido['data_final'],
                            'data_inicial' => $pedido['data_inicial'],
                            'quantidade' => $pedido['quantidade_pedida'],
                            'nome_equipamento' => $tipo_equipamento->nome,
                            'nome_servidor' => '---',
                        );
                    }

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
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        } else {
            $numeros = array();
        }
        //$numeros = array();
        $request->session()->put('lista',$numeros);
        $dados = $request->all();
        //return $dados;
        $patris = Patrimonio::getPatrimoniosPorIdEquipamento($dados['id_equipamento']);
        $patrimonios = array();
        foreach ($patris as $pat){
            if ($pat->status == 0){
                array_push($patrimonios,$pat);
            }
        }

        return view('formFinalizarPedido')->with([
            "id_pedido" => $dados['id_pedido'],
            "id_equipamento" => $dados['id_equipamento'],
            "nome_equipamento" => $dados['nome_equipamento'],
            "quantidade_solicitada" => $dados['quantidade'],
            "descricao" => $dados['descricao'],
            "patrimonios" => $patrimonios,
            "patrimonios2" => $patris,
            "mensagem" => '',
        ]);
    }

    public function concluirFinalizacaoPedido(Request $request){
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        } else {
            $numeros = array();
        }
        $dados = $request->all();
        $pedido = Pedido::find($dados['id_pedido']);
        $tipo_equipamento = TipoEquipamento::find($dados['id_equipamento']);
        $mensagem = '';

        if ($pedido->status == 2) {
            $mensagem = 'Error: Esse pedido já foi concluído';
        }
        /*elseif ($dados['quantidade_enviada'] > $tipo_equipamento['quantidade']) {
            $mensagem = 'Error: Temos apenas ' . $tipo_equipamento['quantidade'] . ' unidades desse equipamento';
        }*/
        else {
            if ($pedido->quantidade_pedida == $dados['quantidade_enviada']) {
                $tipo_equipamento['quantidade'] = $tipo_equipamento['quantidade'] - $pedido->quantidade_pedida;
                $tipo_equipamento->save();
                $pedido->status = 2;
                $pedido->observacao = $dados['resposta_pedido'];
                $pedido->quantidade_despachadada = $pedido->quantidade_pedida;
                $pedido->data_final = Date::now();
                $pedido->funcionario_id = Funcionario::getFuncionarioPorIdUser(Auth::user()->id)->id;
                $pedido->save();
                if (sizeof($numeros)>0){
                    foreach ($numeros as $numero){
                        $patrimonio = Patrimonio::find($numero);
                        $patrimonio->status = 1;
                        $patrimonio->pedido_id = $dados['id_pedido'];
                        $patrimonio->save();
                    }
                }
                $numeros = [];
                $request->session()->put('lista',$numeros);
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
                    'funcionario_id' => Funcionario::getFuncionarioPorIdUser(Auth::user()->id)->id,

                );
                if (sizeof($numeros)>0){
                    foreach ($numeros as $numero){
                        $patrimonio = Patrimonio::find($numero);
                        $patrimonio->status = 1;
                        $patrimonio->pedido_id = $dados['id_pedido'];
                        $patrimonio->save();
                    }
                }
                $numeros = [];
                $request->session()->put('lista',$numeros);
                Pedido::create($novo_pedido);

                $pedido->status = 1;
                $pedido->quantidade_pedida = $pedido->quantidade_pedida - $dados['quantidade_enviada'];
                $pedido->save();

            }

            $mensagem = "Operação concluída com sucesso";
        }

        $patrimonios = Patrimonio::getPatrimoniosPorIdEquipamento($dados['id_equipamento']);
        return redirect(route('pedido.listapendetes'));
        /*return view('formFinalizarPedido')->with([
            "id_pedido" => $dados['id_pedido'],
            "id_equipamento" => $dados['id_equipamento'],
            "nome_equipamento" => $tipo_equipamento->nome,
            "quantidade_solicitada" => $pedido->quantidade_pedida,
            "descricao" => $pedido['descricao'],
            "patrimonios" => $patrimonios,
            "mensagem" => $mensagem,
        ]);*/

    }
    public function listarMeusPedidos(){
        $pedido = Pedido::All();
        $meusPedidos = array();
        $meuUserId = 0;
        $servidor = Servidor::All();
        for($i = 0; $i <= sizeof($servidor); $i++){
            if($servidor[$i]->user_id == Auth::user()->id){
                $meuUserId = $servidor[$i]->id;
                break;
            }
        }
        for($i =0; $i<sizeof($pedido);$i++){
            if ($pedido[$i]->servidor_id == $meuUserId and $pedido[$i]->status == 0 || $pedido[$i]->status == 1){
                array_push($meusPedidos,$pedido[$i]);
            }
        }

        return view('listarPedidos',['pedidos'=>$meusPedidos]);
    }
    public function listarMeusPedidosConcluidos(){
        $pedido = Pedido::All();
        $meusPedidos = array();
        $meuUserId = 0;
        $servidor = Servidor::All();
        for($i = 0; $i <= sizeof($servidor); $i++){
            if($servidor[$i]->user_id == Auth::user()->id){
                $meuUserId = $servidor[$i]->id;
                break;
            }
        }
        for($i =0; $i<sizeof($pedido);$i++){
            if ($pedido[$i]->servidor_id == $meuUserId and $pedido[$i]->status == 2){
                array_push($meusPedidos,$pedido[$i]);
            }
        }
        return view('listarPedidos',['pedidos'=>$meusPedidos]);
    }
    public function anexarPatrimonio(Request $request){
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        } else {
            $numeros = array();
        }
        array_push($numeros,$request->patrimonios);
        $patrimonio = Patrimonio::find($request->patrimonios);
        $patrimonio->status = 2;
        $patrimonio->save();
        $request->session()->put('lista',$numeros);

        $link = "/pedido/finalizar?quantidade=".strval($request->quantidade_solicitada)
            ."&descricao=".strval($request->descricao)
            ."&id_equipamento=".strval($request->id_equipamento)
            ."&nome_equipamento=".strval($request->nome_equipamento)
            ."&id_pedido=".strval($request->id_pedido);
        return redirect($link);
    }

    public function removerPatrimonio(Request $request){
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        }
        $id = $request->id;

        if(array_key_exists($id,$numeros)){
            $patrimonio = Patrimonio::find(($numeros[$id]));
            $patrimonio->status = 0;
            $patrimonio->save();
            unset($numeros[$id]);
        }
        $request->session()->put('lista',$numeros);

        $pedido = Pedido::find($request->id_pedido);
        $equipamento = TipoEquipamento::find($pedido->tipo_equipamento_id);
        return redirect(route('pedido.prepararfinalizacao',['id_equipamento'=>$pedido->tipo_equipamento_id,'id_pedido'=>$pedido->id,'nome_equipamento'=>$equipamento->nome,'quantidade'=>$pedido->quantidade_pedida,'descricao'=>$equipamento->descricao]));
    }
    public function removerParcial(Request $request){
        if($request->session()->has('pedidos')) {
            $pedidos = $request->session()->get('pedidos');
        } else {
            $pedidos = array();
        }
        $id = $request->id;
        if(array_key_exists($id,$pedidos)){
            unset($pedidos[$id]);
        }
        $request->session()->put('pedidos',$pedidos);
        return redirect(route('pedido.preparar'));

    }
}
