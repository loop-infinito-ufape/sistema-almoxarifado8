<?php


namespace App\Validator;


use App\Models\Patrimonio;
use Illuminate\Support\Facades\Validator;

class PatrimonioValidator
{
    public static function validate($data){
        $validator = Validator::make($data, Patrimonio::$rules, Patrimonio::$messages);

        if(!$validator->errors()->isEmpty()){
            throw new ValidationException($validator, "Erro na validação de patrimoônio");
        }else{
            return $validator;
        }
    }

}
