<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Models\Servidor;
use App\Models\User;
use App\Validator\ServidorValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ServidorController extends Controller
{
    public function prepararEditar(){
        $user = User::find(Auth::user()->id);
        $servidor = Servidor::where('user_id', $user->id)->first();
        $salas = Sala::all();
        return view('servidor.formEditarServidor',['user' => $user, 'servidor' => $servidor])->with('salas', $salas);
    }
    public function editar(Request $request){
        $user = Auth::user();
        $servidor = Servidor::where('user_id', $user->id)->first();
        try {
            //caso o servidor tenha mudado o email
            if($user->email != $request->email){
                $request->validate(['email' => ['required', 'string', 'email', 'max:255', 'unique:users']],['email.unique' => "Email já registrado.",
                    'email.*' => "Email inválido."]);
            }

            ServidorValidator::validate($request->all());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telefone = $request->telefone;
            $user->save();

            $servidor->if = $request->if;
            $servidor->sala_id = $request->sala_id;
            $servidor->save();

            return redirect(route('home'))
                ->with('message', 'Dados atualizados');
        }catch (ValidationException $exception){
            return redirect(route('servidor.editar') )
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
}
