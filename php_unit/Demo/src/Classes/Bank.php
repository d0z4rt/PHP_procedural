<?php
Namespace App\Classes;

class Bank
{
    private float $balance;

    public function __construct(float $initialBalance)
    {
        if ($initialBalance < 0) {
            throw new \InvalidArgumentException("Le solde initial ne peut pas être négatif");
        }

        $this->balance = $initialBalance;
    }

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Le dépôt doit être positif");
        }

        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Le retrait doit être positif");
        }

        if ($amount > $this->balance) {
            throw new \RuntimeException("Fonds insuffisants");
        }

        $this->balance -= $amount;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}