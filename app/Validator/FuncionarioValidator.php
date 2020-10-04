<?php


namespace App\Validator;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Validator;

class FuncionarioValidator
{
    public static function validate($data){
        $validator = Validator::make($data, Funcionario::$rules, Funcionario::$messages);

        if(!$validator->errors()->isEmpty()){
            throw new ValidationException($validator, "Erro na validação do Funcionario");
        }else{
            return $validator;
        }
    }
}
