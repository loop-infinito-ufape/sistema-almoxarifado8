<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->funcionario != null){
            #return view('funcionario.homeFuncionario');
            return redirect(route('pedido.listapendetes'));
        }
        #return view('servidor.homeServidor');
        return redirect(route('pedido.listar'));

    }
}
