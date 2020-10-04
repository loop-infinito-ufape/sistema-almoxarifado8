<?php

namespace App\Http\Controllers;

use App\Models\TipoEquipamento;
use App\Validator\TipoEquipamentoValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;

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
}
