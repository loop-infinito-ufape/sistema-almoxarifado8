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
    public function testFuncionarioSemCPF(){
        $this->expectException(ValidationException::class);
        $funcionario = Funcionario::factory()->make();
        $funcionario->cpf = '';
        FuncionarioValidator::validate($funcionario->toArray());
    }

    public function testFuncionarioCPFInvalido(){
        $this->expectException(ValidationException::class);
        $funcionario = Funcionario::factory()->make();
        $funcionario->cpf = '123';
        FuncionarioValidator::validate($funcionario->toArray());
    }

    public function testFuncionarioUSerIdInvalido(){
        $this->expectException(ValidationException::class);
        $funcionario = Funcionario::factory()->make();
        $funcionario->user_id = '';
        FuncionarioValidator::validate($funcionario->toArray());
    }
}
