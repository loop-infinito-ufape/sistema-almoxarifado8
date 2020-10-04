<?php


namespace App\Validator;


use App\Models\Pedido;
use Illuminate\Support\Facades\Validator;

class PedidoValidator
{
    public static function validate($data){
        $validator = Validator::make($data, Pedido::$rules, Pedido::$messages);

        if(!$validator->errors()->isEmpty()){
            throw new ValidationException($validator, "Erro na validação de pedido");
        }else{
            return $validator;
        }
    }
}
