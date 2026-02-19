<?php


namespace App\Security\Csrf;

trait CsrfTokenTrait
{
    /**
     * Génère un token CSRF et le stocke en session
     */
    public function generateCsrfToken(string $formName): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = bin2hex(random_bytes(32)); // token sécurisé
        $_SESSION['_csrf_tokens'][$formName] = $token;

        return $token;
    }

    /**
     * Vérifie le token CSRF envoyé dans le formulaire
     */
    public function verifyCsrfToken(string $formName, ?string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $validToken = $_SESSION['_csrf_tokens'][$formName] ?? null;

        // Supprime le token après vérification pour qu'il ne soit utilisé qu'une fois
        unset($_SESSION['_csrf_tokens'][$formName]);

        return $validToken !== null && hash_equals($validToken, $token);
    }

    /**
     * Génère un champ hidden HTML avec le token
     */
    public function csrfField(string $formName): string
    {
        $token = $this->generateCsrfToken($formName);
        return sprintf('<input type="hidden" name="_csrf_token" value="%s">', htmlspecialchars($token));
    }
}
