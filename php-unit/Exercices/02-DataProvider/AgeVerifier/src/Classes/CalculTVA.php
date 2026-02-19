<?php
Namespace App\Classes;


class CalculTVA
{
    public function ajouterTVA(float $montant, float $taux): float
    {
        if ($montant < 0) {
            throw new \InvalidArgumentException("Montant invalide.");
        }

        if ($taux < 0) {
            throw new \InvalidArgumentException("Taux invalide.");
        }

        return $montant + ($montant * $taux / 100);
    }
}
