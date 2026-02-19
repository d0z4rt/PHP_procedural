<?php

Namespace Tests;


use App\Class\GestionStock;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use RuntimeException;

class GestionStockTest extends TestCase
{
    public function testAddEtRemove()
    {
        $stock = new GestionStock();
        $stock->add(10);
        $stock->remove(3);

        $this->assertEquals(7, $stock->getQuantity());
    }

    public function testRemoveTrop()
    {
        $this->expectException(RuntimeException::class);

        $stock = new GestionStock();
        $stock->add(5);
        $stock->remove(10);
    }

    public function testAddNegatif()
    {
        $this->expectException(InvalidArgumentException::class);

        $stock = new GestionStock();
        $stock->add(-5);
    }

    public function testRemoveExactStock()
    {
        $stock = new GestionStock();
        $stock->add(5);
        $stock->remove(5);

        $this->assertEquals(0, $stock->getQuantity());
    }
}
