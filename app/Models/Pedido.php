<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    public function funcionario(){
    	return $this->belongsTo('app\Models\Funcionario');
    } 

    public function servidor(){
    	return $this->belongsTo('app\Models\Servidor');
    }

    public function tipoEquipamento(){
    	return $this->belongsTo('app\Models\TipoEquipamento');
    }

    public function patrimonio(){
        return $this->hasMany('app\Models\Patrimonio');
    }

     public function pedidoAnterior(){
        return $this->belongsTo('app\Models\Pedido');
    }
}
