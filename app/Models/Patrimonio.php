<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Patrimonio extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['numero', 'status', 'pedido_id', 'tipo_equipamento_id'];

    public static $rules = ['numero' => 'required',
                            'tipo_equipamento_id' => 'required|integer'
    ];

    public static $messages = ['numero.*' => ":attribute é obrigatório.",
                                'tipo_equipamento_id.*' => "Categoria é obrigatória e deve ser um valor numérico"
    ];

    public function pedido(){
    	return $this->belongsTo('app\Models\Pedido');
    }

    public function tipoEquipamento(){
    	return $this->belongsTo('app\Models\TipoEquipamento');
    }

}
