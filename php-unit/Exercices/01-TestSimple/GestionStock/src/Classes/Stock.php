<?php

Namespace App\Classes;

class Stock
{
    private int $quantity = 0;

    public function add(int $quantity): void
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException("Quantité invalide.");
        }

        $this->quantity += $quantity;
    }

    public function remove(int $quantity): void
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException("Quantité invalide.");
        }

        if ($quantity > $this->quantity) {
            throw new \RuntimeException("Stock insuffisant.");
        }

        $this->quantity -= $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}