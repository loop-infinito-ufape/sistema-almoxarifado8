<?php

namespace Tests\Browser;

use App\Models\Funcionario;
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
                    ->assertSee('Laravel');
        });
    }
    public function testCadastrarFunionario(){
        $funcionario = Funcionario::factory()->make();
        $this->browse(
            function (Browser $browser) use ($funcionario) {
                $browser->visit('/funcionario/cadastrar')
                    ->pause(2000)
                    ->type('nome',$funcionario->nome)
                    ->type('cpf',$funcionario->cpf)
                    ->type('telefone',$funcionario->telefone)
                    ->type('email',$funcionario->email)
                    ->type('senha',$funcionario->senha)
                    ->press('Cadastrar')
                    ->assertSee('Funcionario criado');
            });
    }

    public function testFunionarioCPFInvalido(){
        $funcionario = Funcionario::factory()->make();
        $this->browse(
            function (Browser $browser) use ($funcionario) {
                $browser->visit(route('funcionario.criar'))
                    ->pause(2000)
                    ->type('nome',$funcionario->nome)
                    ->type('cpf', '123')
                    ->type('telefone',$funcionario->telefone)
                    ->type('email',$funcionario->email)
                    ->type('senha',$funcionario->senha)
                    ->press('Cadastrar')
                    ->assertSee('CPF inválido.');
            });
    }
}
