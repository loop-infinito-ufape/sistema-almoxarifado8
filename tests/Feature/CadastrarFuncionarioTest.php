<?php

namespace Tests\Feature;

use App\Models\Funcionario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CadastrarFuncionarioTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCadastrarFuncionario(){
        $funcionario = Funcionario::factory()->make();
        $dados = $funcionario->toArray();
        $response = $this
            ->post('funcionario/cadastrar',$dados)
            ->assertStatus(200);
    }

    public function testFuncionarioNomeInvalido(){
        $funcionario = Funcionario::factory()->make();
        $funcionario->nome = '';
        $dados = $funcionario->toArray();
        $response = $this
            ->post(route('funcionario.criar'),$dados)
            ->assertStatus(302)
            ->assertRedirect(route('funcionario.criar'))
            ->assertSessionHas('errors');
    }

    public function testFuncionarioCpfInvalido(){
        $funcionario = Funcionario::factory()->make();
        $funcionario->cpf = '123';
        $dados = $funcionario->toArray();
        $response = $this
            ->post(route('funcionario.criar'),$dados)
            ->assertStatus(302)
            ->assertRedirect(route('funcionario.criar'))
            ->assertSessionHas('errors');
    }
}
