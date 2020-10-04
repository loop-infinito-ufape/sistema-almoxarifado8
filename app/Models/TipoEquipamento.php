<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TipoEquipamento extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['nome', 'descricao', 'quantidade'];

    public static $rules = ['nome' => 'required',
                            'descricao' => 'required',
                            'quantidade' => 'required|integer'
    ];

    public static $messages = ['nome.*' => ":attribute é obrigatório.",
                            'descricao.*' => ":attribute é obrigatório.",
                            'quantidade.*' => ":attribute é um campo obrigatório e deve ser um valor numérico."

    ];

    public function pedido(){
    	return $this->hasMany('app\Models\Pedido');
    }

    public function patrimonio(){
    	return $this->hasMany('app\Models\Patrimonio');
    }
}
