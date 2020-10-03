<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrimonio extends Model
{
    use HasFactory;

    public function pedido(){
    	return $this->belongsTo('app\Models\Pedido');
    }

    public function tipoEquipamento(){
    	return $this->belongsTo('app\Models\TipoEquipamento');
    }

}
