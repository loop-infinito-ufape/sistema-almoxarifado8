<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Servidor extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['nome', 'cpf', 'telefone', 'if', 'sala_id', 'email', 'senha'];

    public static $rules = ['nome' => 'required|min:10|max:100',
                            'cpf' => 'required|cpf',
                            'telefone' => 'required|size:11',
                            'if' => 'required|numeric',
                            'sala_id' => 'nullable|numeric',
                            'email' => 'required|email',
                            'senha' => 'required|min:8'

    ];

    public static $messages = ['nome.*' => "O campo deve contêr entre 10 e 100 caracteres.",
                                'cpf.*'=> "CPF inválido.",
                                'telefone.*'=> "Telefone inválido.",
                                'if.*'=> "IF inválido.",
                                'sala_id.*'=> "Sala deve ser um valor numérico.",
                                'email.*'=> "Email inválido.",
                                'senha.*'=> "Senha deve ter no mínimo 8 caracteres."
    ];

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }

    public function sala(){
    	return $this->belongsTo('app\Models\Sala');
    }
}
