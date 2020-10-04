<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sala extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = ['nome', 'ramal', 'predio'];

    public static $rules = ['nome' => 'required|',
                            'ramal' => 'nullable|size:3',
                            'predio' => 'required'
    ];

    public static $messages = ['nome.*' => ":attribute é obrigatório.",
                                'ramal.*' => ":attribute deve ter tamanho 3.",
                                'predio.*' => ":attribute é         obrigatório"

    ];

    public function servidor(){
    	return $this->hasMany('app\Models\Servidor');
    }
}
