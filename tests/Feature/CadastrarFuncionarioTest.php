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

    //302 Found
    //This response code means that the URI of requested resource has been changed temporarily.
    //Further changes in the URI might be made in the future. Therefore, this same URI should be used
    /// by the client in future requests.
    public function testCadastrarFuncionario(){
        $funcionario = Funcionario::factory()->make();
        $dados = $funcionario->toArray();
        $response = $this
            ->post(route('funcionario.register'),$dados)
            ->assertStatus(302);
    }

    public function testFuncionarioUserIdInvalido(){
        $funcionario = Funcionario::factory()->make(['user_id' => '']);
        $dados = $funcionario->toArray();
        $response = $this
            ->post(route('funcionario.register'),$dados)
            ->assertStatus(302)
            ->assertSessionHas('errors');
    }

    public function testFuncionarioCpfInvalido(){
        $funcionario = Funcionario::factory()->make();
        $funcionario->cpf = '123';
        print_r($funcionario->cpf);
        $dados = $funcionario->toArray();
        $response = $this
            ->post(route('funcionario.register'),$dados)
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }
}
