<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container border p-3">
        <div class="row">
            <div class="col-12">
                <h1 class="bg-success text-white p-3 mb-5">Page 2</h1>
                <a href="page1.php">Aller sur la page 1</a><br><br><br>

                <?php 
                // GET est un protocole http (ce n'est pas lié à php)
                // GET représente l'url
                //  Si au niveau de l'url il y a un ?, l'adresse de la page est avant le ?, ensuite on retrouve des informations sous la forme :
                    // indice=valeur&indice2=valeur2&indice3=valeur3&...
                // L'outil php où l'on retrouve ces informations : $_GET
                // $_GET est une superglobale (les superglobales sont disponibles dans l'espace global et local aussi naturellement)
                // Les superglobales sont des tableaux array

                // On regarde avec un print_r
                // echo '<pre>';
                // print_r($_GET); 
                // echo '</pre>';

                // Exercice : affichez les informations présentes dans l'url avec des echo

                /*
                foreach($_GET AS $indice => $valeur) {
                    echo '<b>' . $indice . ' : </b>' . $valeur . '<hr>';
                }
                */
                
                if( isset($_GET['categorie']) && isset($_GET['couleur']) ) {
                    echo '<b>Catégorie : </b>' . $_GET['categorie'] . '<hr>';
                    echo '<b>Couleur : </b>' . $_GET['couleur'] . '<hr>';
                } else {
                    echo 'Veuillez choisir une categorie et une couleur sur la page 1<hr>';
                }
                
                
                
                ?>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>