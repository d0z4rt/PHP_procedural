<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Procédural</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <header class="p-5 bg-primary text-white text-center">
        <h1 class="p-3">PHP Procédural</h1>
    </header>

    <div class="container border p-3 mt-5">
        <div class="row">
            <div class="col-12">

            <!-- commentaire html -->

            <?php
                // Commentaire sur une seule ligne
                #  Commentaire sur une seule ligne

                /*
                    Commentaire sur
                    plusieurs
                    lignes
                */

                // Il est possible d'écrire de l'html dans un fichier .php en revanche, l'inverse n'est pas possible.

                // Chaque instruction doit se terminer par un point virgule ;

                // Liens utiles :

                // Doc officielle       : https://www.php.net/
                // Les bonnes pratiques : https://phptherightway.com/

                // Debuggage            : https://stackoverflow.com/

                // Suivre les news      : https://www.reddit.com/r/PHP/

                // Sommaire :
                // ----------
                // 01 : Instruction d'affichage
                // 02 : Variable : type, déclaration, affectation
                // 03 : La concaténation
                // 04 : Condition et opérateur de comparaison
                // 05 : Fonctions prédéfinies et utilisateur
                // 06 : Boucles (structure itérative)
                // 07 : Tableaux de données array
                // 08 : Les inclusions
                // 09 : Les objets

                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 01 : Instruction d'affichage
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------

                echo '<h2 class="bg-primary text-white p-3">01 : Instruction d\'affichage</h2>';
                // echo est une instruction permettant de faire un affichage (écrire dans le code source) via php

                echo 'Bonjour '; // ne pas oublier les ; en fin d'instruction

                echo '<br>à tous !'; // c'est à nous de gérer les retour à la ligne <br> et les espaces


                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 02 : Variable : type, déclaration, affectation
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // un espace nommé permettant de conserver une valeur qu'il est possible de modifier.

                // Une variable se déclare avec le signe $
                // caractères autorisés : az AZ 09 _ (une variable ne peut pas commencer par un chiffre)
                // PHP est sensible à la casse (on différencie les minuscules et les majuscules)

                echo '<h2 class="bg-primary text-white p-3">02 : Variables : type, déclaration, affectation</h2>';

                // les types de données : gettype() est une fonction prédéfine nous permettant de connaitre le type d'une information
                // https://www.php.net/manual/fr/function.gettype.php

                $a = 'du texte'; // déclaration d'une variable nommée $a et affectation de la valeur 'du texte' dans cette variable

                echo gettype($a); // type : string : une chaine de caractères.
                echo '<br>';

                $a = 123; // je change la valeur continue dans la variable $a

                echo gettype($a); // type : integer (int) : un chiffre entier.
                echo '<br>';

                $a = '123'; // ou "123" 

                echo gettype($a); // type : string
                echo '<br>';

                $a = 1.5;

                echo gettype($a); // type : double (float) : un chiffre à virgule
                echo '<br>';

                $a = true; // ou false ou TRUE ou FALSE (ce n'est pas sensible à la casse)

                echo gettype($a); // type : boolean : vrai ou faux
                echo '<br>';

                // il existe aussi array et object que l'on verra plus tard dans ce fichier.

                // Les constantes :
                // une constante comme une variable permet de conserver une valeur sauf que comme son nom l'indique, cette valeur restera constante. (on ne peut pas modifier la constante dans la suite du script, utile pour appeler une informaion dans notre code, lorsque l'on veut changer cette valeur on ne change que la constante)

                // Par convention : on écrit une variable en majuscule

                // définition d'une constante :
                // define('NOM_DE_LA_CONSTANTE', $sa_valeur);
                define('RACINE_SITE', 'http://monsite.fr');

                // tva
                define('TVA', 5.5);

                echo 'La racine url de notre projet est : ';
                echo RACINE_SITE;
                echo '<br>';

                echo 'Le taux de tva sur notre retaurant est de  : ';
                echo TVA;
                echo '<br>';

                // constantes magiques (déjà inscrite au langage)
                // deux underscores avant ET après
                echo __FILE__ ; // chemin complet jusqu'à ce fichier
                echo '<br>';

                echo __LINE__ ; // le numéro de la ligne dans le script
                echo '<br>';

                echo __DIR__ ; // chemin jusqu'au dossier parent de ce fichier
                

                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 03 : Concaténation
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------

                echo '<h2 class="bg-primary text-white p-3">03 : Concaténation</h2>';
                // raccourci d'écriture
                // la concaténation consiste a assembler des chaines de caractères les unes avec les autres qu'elles proviennent de texte brut, ou contenu dans une variable ou en résultat d'une fonction.

                // caractère de concaténation pour php : le point . que l'on peut traduire par "suivi de"
                $x = 'Bonjour';
                $y = 'à tous !';
                
                // affichage de ces deux variables sr une seule ligne :

                // Sans concaténation
                echo $x;
                echo ' ';
                echo $y;
                echo '<br>';

                // Avec concaténation
                echo $x . ' ' . $y . '<br>';

                // Spécificité de PHP : dans des guillemets, une variable est reconnue et interprétée (pas dans des apostrophes)
                echo "$x $y<br>";
                echo '$x $y<br>'; // ici les variables ne sont pas reconnues du fait des apostrophes


                $prenom = 'Mathieu ';  // on place la chaine Mathieu
                $prenom = 'admin'; // on écrase la précédente valeur par la nouvelle : admin

                echo $prenom . '<br>'; // affiche "admin"

                // concaténation lors de l'affectation (on rajoute sans écraser)

                $pseudo = 'Mathieu ';
                $pseudo .= 'admin'; // équivaut à écrire : $pseudo = $pseudo . 'admin';

                echo $pseudo . '<br>'; // affiche "Mathieu admin"


                echo '<h3 class="bg-success text-white p-3">Les opérateurs arithmétiques</h3>';

                $valeur1 = 10;
                $valeur2 = 5;

                // Addition :
                echo ($valeur1 + $valeur2) . '<br>'; // affiche 15

                // soustraction :
                echo ($valeur1 - $valeur2) . '<br>'; // affiche 5

                // multiplication :
                echo ($valeur1 * $valeur2) . '<br>'; // affiche 50

                // division :
                echo ($valeur1 / $valeur2) . '<br>'; // affiche 2

                // Le modulo :
                // le restant de la division en terme d'entier
                echo ($valeur1 % $valeur2) . '<br>'; // affiche 0
                echo (10 % 7) . '<br>'; // affiche 3

                // la puissance :
                echo ($valeur1 ** $valeur2) . '<br>'; // affiche 100 000

                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 04 : Condition et opérateur de comparaison
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------

                echo '<h2 class="bg-primary text-white p-3">04 : Condition et opérateur de comparaison</h2>';

                // permet de prévoir des cas possibles

                // if else (si sinon)
                $a = 10;
                $b = 5;
                $c = 2;

                if($a > $b) {
                    echo 'VRAI : La valeur de la variable $a est bien supérieure à la valeur de la variable $b<br>';
                } else { // jamais de parenthèses sur un else, le else représente toutes les autres possibilités
                    echo 'FAUX<br>';
                }

                // Plusieurs conditions obligatoires : ET : &&
                if($a > $b && $b > $c) {
                    echo 'VRAI : ok pour les deux conditions<br>';
                } else {
                    echo 'FAUX : l\'une ou l\'autre des deux conditions ou les deux sont fausses<br>';
                }

                // L'une ou l'autre d'un enemble de condition : OU : ||
                if($a < $b || $a > $c) {
                    echo 'VRAI : au moins une des conditions est vrai<br>';
                } else {
                    echo 'FAUX : toutes les conditions sont fausses<br>';
                }

                // if elseif else
                $a = 10;
                $b = 5;
                $c = 2;

                if($a == 9) {
                    echo 'Réponse 1<br>';
                } elseif($b > 7) {      // autre cas possible
                    echo 'Réponse 2<br>';
                } elseif($a != 10) {    // autre cas possible
                    echo 'Réponse 3<br>';
                } else {                // cas par défaut
                    echo 'Réponse 4<br>';
                }

                /*
                    Opérateurs de comparaison
                    -------------------------
                    =       affectation, ce n'est pas un opérateur de comparaison !!! 
                    ==      est égal à
                    !=      est différent de
                    <>      est différent de
                    ===     est strictement égal à en terme de valeur et de type
                    !==     est strictement différent de en terme de valeur et/ou de type
                    >       est strictement supérieur à
                    <       est strictement inférieur à
                    >=      supérieur ou égal
                    <=      inférieur ou égal
                */

                // Comparaison stricte : comparaison sur la valeur et sur le type
                $a1 = 1; // type integer
                $a2 = '1'; // type string
                $a3 = true; // type boolean

                if($a3 == $a2) {
                    echo 'C\'est la même valeur<br>';
                } else {
                    echo 'La valeur est différente<br>';
                }

                if($a3 === $a2) {
                    echo 'C\'est la même valeur et le même type<br>'; // C'est la même valeur
                } else {
                    echo 'La valeur et/ou le type sont différents<br>'; // La valeur et/ou le type sont différents
                }
                // La comparaison stricte est très importante lorsque l'on veut différencier la valeur 0 (par exemple une position) ou la valeur false (non ça n'a pas été trouvé).

                // Autre possibilité d'écriture
                // on est pas obligé de préciser le else (si on ne veut pas le gérer)
                if($a3 == $a2) {
                    echo '1 : C\'est la même valeur<br>';
                }

                // Sinon il est possible de remplacer les accolades {} par : et endif
                if($a3 == $a2) :
                    echo '2 : C\'est la même valeur<br>';
                else :
                    echo 'La valeur est différente<br>';
                endif;

                // Il est possible de ne pas mettre d'accolades ou : endif, uniquement si chaque cas ne contient qu'une seule ligne d'instruction
                if($a3 == $a2)
                    echo '3 : C\'est la même valeur<br>';
                else
                    echo 'La valeur est différente<br>';

                // écriture ternaire
                // condition ? vrai : faux ;
                // dans une condition ternaire, le ? représente le if, les : représentent le else
                echo ($a3 == $a2) ? '4 : C\'est la même valeur<br>' : 'La valeur est différente<br>';

                // isset() // outil de controle permettant de savoir si une variable existe (est définie)
                // Obligatoire de tester les variables lorsque cela vient d'une action utilisateur (formulaire, url, cookie)

                // $existe_pas = 'Bonjour';

                if( isset($existe_pas) ) {
                    echo $existe_pas . '<br>';
                } else {
                    echo 'Cette variable n\'existe pas<br>';
                }

                // empty() // outil de controle permettant de savoir si une variable est vide
                // Par exemple un champ pseudo est obligatoire dans un formulaire, empty() nous permettra de savoir s'il n'y a pas eu de saisie sur ce champ.

                $pseudo = ''; // valeurs considérées comme vide : false, 0, 0.0, -0, une chaine vide '' ou "", un tableay array vide et la valeur NULL
                // https://www.php.net/manual/fr/language.types.boolean.php#language.types.boolean.casting

                if( empty($pseudo) ) {
                    echo 'Attention, le pseudo est obligatoire<br>';
                } else {
                    echo $pseudo . '<br>';
                }

                // Autre outil pour mettre en place une condition : switch()
                $couleur = 'jaune';

                switch($couleur) {
                    case 'bleu' :
                        echo 'Vous aimez le bleu<br>';
                    break;
                    case 'vert' :
                        echo 'Vous aimez le vert<br>';
                    break;
                    case 'rouge' :
                        echo 'Vous aimez le rouge<br>';
                    break;
                    default:
                        echo 'Vous n\'aimez ni le bleu, ni le vert, ni le rouge';
                    break;
                }

                echo '<hr>';

                // exercice : refaire ce traitement avec l'outil if
                if($couleur == 'bleu') {
                    echo 'Vous aimez le bleu<br>';
                } elseif($couleur == 'vert') {
                    echo 'Vous aimez le vert<br>';
                } elseif($couleur == 'rouge') {
                    echo 'Vous aimez le rouge<br>';
                } else {
                    echo 'Vous n\'aimez ni le bleu, ni le vert, ni le rouge';
                }

                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 05 : Fonctions prédéfinies et utilisateur
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------

                echo '<h2 class="bg-primary text-white p-3">05 : Fonctions prédéfinies et utilisateur</h2>';

                // Fonctions prédéfinies : déjà inscrite au langage, le dev ne fait que l'exécuter.
                // Il y en a beaucoup, voir la doc officielle.

                // fonction date() : permet de gérer les format d'affichage d'une date
                // https://www.php.net/manual/fr/function.date.php
                // Pour les formats acceptés : https://www.php.net/manual/fr/datetime.format.php
                
                echo 'Date du jour au format anglais : ' . date('Y-m-d h:i:s') . '<hr>';
                echo 'Date du jour au format français : ' . date('d/m/Y h:i:s') . '<hr>';

                //---

                // Compter le nombre de caractères dans une chaine.
                // iconv_strlen()

                $pseudo = 'admin';

                $taille_pseudo = iconv_strlen($pseudo);

                if($taille_pseudo < 4 || $taille_pseudo > 14) {
                    echo 'Attention, le pseudo doit avoir entre 4 et 14 caractères inclus<br>';
                } else {
                    echo $pseudo . '<hr>';
                }


                echo '<h3>Fonctions utilisateur</h3>';

                // déclarée et exécutée par le dev
                // Il est possible d'appeler une fonction avant sa déclaration

                // déclaration :
                function separateur() {
                    echo '<hr><hr><hr>';
                }

                // exécution :
                separateur();

                // si la fonction a un echo, l'affichage sera autmatique
                // si la fonction renvoie une réponse return, c'est à nous de prévoir le echo lors de l'appel de la fonction

                // Fonction avec argument : un argument est une information passée à la fonction (dans ses parenthèses) permettant de modifier son comportement

                // fonction pour dire bonjour à un utilisateur
                function dire_bonjour($qui) {
                    return 'Bonjour ' . $qui . ', bienvenue sur notre site<br>';
                }

                // echo dire_bonjour(); // Fatal error: Uncaught ArgumentCountError // si un argument est attendu, on est obligé de le fournir

                echo dire_bonjour('Admin');

                $prenom = 'Mathieu';
                echo dire_bonjour($prenom);

                separateur();

                // fonction avec argument facultatif, pour rendre un argument facultatif, il suffit de lui donner une valeur par défaut
                function calcul_tva($prix, $taux = 1.2) {
                    return 'Le prix TTC est : ' . ($prix * $taux) . '€<br>';
                }
                // 20% => on multiplie par 1.2
                // 5.5% => on multiplie par 1.055

                echo 'Pour un prix de 1000 avec une tva à 20% : ' . calcul_tva(1000); // ici le $taux sera 1.2 (valeur par défaut)
                echo 'Pour un prix de 1000 avec une tva à 5.5% : ' . calcul_tva(1000, 1.055);

                $price = rand(100, 500); // rand() permet d'obtenir un entier aléatoire compris entre deux entier fourni en argument
                echo 'Pour un prix de ' . $price . ' avec une tva à 20% : ' . calcul_tva($price);
                
                // Environnement (scope)
                // dans le script il y a deux environnement : global et local
                // global : tout le script
                // local : à l'intérieur d'une fonction
                // une variable déclarée dans une fonction (local) n'existe pas à l'extérieur de la fonction (global)

                separateur();

                $animal = 'chat';

                function jardin() {
                    $animal = 'chien';
                    return $animal;
                }

                echo $animal . '<br>'; // chat
                jardin();
                echo $animal . '<br>'; // chat 

                // ---

                $ville = 'Montpellier'; //  global
                function location() {
                    global $ville; // le mot clé global permet de récupérer une variable depuis l'espace global, sinon la variable ne serait pas connue dans la fonction.
                    return 'Je suis dans ' . $ville . '<br>';
                }

                echo location();


                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 06 : Boucles (structure itérative)
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------

                echo '<h2 class="bg-primary text-white p-3">06 : Boucles (structure itérative)</h2>';

                // Pour mettre en place une boucle, nous avons besoin de 3 informations :
                // une valeur de départ (compteur)
                // une condition d'entrée
                // une incrémentation ou décrémentation (on change la valeur du compteur)

                // Boucle qui tourne 10 fois :
                // while() {}

                $i = 0; // valeur de départ

                while($i < 10) { // condition d'entrée
                    echo $i . ' ';
                    $i++; // incrémentation // équivaut à écrire $i = $i + 1
                }

                separateur();
                // for() {}
                // for(valeur_de_depart; condition; incrementation)
                for($i = 0; $i < 10; $i++) {
                    echo $i . ' ';
                }


                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 07 : Tableaux de données array
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------

                echo '<h2 class="bg-primary text-white p-3">07 : Tableaux de données array</h2>';

                // Outil de base : une variable simple (une information typée)
                // Outil amélioré : une variable de type array (un ensemble d'information)
                // Outil encore amélioré : une variable de type object (un ensemble d'information + des fonctions(methodes))

                // Un table nous permet de conserver dans une variable plusieurs valeurs.
                // un tableau array est toujours composé de deux colonnes :
                    // une colonne avec l'indice (position)
                    // une colonne avec la valeur correspondante.

                // On appelle toujours l'indice pour obtenir la valeur

                $tab_fruit = array('Pommes', 'Fraises', 'Oranges', 'Poires');
                echo gettype($tab_fruit);
                separateur();

                // echo $tab_fruit;

                // On ne peut pas faire un echo sur le tableau complet en revanche on peut appeler une information avec son indice
                // Par défaut les indices sont numériques et commencent à 0
                echo $tab_fruit[1] . '<br>';

                // Outils d'affichage améliorés permettant de voir ce que contient une variable simple ou un tableau ou un objet (outil en phase de dev)
                // print_r()
                echo '<pre>'; // balise html permettant les retours à la ligne
                print_r($tab_fruit); 
                echo '</pre>';

                // var_dump()
                echo '<pre>'; // balise html permettant les retours à la ligne
                var_dump($tab_fruit); 
                echo '</pre>';

                // pour rajouter :
                // on peut forcer l'indice
                $tab_fruit[4] = 'Cerises';

                // on laisse php gérer l'indice
                $tab_fruit[] = 'Ananas';

                echo '<pre>'; // balise html permettant les retours à la ligne
                print_r($tab_fruit); 
                echo '</pre>';

                // autre façon de déclarer un tableau array : littérale
                $tab_jour = ['lundi', 'mardi', 'mercredi', 'jeudi'];
                echo '<pre>'; // balise html permettant les retours à la ligne
                print_r($tab_jour); 
                echo '</pre>';

                // il est aussi possible de le faire de cette manière :
                $categories[] = 'Pantalons';
                $categories[] = 'Chemises';
                $categories[] = 'Chapeaux';
                $categories[] = 'Chaussettes';
                $categories[] = 'Tshirts';

                echo '<pre>'; // balise html permettant les retours à la ligne
                print_r($categories); 
                echo '</pre>';

                // Rajouter dans un tableau avec la fonction array_push
                // array_push(le_tableau, valeur1, valeur2, valeur3, ...)
                array_push($categories, 'Chaussures', 'Parapluies', 'Casquettes');

                echo '<pre>'; 
                print_r($categories); 
                echo '</pre>';
    
                // pour ordonner en ordre croissant ou alphabétique
                sort($categories);

                echo '<pre>'; 
                print_r($categories); 
                echo '</pre>';

                // Pour connaitre le nombre d'élément dans un tableau : count()
                $taille_tableau = count($categories);

                echo '<ul class="list-group">';
                for($i = 0; $i < $taille_tableau; $i++) {
                    echo '<li class="list-group-item">' . $categories[$i] . '</li>';
                }
                echo '</ul>';


                // Il est possible d'avoir des indices en chaine de caractères
                $mdp = password_hash('soleil', PASSWORD_DEFAULT); // on hash le mdp pour la sécurité
                $utilisateur = ['pseudo' => 'admin', 'mail' => 'admin@mail.fr', 'mdp' => $mdp, 'adresse' => '1 rue du truc', 'cp' => 75000, 'ville' => 'Paris'];

                echo '<pre>'; 
                print_r($utilisateur); 
                echo '</pre>';

                // on ne garde pas le mdp
                // pour enlever un élément du tableau :
                unset($utilisateur['mdp']);

                echo '<pre>'; 
                print_r($utilisateur); 
                echo '</pre>';

                echo 'Bonjour ' . $utilisateur['pseudo'] . ', bienvenue sur notre site, votre mail de contact est : ' . $utilisateur['mail'] . '<hr>';

                separateur();

                // boucle foreach() spécifique aux tableaux et aux objets
                // dans une boucle foreach, après le mot clé obligatoire AS :
                    // une seule variable : on récupère la valeur en cours à chaque tour
                    // deux variables : la première récupère l'indice, la deuxième récupère la valeur
                echo '<ul class="list-group">';
                foreach($utilisateur AS $val) {
                    echo '<li class="list-group-item">' . $val . '</li>';
                }
                echo '</ul>';

                separateur();

                echo '<ul class="list-group">';
                foreach($utilisateur AS $indice => $valeur) {
                    echo '<li class="list-group-item">' . $indice . ' : ' . $valeur . '</li>';
                }
                echo '</ul>';

                separateur();

                echo '<ul class="list-group">';
                foreach($tab_fruit AS $index => $value) {
                    echo '<li class="list-group-item">' . $index . ' : ' . $value . '</li>';
                }
                echo '</ul>';

                // il est possible d'avoir un ou des array dans un array : on parle de tableau multidimensionnel
                // Exemple : panier
                //  $panier = [ 'titre' => [ 'tshirt blanc', 'pantalon noir', 'echarpe rouge' ], 'prix' => [ 14, 30, 9 ], 'quantite' => [ 2, 1, 1 ] ];

                //---

                $panier = [
                    0 => [
                        'titre' => 'Tshirt blanc',
                        'prix' => 14,
                        'quantite' => 2
                    ],
                    1 => [
                        'titre' => 'Pantalon noir',
                        'prix' => 30,
                        'quantite' => 1
                    ],
                    2 => [
                        'titre' => 'Echarpe',
                        'prix' => 7,
                        'quantite' => 1
                    ]
                ];

                echo '<pre>'; 
                print_r($panier); 
                echo '</pre>';

                echo '<h3>Votre panier</h3>';
                echo '<ul>';
                
                foreach($panier AS $sous_tableau) {
                    echo '<li>Produit : ';
                    foreach($sous_tableau AS $indice => $info) {
                        echo '<b>' . $indice . ' : </b>' . $info . ' | ';
                    }
                    echo '</li>';
                }
                
                echo '</ul>';


                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                // 09 : Les objets
                //-------------------------------------------------------------------------
                //-------------------------------------------------------------------------
                echo '<h2 class="bg-primary text-white p-3">09 : Les objets</h2>';
                // Outil de base : une variable simple (une information typée)
                // Outil amélioré : une variable de type array (un ensemble d'information)
                // Outil encore amélioré : une variable de type object (un ensemble d'information (attributs ou propriétés) + des fonctions (methodes))

                // dans un objet il y a une notion de visibilité : public protected et private
                // Pour cette approche rapide on utilise que public

                // Un objet est toujours issu d'une class (c'est le modèle de construction)
                class User 
                {
                    public $pseudo = 'Admin';
                    public $mail = 'admin@mail.fr';
                    public $adresse = '1 rue du truc';
                    public $cp = 75000;
                    public $ville = 'Paris';
                } 

                // on crée un objet depuis la class
                $user1 = new User;

                echo '<pre>';
                print_r($user1);
                echo '</pre>';

                // pour piocher dans un objet on utilise la fleche ->
                echo 'Bonjour ' . $user1->pseudo . ', bienvenue sur notre site, votre mail de contact est : ' . $user1->mail . '<hr>';


            ?>





            
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>