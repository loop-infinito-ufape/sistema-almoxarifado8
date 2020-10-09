<?php

namespace Tests\Unit;

use App\Models\Funcionario;
use App\Validator\FuncionarioValidator;
use App\Validator\ValidationException;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;

class FuncionarioValidatorTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    public function testFuncionarioSemNome(){
        $this->expectException(ValidationException::class);
        $funcionario = Funcionario::factory()->make();
        $funcionario->nome = '';
        FuncionarioValidator::validate($funcionario->toArray());
    }

    public function testFuncionarioCPFInvalido(){
        $this->expectException(ValidationException::class);
        $funcionario = Funcionario::factory()->make();
        $funcionario->cpf = '123';
        FuncionarioValidator::validate($funcionario->toArray());
    }

    public function testFuncionarioNomeInvalido(){
        $this->expectException(ValidationException::class);
        $funcionario = Funcionario::factory()->make();
        $funcionario->nome = 'felipe';
        FuncionarioValidator::validate($funcionario->toArray());
    }
}
