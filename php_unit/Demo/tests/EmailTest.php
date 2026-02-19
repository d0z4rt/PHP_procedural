<?php

namespace Test;

use App\Classes\Email;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    //! 1. Arrange
    //phase de préparation (recolte de data)

    //! l'act
    // la phase d'initialisation du code a tester

    // !Assert
    //phase de vérification

    public function testCanBeCreateByValidString():void
    {
        $string = "user@exemple.fr";
        $email = Email::fromString($string);
        $this->assertSame($string, $email->asString());
    }

    public function testCantBeCreateByInvalidString():void
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $string = "invalide";
        $email = Email::fromString($string);


    }

}
