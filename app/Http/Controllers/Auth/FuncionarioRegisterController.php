<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Sala;
use App\Models\Servidor;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Utils\CpfValidation;
use App\Validator\UserValidator;
use App\Validator\ValidationException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Sodium\add;

class FuncionarioRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $salas = Sala::all();
        return view('auth.funcionarioRegister')
            ->with('salas', $salas);
    }


    public $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'telefone' => ['required', 'size:11'],
        'cpf' => ['required', 'cpf'],
    ];

    public $messages = [
        'name.*' => "Nome é obrigatório e deve ter até 255 caracteres.",
        'email.unique:users' => "Email já registro.",
        'email.*' => "Email inválido.",
        'password.confirmed' => "A confirmação de senha não corresponde.",
        'password.*' => "Senha deve ter no mínimo tamanho 8.",
        'telefone.*' => "Telefone inválido",
        'cpf' => "CPF inválido",
    ];
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, $this->rules, $this->messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'telefone' => $data['telefone'],
        ]);

        Funcionario::create([
            'cpf' => $data['cpf'],
            'user_id' => $user->id,
        ]);

        return $user;
    }
}
