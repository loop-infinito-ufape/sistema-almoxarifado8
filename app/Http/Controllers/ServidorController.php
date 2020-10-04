<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use App\Validator\ServidorValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ServidorController extends Controller
{
    //carregar a pagina
    public function prepararCadastro(){
        return view ("formCadastrarServidor");
    }

    //cadastra servidor
    public function cadastrar(Request $request){
        try {
            ServidorValidator::validate($request->all());
            $dados = $request->all();
            $dados['senha'] = Hash::make($dados['senha']);
            Servidor::create($dados);
            return "Servidor criado";
        }catch (ValidationException $exception){
            return redirect(route('servidor.criar'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
}
