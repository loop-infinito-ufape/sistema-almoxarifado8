<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Validator\SalaValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    public function prepararCadastro(){
        return view("formCadastrarSala");
    }
    public function cadastrar(Request $request){
        try {
            SalaValidator::validate($request->all());
            $dados = $request->all();
            Sala::create($dados);
            return "Sala criada";
        }catch (ValidationException $exception){
            return redirect(route('sala.criar'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
}
