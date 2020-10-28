<?php

namespace App\Http\Controllers;

use App\Mail\EnvioDeEmail;
use App\Models\Funcionario;
use App\Models\Pedido;
use App\Models\Servidor;
use App\Models\User;
use App\Validator\FuncionarioValidator;
use App\Validator\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FuncionarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('FuncionarioMiddleware');
    }

    public function prepararEditar(){
        $user = User::find(Auth::user()->id);
        $funcionario = Funcionario::where('user_id', $user->id)->first();
        return view('funcionario.formEditarFuncionario',['user' => $user, 'funcionario' => $funcionario]);
    }
    public function editar(Request $request){
        $user = Auth::user();
        $funcionario = Funcionario::where('user_id', $user->id)->first();
        try {
            //caso o funcionario tenha mudado o email
            if($user->email != $request->email){
               $request->validate(['email' => ['required', 'string', 'email', 'max:255', 'unique:users']],['email.unique' => "Email já registrado.",
        'email.*' => "Email inválido."]);
            }

            FuncionarioValidator::validate($request->all());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telefone = $request->telefone;
            $user->save();

            $funcionario->cpf = $request->cpf;
            $funcionario->save();

            return redirect(route('home'))
                ->with('message', 'works');
        }catch (ValidationException $exception){
           // dd($exception);
            return redirect(route('funcionario.editar') )
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }

    public function listarServidores(){
        $aux = Servidor::All();

        $servidores = array();
        foreach ($aux as $user){
            //$ajuda = User::where('id', $user->user_id)->get();
            $ajuda = User::find($user->user_id);
            array_push($servidores,$ajuda);
        }
        return view('listarServidores',['servidores'=>$servidores]);
    }
    public function listarFuncionarios(){
        $aux = Funcionario::All();

        $servidores = array();
        foreach ($aux as $user){
            //$ajuda = User::where('id', $user->user_id)->get();
            $ajuda = User::find($user->user_id);
            array_push($servidores,$ajuda);
        }
        return view('listarFuncionarios',['servidores'=>$servidores]);
    }
    public function enviarEmail(Request $request){
        $user = User::find($request->id);
        //return new EnvioDeEmail($user);
        Mail::send(new EnvioDeEmail($user));
        return redirect('/listar/servidores');
    }
}
