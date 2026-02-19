<?php

// todo 1. Definir au moins : 1  cas normal, un cas d'erreur et un cas limite
// todo 2. Ecrire les tests correspondants
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Classes\Stock;

final class StockTest extends TestCase
{
    public function testAddValidquantity()
    {
        $stock = new Stock();
        $stock->add(10);
        $this->assertEquals(10, $stock->getQuantity());
    }


    public function testAddZero()
    {

        $stock = new Stock();
        $stock->add(0);
        $this->assertEquals(0, $stock->getQuantity());

    }


    public function testAddNegativQuantity()
    {
        $quantity = 100;
        $stock = new Stock($quantity);

        $this->expectException(\InvalidArgumentException::class);
        $stock->add(-1);
    }
}
