<?php


namespace App\Validator;
use App\Models\Sala;
use Illuminate\Support\Facades\Validator;

class SalaValidator
{
    public static function validate($data){
        $validator = Validator::make($data, Sala::$rules, Sala::$messages);

        if(!$validator->errors()->isEmpty()){
            throw new ValidationException($validator, "Erro na validação de sala");
        }else{
            return $validator;
        }
    }

}
