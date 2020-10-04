<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Validator\FuncionarioValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FuncionarioController extends Controller
{
    //carregar a pagina
    public function prepararCadastro(){
        return view ("formCadastrarFuncionario");
    }

    //cadastrar o usuario
    public function cadastrar(Request $request){
        try {
            FuncionarioValidator::validate($request->all());
            $dados = $request->all();
            $dados['senha'] = Hash::make($dados['senha']);
            //dd($dados);
            Funcionario::create($dados);
            return "Funcionario criado";
        }catch (ValidationException $exception){
            return redirect('cadastrar')
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
}
