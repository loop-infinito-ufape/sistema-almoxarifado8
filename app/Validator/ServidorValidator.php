<?php


namespace App\Validator;
use App\Models\Servidor;
use Illuminate\Support\Facades\Validator;


class ServidorValidator
{
    public static function validate($data){
        $validator = Validator::make($data, Servidor::$rules, Servidor::$messages );

        if(!$validator->errors()->isEmpty()){
            throw new ValidationException($validator, "Erro na validação do Servidor");
        }else{
            return $validator;
        }
    }
}
