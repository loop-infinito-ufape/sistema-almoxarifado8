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
}
