<?php
use PHPUnit\Framework\TestCase;
use App\Classes\Notifier;
use App\Classes\Mailer;

class NotifierTest extends TestCase
{
    private $mailerMock;
    private $notifier;
    
    protected function setUp(): void
    {
        // Créer un mock du Mailer pour chaque test
        $this->mailerMock = $this->createMock(Mailer::class);
        $this->notifier = new Notifier($this->mailerMock);
    }
    
    protected function tearDown(): void
    {
        // Nettoyage après chaque test si nécessaire
        parent::tearDown();
    }

    /**
     * Test cas normal - Notifier une seule personne
     */
    public function testNotifyAllWithSingleEmail()
    {
        $emails = ['user1@example.com'];
        
        // Vérifier que send() est appelé UNE fois avec les bons paramètres
        $this->mailerMock->expects($this->once())
            ->method('send')
            ->with(
                $this->equalTo('user1@example.com'),
                $this->equalTo('Notification importante')
            );
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test cas normal - Notifier plusieurs personnes
     */
    public function testNotifyAllWithMultipleEmails()
    {
        $emails = [
            'user1@example.com',
            'user2@example.com',
            'user3@example.com'
        ];

        // Vérifier que send() est appelé EXACTEMENT 3 fois
        $this->mailerMock->expects($this->exactly(3))
            ->method('send')
            ->withConsecutive(
                ['user1@example.com', 'Notification importante'],
                ['user2@example.com', 'Notification importante'],
                ['user3@example.com', 'Notification importante']
            );

        $this->notifier->notifyAll($emails);
    }

    /**
     * Test cas limite - Tableau vide
     */
    public function testNotifyAllWithEmptyArray()
    {
        $emails = [];
        
        // Vérifier que send() n'est JAMAIS appelé
        $this->mailerMock->expects($this->never())
            ->method('send');
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test cas limite - Un seul email dans le tableau
     */
    public function testNotifyAllWithSingleEmailInArray()
    {
        $emails = ['single@example.com'];
        
        $this->mailerMock->expects($this->once())
            ->method('send')
            ->with('single@example.com', 'Notification importante');
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test avec des emails en désordre (vérifie que l'ordre est préservé)
     */
    public function testNotifyAllPreservesEmailOrder()
    {
        $emails = [
            'first@example.com',
            'second@example.com',
            'third@example.com'
        ];
        
        // Vérifier que l'ordre d'appel correspond à l'ordre du tableau
        $this->mailerMock->expects($this->exactly(3))
            ->method('send')
            ->withConsecutive(
                ['first@example.com', 'Notification importante'],
                ['second@example.com', 'Notification importante'],
                ['third@example.com', 'Notification importante']
            );
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test avec des emails en double
     */
    public function testNotifyAllWithDuplicateEmails()
    {
        $emails = [
            'duplicate@example.com',
            'duplicate@example.com',
            'unique@example.com'
        ];
        
        // La classe envoie à chaque entrée du tableau, même les doublons
        $this->mailerMock->expects($this->exactly(3))
            ->method('send');
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * @dataProvider emailProvider
     */
    public function testNotifyAllWithVariousEmailLists(array $emails, int $expectedCalls)
    {
        $this->mailerMock->expects($this->exactly($expectedCalls))
            ->method('send');
        
        $this->notifier->notifyAll($emails);
    }
    
    public function emailProvider()
    {
        return [
            'Aucun email' => [[], 0],
            'Un email' => [['test@example.com'], 1],
            'Deux emails' => [['a@test.com', 'b@test.com'], 2],
            'Cinq emails' => [
                [
                    '1@test.com', '2@test.com', '3@test.com', 
                    '4@test.com', '5@test.com'
                ], 
                5
            ],
        ];
    }

    /**
     * Test avec des emails invalides (la classe Notifier ne valide pas)
     */
    public function testNotifyAllWithInvalidEmails()
    {
        $emails = [
            'pas-un-email',
            '@sans-nom.com',
            'espaces@ test.com',
            ''
        ];
        
        // Le Notifier ne valide pas les emails, donc il envoie quand même
        $this->mailerMock->expects($this->exactly(4))
            ->method('send');
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test avec un tableau associatif (clés nommées)
     */
    public function testNotifyAllWithAssociativeArray()
    {
        $emails = [
            'user1' => 'user1@example.com',
            'user2' => 'user2@example.com'
        ];
        
        // Les clés n'affectent pas les valeurs envoyées
        $this->mailerMock->expects($this->exactly(2))
            ->method('send')
            ->withConsecutive(
                ['user1@example.com', 'Notification importante'],
                ['user2@example.com', 'Notification importante']
            );
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test cas d'erreur - Mailer lance une exception
     */
    public function testNotifyAllWhenMailerThrowsException()
    {
        $emails = ['test@example.com'];
        
        // Simuler que le mailer lance une exception
        $this->mailerMock->method('send')
            ->will($this->throwException(new \Exception("Échec d'envoi")));
        
        // Le Notifier ne gère pas l'exception, donc elle remonte
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Échec d'envoi");
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test vérifiant que le message est toujours "Notification importante"
     */
    public function testNotifyAllAlwaysUsesCorrectMessage()
    {
        $emails = ['a@test.com', 'b@test.com'];
        
        // Vérifier que le second paramètre est toujours le bon message
        $this->mailerMock->expects($this->exactly(2))
            ->method('send')
            ->with(
                $this->anything(),
                $this->equalTo('Notification importante')
            );
        
        $this->notifier->notifyAll($emails);
    }

    /**
     * Test avec un très grand nombre d'emails (performance)
     */
    public function testNotifyAllWithManyEmails()
    {
        // Créer un tableau avec 1000 emails
        $emails = [];
        for ($i = 0; $i < 1000; $i++) {
            $emails[] = "user$i@example.com";
        }
        
        $this->mailerMock->expects($this->exactly(1000))
            ->method('send');
        
        $this->notifier->notifyAll($emails);
    }
}
