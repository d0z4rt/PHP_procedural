<?php
Namespace App\Class;

class Calculatrice
{
    public function add(float $a, float $b): float
    {
        return $a + $b;
    }

    public function divide(float $a, float $b): float
    {
        if ($b == 0) {
            throw new \InvalidArgumentException("Division par zéro interdite.");
        }

        return $a / $b;
    }

    public function sqrt(float $a): float
    {
        if ($a < 0) {
            throw new \InvalidArgumentException("Racine carrée d'un nombre négatif interdite.");
        }

        return sqrt($a);
    }
}