<?php declare(strict_types=1);

Namespace App\Class;

class UserAccount
{
    private string $email;

    private string $password;

    

    public function register(string $email, string $password): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email invalide.");
        }

        if (strlen($password) < 24) {
            throw new \InvalidArgumentException("Mot de passe trop court.");
        }

        $this->email = $email;
        $this->password = $password;
    }

    public function login(string $email, string $password): bool
    {
        if ($email !== $this->email || $password !== $this->password) {
            throw new \InvalidArgumentException("Identifiants incorrects.");
        }

        return true;
    }

    public function changePassword(string $old, string $new): void
    {
        if ($old !== $this->password) {
            throw new \InvalidArgumentException("Ancien mot de passe incorrect.");
        }

        if (strlen($new) < 24) {
            throw new \InvalidArgumentException("Nouveau mot de passe trop court.");
        }

        $this->password = $new;
    }
}