<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;



class Funcionario extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['nome', 'cpf', 'telefone', 'email', 'senha'];

    public static $rules = ['nome' => 'required|min:10|max:100',
                            'cpf' => 'required|cpf',
                            'telefone' => 'required|size:11',
                            'email' => 'required|email',
                            'senha' => 'required|min:8'
        ];

    public static $messages = ['nome.*' => "O campo deve contêr entre 10 e 100 caracteres.",
                                'cpf.*'=> "CPF inválido.",
                                'telefone.*'=> "Telefone inválido.",
                                'email.*'=> "Email inválido.",
                                'senha.*'=> "Senha deve ter no mínimo 8 caracteres."
        ];

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }


}
