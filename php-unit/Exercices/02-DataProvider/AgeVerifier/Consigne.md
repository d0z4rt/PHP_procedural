# Consigne – Tests unitaires à réaliser pour la classe `UserAccount`

Avant d’implémenter la classe `UserAccount`, vous devez écrire les tests unitaires décrivant précisément le comportement attendu (approche TDD – Test Driven Development).

La classe devra gérer l’inscription, la connexion et la modification du mot de passe d’un utilisateur.

---

## 1. Inscription (`register`)

### Cas normal

- Lorsque la méthode `register(string $email, string $password)` est appelée avec :
  - un email valide  
  - un mot de passe valide  
- Alors l’utilisateur est enregistré sans exception.

### Cas d’erreur

1. **Email invalide**
   - Si l’email ne respecte pas un format valide, la méthode doit lever une `InvalidArgumentException`.

2. **Mot de passe trop court**
   - Si le mot de passe ne respecte pas une longueur minimale (par exemple inférieure à 8 caractères), la méthode doit lever une `InvalidArgumentException`.

3. **Email déjà enregistré (option recommandé)**
   - Si un utilisateur tente de s’inscrire avec un email déjà utilisé, une `InvalidArgumentException` doit être levée.

---

## 2. Connexion (`login`)

### Cas normal

- Après une inscription valide,
- Si la méthode `login(string $email, string $password)` est appelée avec les identifiants corrects,
- Elle doit retourner `true`.

### Cas d’erreur

1. **Mot de passe incorrect**
   - Si le mot de passe ne correspond pas à celui enregistré, la méthode doit lever une `InvalidArgumentException`.

2. **Email non enregistré**
   - Si l’email n’existe pas, la méthode doit lever une `InvalidArgumentException`.

---

## 3. Changement de mot de passe (`changePassword`)

### Cas normal

- Si l’ancien mot de passe est correct,
- Et que le nouveau mot de passe est valide,
- Alors le mot de passe est modifié.
- Une tentative de connexion avec le nouveau mot de passe doit retourner `true`.

### Cas d’erreur

1. **Ancien mot de passe incorrect**
   - La méthode doit lever une `InvalidArgumentException`.

2. **Nouveau mot de passe invalide**
   - Si le nouveau mot de passe ne respecte pas les règles de validation (longueur minimale, etc.), une `InvalidArgumentException` doit être levée.

---

## Contraintes générales

- L’email doit respecter un format valide.
- Le mot de passe doit respecter les règles définies (ex. minimum 8 caractères).
- Toutes les erreurs métier doivent lever une `InvalidArgumentException`.
- La méthode `login()` ne retourne `true` que si les identifiants sont corrects.

---

## Démarche attendue (TDD)

1. Écrire l’ensemble des tests unitaires.
2. Vérifier qu’ils échouent.
3. Implémenter progressivement la classe `UserAccount`.
4. Faire passer les tests un par un.
5. Refactoriser si nécessaire tout en conservant les tests au vert.
