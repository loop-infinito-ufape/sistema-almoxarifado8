<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use App\Models\TipoEquipamento;
use App\Validator\TipoEquipamentoValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;

class TipoEquipamentoController extends Controller
{
    public function prepararCadastro(){
        return view("formCadastrarTipoEquipamento");
    }
    public function cadastrar(Request $request){
        try {
            TipoEquipamentoValidator::validate($request->all());
            $dados = $request->all();
            TipoEquipamento::create($dados);
            return "Tipo Equpamento criado";
        }catch (ValidationException $exception){
            return redirect(route('tipoEquipamento.criar'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
    public function listar(){
        $tipos =  TipoEquipamento::all();
        return view('listarEquipamentos',['tipos'=>$tipos]);
    }
    public function adicionar(Request $request){
        $tipo =  TipoEquipamento::find($request->tipo_id);
        $tipo->quantidade = $tipo->quantidade + $request->quantidade;
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        } else {
            $numeros = array();
        }
        foreach ($numeros as $numero){
            $patrimonio = new Patrimonio();
            $patrimonio->tipo_equipamento_id = $tipo->id;
            $patrimonio->numero = $numero;
            $patrimonio->status = 0;
            $patrimonio->save();
        }
        $tipo->save();
        $numeros = [];
        $request->session()->put('lista',$numeros);
        return redirect(route('listarEquipamentos'));
    }
    public function prepararAdicionar(Request $request){
        $tipos =  TipoEquipamento::all();
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        } else {
            $numeros = array();
        }
        //$numeros = [];
        $request->session()->put('lista',$numeros);
        return view('adicionarEquipamento',['tipos'=>$tipos]);
        //return view('adicionarEquipamento',['tipos'=>$tipos]);
    }
    public function anexar(Request $request){
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        } else {
            $numeros = array();
        }
        //$numeros = [];
        array_push($numeros,$request->numero);
        $request->session()->put('lista',$numeros);
        $tipos =  TipoEquipamento::all();
        //return view('adicionarEquipamento',['tipos'=>$tipos]);
        return redirect(route('prepararAdicionar'));
    }
    public function remover(Request $request){
        if($request->session()->has('lista')){
            $numeros = $request->session()->get('lista');
        }
        $id = $request->id;
        if(array_key_exists($id,$numeros)){
            unset($numeros[$id]);
        }
        $request->session()->put('lista',$numeros);
        return redirect(route('prepararAdicionar'));
    }
}
