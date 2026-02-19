<?php
Namespace App\Classes;
class CalculRemise
{
    public function appliquer(float $prix, float $pourcentage): float
    {
        if ($prix < 0) {
            throw new \InvalidArgumentException("Prix invalide.");
        }

        if ($pourcentage < 0 || $pourcentage > 100) {
            throw new \InvalidArgumentException("Pourcentage invalide.");
        }

        return $prix - ($prix * $pourcentage / 100);
    }
}