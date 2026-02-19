<?php

Namespace Tests;


use App\Class\Calculatrice;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CalculatriceTest extends TestCase
{
    public function testAddition()
    {
        $calc = new Calculatrice();
        $this->assertEquals(5, $calc->add(2, 3));
    }

    public function testAdditionZero()
    {
        $calc = new Calculatrice();
        $this->assertEquals(0, $calc->add(0, 0));
    }

    public function testDivision()
    {
        $calc = new Calculatrice();
        $this->assertEquals(5, $calc->divide(10, 2));
    }

    public function testDivisionParZero()
    {
        $this->expectException(InvalidArgumentException::class);

        $calc = new Calculatrice();
        $calc->divide(10, 0);
    }

    public function testSqrt()
    {
        $calc = new Calculatrice();
        $this->assertEquals(3, $calc->sqrt(9));
    }

    public function testSqrtNegatif()
    {
        $this->expectException(InvalidArgumentException::class);

        $calc = new Calculatrice();
        $calc->sqrt(-4);
    }
}
