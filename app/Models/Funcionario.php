<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Funcionario extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['cpf',];

    public static $rules = ['cpf' => 'required|cpf'];

    public static $messages = [//'nome.*' => "O campo deve contêr entre 10 e 100 caracteres.",
                                'cpf.*'=> "CPF inválido.",
                              //  'telefone.*'=> "Telefone inválido.",
                              //  'email.*'=> "Email inválido.",
                              //  'senha.*'=> "Senha deve ter no mínimo 8 caracteres."
        ];

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }

    public function user(){
        return $this->belongsTo('app\Models\User');
    }

}
