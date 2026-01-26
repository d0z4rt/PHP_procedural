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
                $images = ['image1', 'image2', 'image3', 'image4', 'image5'];
                // EXERCICE :
                // 01 : récupérez 5 images et les rennomer de cette manière (l'extension importe peu mais les images doivent avoir la même extension) image1.jpg, image2.jpg, image3.jpg, image4.jpg, image5.jpg
                // 02 : affichez 1 des 5 images avec un echo et un img src
                // 03 : affichez 5 fois la même image avec un seul echo et un seul img src dans le code
                // 04 : affichez les 5 différentes images avec toujours un seul echo et un seul img src dans le code

                '<img src="./' . $images[0] . '.jpg" />';

                for ($i = 0; $i < 5; $i++) {

                    echo '<img src="./' . $images[0] . '.jpg" />';
                }

                echo '<br/>';

                foreach ($images as $image) {
                    echo '<img src="./' . $image . '.jpg" />';
                }

                ?>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>