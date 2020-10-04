<?php


namespace App\Validator;
use App\Models\TipoEquipamento;
use Illuminate\Support\Facades\Validator;

class TipoEquipamentoValidator
{
    public static function validate($data){
        $validator = Validator::make($data, TipoEquipamento::$rules, TipoEquipamento::$messages);

        if(!$validator->errors()->isEmpty()){
            throw new ValidationException($validator, "Erro na validação de Tipo de Equipamento");
        }else{
            return $validator;
        }
    }
}
