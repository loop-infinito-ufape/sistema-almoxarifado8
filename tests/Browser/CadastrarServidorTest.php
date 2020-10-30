<?php

namespace Tests\Browser;

use App\Models\Servidor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CadastrarServidorTest extends DuskTestCase
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
                    ->assertSee('Laravel');
        });
    }

    public function testCadastrarFunionario(){
        $user = User::factory()->make();
        $servidor = Servidor::factory()->make(['user_id' =>$user->id]);
        $this->browse(
            function (Browser $browser) use ($user, $servidor) {
                $browser->visit(route('register'))
                    ->pause(2000)
                    ->type('name',$user->name)
                    ->type('telefone',$user->telefone)
                    ->type('if', '40028299')
                    ->type('email',$user->email)
                    ->type('password','password')
                    ->type('password_confirmation', 'password')
                    ->press('Register')
                    ->assertSee('Listar Pedidos');
            });
    }
}
