<?php

namespace Tests\Browser;

use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CadastrarFuncionarioTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('vantagens de realizar suas requisições inteiramente online');
        });
    }
    public function testCadastrarFunionario(){
        $user = User::factory()->make();
        $funcionario = Funcionario::factory()->make(['user_id' =>$user->id]);
        $this->browse(
            function (Browser $browser) use ($user, $funcionario) {
                $browser->visit(route('funcionario.register'))
                    ->pause(2000)
                    ->type('name',$user->name)
                    ->type('telefone',$user->telefone)
                    ->type('cpf',$funcionario->cpf)
                    ->type('email',$user->email)
                    ->type('password','password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Pedidos Pendentes');
            });
    }

}
