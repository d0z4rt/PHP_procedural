<?php
use PHPUnit\Framework\TestCase;
use App\Classes\PdfDownloader;
use App\Classes\Logger;

class PdfDownloaderTest extends TestCase
{
    private $loggerMock;
    private $pdfDownloader;
    private $testFilePath;

    protected function setUp(): void
    {
        // Créer un mock du Logger
        $this->loggerMock = $this->createMock(Logger::class);
        
        // Créer l'instance de PdfDownloader avec le mock
        $this->pdfDownloader = new PdfDownloader($this->loggerMock);
        
        // Créer un fichier temporaire pour les tests
        $this->testFilePath = sys_get_temp_dir() . '/test_' . uniqid() . '.pdf';
    }

    protected function tearDown(): void
    {
        // Nettoyer le fichier temporaire après les tests
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    /**
     * Test cas normal - Téléchargement réussi d'un fichier PDF existant
     */
    public function testSuccessfulDownloadLogsSuccessMessage()
    {
        // Créer un fichier PDF factice
        file_put_contents($this->testFilePath, 'Fake PDF content');

        // Attendre que le logger soit appelé avec le message de succès
        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($this->stringContains('Téléchargement réussi : ' . $this->testFilePath));
        
        $this->pdfDownloader->download($this->testFilePath);
    }

    /**
     * Test cas d'erreur - Téléchargement avec fichier inexistant
     */
    public function testDownloadWithNonExistentFileLogsErrorMessage()
    {
        $nonExistentPath = '/chemin/inexistant/fichier.pdf';
        
        // Attendre que le logger soit appelé avec le message d'erreur
        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($this->stringContains('Erreur : Fichier PDF introuvable'));
        
        $this->pdfDownloader->download($nonExistentPath);
    }

    /**
     * Test cas limite - Fichier PDF vide
     */
    public function testDownloadWithEmptyFileLogsSuccessMessage()
    {
        // Créer un fichier PDF vide
        file_put_contents($this->testFilePath, '');
        
        // Même un fichier vide devrait être considéré comme existant
        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($this->stringContains('Téléchargement réussi'));
        
        $this->pdfDownloader->download($this->testFilePath);
    }

    /**
     * Test cas limite - Chemin avec des caractères spéciaux
     */
    public function testDownloadWithSpecialCharactersInPath()
    {
        $specialPath = sys_get_temp_dir() . '/test_éàù@#$%.pdf';
        
        try {
            // Créer un fichier avec des caractères spéciaux
            file_put_contents($specialPath, 'Fake PDF content');
            
            $this->loggerMock->expects($this->once())
                ->method('log')
                ->with($this->stringContains('Téléchargement réussi'));
            
            $this->pdfDownloader->download($specialPath);
            
            // Nettoyer
            unlink($specialPath);
        } catch (\Exception $e) {
            // Si le système de fichiers ne supporte pas ces caractères
            $this->markTestSkipped('Le système de fichiers ne supporte pas les caractères spéciaux');
        }
    }

    /**
     * Test avec plusieurs appels successifs
     */
    public function testMultipleDownloads()
    {
        // Créer un fichier de test
        file_put_contents($this->testFilePath, 'Fake PDF content');
        
        $this->loggerMock->expects($this->exactly(2))
            ->method('log')
            ->withConsecutive(
                [$this->stringContains('Téléchargement réussi')],
                [$this->stringContains('Erreur : Fichier PDF introuvable')]
            );
        
        // Premier téléchargement - réussi
        $this->pdfDownloader->download($this->testFilePath);
        
        // Deuxième téléchargement - échoué (fichier inexistant)
        $this->pdfDownloader->download('/fichier/inexistant.pdf');
    }

    /**
     * Test avec un chemin null (devrait générer une erreur)
     */
    public function testDownloadWithNullPath()
    {
        $this->expectException(\TypeError::class);
        
        // En PHP 7+, passer null à une fonction qui attend string génère une TypeError
        $this->pdfDownloader->download(null);
    }

    /**
     * Test avec un chemin vide
     */
    public function testDownloadWithEmptyPath()
    {
        // Un chemin vide n'existe pas
        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($this->stringContains('Erreur : Fichier PDF introuvable'));
        
        $this->pdfDownloader->download('');
    }

    /**
     * Test avec un chemin de dossier au lieu d'un fichier
     */
    public function testDownloadWithDirectoryPath()
    {
        $dirPath = sys_get_temp_dir() . '/test_dir_' . uniqid();
        mkdir($dirPath);
        
        // Un dossier n'est pas un fichier PDF
        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($this->stringContains('Erreur : Fichier PDF introuvable'));
        
        $this->pdfDownloader->download($dirPath);
        
        // Nettoyer
        rmdir($dirPath);
    }

    /**
     * Test avec un fichier qui a une extension différente
     */
    public function testDownloadWithNonPdfExtension()
    {
        $txtPath = sys_get_temp_dir() . '/test_' . uniqid() . '.txt';
        file_put_contents($txtPath, 'Text content');
        
        // La classe ne vérifie pas l'extension, donc devrait fonctionner
        $this->loggerMock->expects($this->once())
            ->method('log')
            ->with($this->stringContains('Téléchargement réussi'));
        
        $this->pdfDownloader->download($txtPath);
        
        // Nettoyer
        unlink($txtPath);
    }
}
