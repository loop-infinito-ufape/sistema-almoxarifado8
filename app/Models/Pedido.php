<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pedido extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['descricao',
                            'quantidade_pedida',
                            'quantidade_despachadada',
                            'data_inicial',
                            'data_final',
                            'status',
                            'observacao',
                            'funcionario_id',
                            'servidor_id',
                            'tipo_equipamento_id',
                            'pedido_anterior_id'
    ];

    public static $rules = ['quantidade_pedida' => 'required|integer'];

    public static $messages = ['quantidade_pedida.*' => "Quantidade é campo obrigatório e deve ser um valor inteiro."];

    public function funcionario(){
    	return $this->belongsTo('app\Models\Funcionario');
    }

    public function servidor(){
    	return $this->belongsTo('app\Models\Servidor');
    }

    public function tipoEquipamento(){
    	return $this->belongsTo('app\Models\TipoEquipamento');
    }

    public function patrimonio(){
        return $this->hasMany('app\Models\Patrimonio');
    }

     public function pedidoAnterior(){
        return $this->belongsTo('app\Models\Pedido');
    }
}
