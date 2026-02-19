<?php

namespace Tests;

use App\Classes\VerificateurAge;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VerificateurAgeTest extends TestCase
{

    #[DataProvider("ageValidDataProvider")]
    public function testIsMajeur(int $age, bool $expect)
    {
        $verif = new VerificateurAge();
        $isMajeur = $verif->estMajeur($age);

        $this->assertSame($expect, $isMajeur);
    }

    public static function ageValidDataProvider()
    {
        return [
            [17, false],
            [19, true],
            [20, true],
            [1, false],
            [18, true],
            [35, true],
            [0, false],
        ];
    }

    //todo Creer un data provider de cas d'erreur avec plusieur cas qui devrai retourner une erreur

    #[DataProvider("ageInvalidDataProvider")]
    public function testCasErreur(int $age)
    {
        $this->expectException(\InvalidArgumentException::class);
        $verif = new VerificateurAge();
        $verif->estMajeur($age);

    }

    public static function ageInvalidDataProvider()
    {
        return [
            [-1],
            [-5],
            [-10]
        ];
    }
}


