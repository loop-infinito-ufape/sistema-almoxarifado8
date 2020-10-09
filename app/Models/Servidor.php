<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Servidor extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['if', 'user_id', 'sala_id'];

    public static $rules = ['name' => 'required|min:10|max:100',
                           'telefone' => 'required|size:11',
                            'if' => 'required|numeric',
                            'sala_id' => 'nullable|numeric',

    ];

    public static $messages = ['name.*' => "Nome é obrigatório e deve ter até 255 caracteres.",
                                'telefone.*'=> "Telefone inválido.",
                                'if.*'=> "IF inválido.",
                                'sala_id.*'=> "Sala deve ser um valor numérico.",
    ];

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }

    public function sala(){
    	return $this->belongsTo('app\Models\Sala');
    }

    public function user(){
        return $this->belongsTo('app\Models\User');
    }
}
