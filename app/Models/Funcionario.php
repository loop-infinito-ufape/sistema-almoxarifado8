<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Funcionario extends Model
{
    use HasFactory;

    use Notifiable;

    public static $rules = [
        'name' => ['required', 'string', 'max:255'],
        'telefone' => ['required', 'size:11'],
        'cpf' => ['required', 'cpf'],
    ];

    public static $messages = [
        'name.*' => "Nome é obrigatório e deve ter até 255 caracteres.",
        'telefone.*' => "Telefone inválido",
        'cpf.*' => "CPF inválido",
    ];

    protected $fillable = ['cpf', 'user_id'];

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }

    public function user(){
        return $this->belongsTo('app\Models\User');
    }

}
