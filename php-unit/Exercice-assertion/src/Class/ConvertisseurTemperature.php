<?php

Namespace App\Class;

final class ConvertisseurTemperature {


    private const ABSOLUTE_ZERO = -273.15;

    public function celsiusToFahrenheit(float $c): float
    {
        if ($c < self::ABSOLUTE_ZERO) {
            throw new \InvalidArgumentException("Température sous le zéro absolu.");
        }

        return ($c * 9/5) + 32;
    }

    public function fahrenheitToCelsius(float $f): float
    {
        $c = ($f - 32) * 5/9;

        if ($c < self::ABSOLUTE_ZERO) {
            throw new \InvalidArgumentException("Température sous le zéro absolu.");
        }

        return $c;
    }
}

    

