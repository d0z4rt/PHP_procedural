<?php

Namespace App\Classes;

use App\Classes\Logger;



class PdfDownloader {
    private $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    /**
     * Télécharge un PDF si le fichier existe
     * @param string $path Chemin du fichier PDF
     */
    public function download(string $path): void {
        try {
            if (!file_exists($path)) {
                throw new \Exception("Fichier PDF introuvable : $path");
            }

            // Ici on simule le téléchargement
            // file_get_contents, copy, etc.
            $this->logger->log("Téléchargement réussi : $path");

        } catch (\Exception $e) {
            $this->logger->log("Erreur : " . $e->getMessage());
        }
    }
}