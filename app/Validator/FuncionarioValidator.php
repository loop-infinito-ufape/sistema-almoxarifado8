<?php


namespace App\Validator;
use Illuminate\Support\Facades\Validator;

class FuncionarioValidator
{
    public static function validate($data){
        $validator = Validator::make($data, \App\Models\Funcionario::$rules, \app\Models\Funcionario::$messages);

        //validacao de cpf

        if(!$validator->errors()->isEmpty()){
            throw new ValidationException($validator, "Erro na validação do Funcionario");
        }else{
            return $validator;
        }
    }
}
