<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use App\Models\TipoEquipamento;
use App\Validator\PatrimonioValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;

class PatrimonioController extends Controller
{
    public function prepararCadastro(){
        $tiposEquipamentos = TipoEquipamento::all();
        return view("formCadastrarPatrimonio")->with([
            "tiposEquipamentos" => $tiposEquipamentos
        ]);
    }
    public function cadastrar(Request $request){
        try {
            PatrimonioValidator::validate($request->all());
            $dados = $request->all();
            $dados['status'] = 0;
            Patrimonio::create($dados);
            return "Patrimonio criado";
        }catch (ValidationException $exception){
            $tiposEquipamentos = TipoEquipamento::all();
            return redirect(route('patrimonio.criar'))
                ->with(["tiposEquipamentos" => $tiposEquipamentos])
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
}
