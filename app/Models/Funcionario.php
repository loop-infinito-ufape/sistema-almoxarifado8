<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Funcionario extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['cpf', 'user_id'];

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }

    public function user(){
        return $this->belongsTo('app\Models\User');
    }

}
