<?php

namespace App\Http\Controllers;

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
    public function prepararCadastro(){
        $tiposEquipamentos = TipoEquipamento::all();

        //to passando um array com todos os servidores pra validacao.
        //remover quando adicionar autenticacao
        $Servidores = Servidor::all();
        return view("formCadastrarPedido")->with([
            "tiposEquipamentos" => $tiposEquipamentos,
            "Servidores" => $Servidores
        ]);
    }
    public function cadastrar(Request $request){
        try {
            PedidoValidator::validate($request->all());
            $dados = $request->all();
            $dados['quantidade_despachadada'] = 0;
            $dados['data_inicial'] = Date::now();
            $dados['status'] = 0;

            Pedido::create($dados);
            return "Pedido criada";
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
}
