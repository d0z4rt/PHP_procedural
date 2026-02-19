<?php

namespace Tests;

use App\Classes\Bank;
use PHPUnit\Framework\TestCase;

final class BankTest extends TestCase
{


    // Cas normal
    // Verifier si la fonctionnalité de dépot --> le montant sur le compte augmente
    public function testDepositeValidAmount()
    {
        $amount = 10.0;
        $initialAmount = 10.0;

        $bank = new Bank($initialAmount);
        $bank->deposit($amount);

        $this->assertEquals($initialAmount + $amount, $bank->getBalance());
    }


    // cas d'erreur
    // Verifier si les fond sont suffisant pour un retrait --> if not : Exeption
    public function testWithdrawTooMuchThrowsException(): void
    {
        $this->expectException(\RuntimeException::class);


        $bank = new Bank(50);
        $bank->withdraw(250);
    }


    // cas d'erreur
    // Verifier l'initialisation du compte avec une valeur negative --> Exeption

    public function testCannotCreateWithInvalidAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Bank(-10);
    }



    // cas limite
    // Déposer 0€ sur le compte --> exeption

    public function testDepotZero(): void
    {
        $bank = new Bank(100);
        $this->expectException(\InvalidArgumentException::class);
        $bank->deposit(0);
    }


    // cas limite 
    // Retirer exactement le solde disponible sur le compte --> solde === 0
    public function testEgalite(): void
    {
        $amount = 100;
        
        $bank = new Bank($amount);
        $bank->withdraw($amount);
        
        $this->assertEquals(0.0, $bank->getBalance());

    }
}
