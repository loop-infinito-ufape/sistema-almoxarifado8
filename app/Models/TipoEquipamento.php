<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEquipamento extends Model
{
    use HasFactory;

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }

    public function patrimonio(){
    	return $this->hasMany('app\Models\Patrimonio');
    }
}
