<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page non trouvée</title>
</head>
<body style="
    margin:0;
    padding:0;
    font-family:Arial, Helvetica, sans-serif;
    background-color:#f4f4f4;
">
    <?php 
        include(dirname(__DIR__)."/components/header.php") ;
        // var_dump(dirname(__DIR__)."/components/header.php");
    ?>
    
    <div style="
        max-width:600px;
        margin:100px auto;
        padding:40px;
        background:#ffffff;
        border-radius:8px;
        box-shadow:0 4px 10px rgba(0,0,0,0.1);
        text-align:center;
    ">
        <h1 style="font-size:60px; color:#ff4d4d; margin-bottom:20px;">
            404
        </h1>
        <h2 style="color:#333; margin-bottom:20px;">
            Oups ! Page non trouvée
        </h2>
        <p style="color:#555; line-height:1.6; margin-bottom:30px;">
            La page que vous recherchez n’existe pas ou a été déplacée.
        </p>
        <a href="/poo/MVC/" style="
            display:inline-block;
            padding:12px 25px;
            background:#007BFF;
            color:#ffffff;
            text-decoration:none;
            border-radius:4px;
            font-size:16px;
        ">
            Retour à l'accueil
        </a>
    </div>

</body>
</html>
