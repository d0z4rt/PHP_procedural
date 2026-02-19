<?php
Namespace App\Classes;

class VerificateurAge
{
    public function estMajeur(int $age): bool
    {
        if ($age < 0) {
            throw new \InvalidArgumentException("Age invalide.");
        }

        return $age >= 18;
    }
}