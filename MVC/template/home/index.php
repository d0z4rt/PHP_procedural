<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
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

    <pre>
        <?php echo var_dump($user); ?>
    </pre>
    <div style="
        max-width:900px;
        margin:60px auto;
        padding:20px;
    ">
        <h1 style="
            text-align:center;
            margin-bottom:40px;
            color:#333;
        ">
            Sur la page d'accueil
        </h1>

        <div style="
            display:flex;
            flex-direction:column;
            gap:30px;
            flex-wrap:wrap;
            justify-content:center;
        ">

            <!-- Section Prise de RDV -->
            <div style="
                flex:1;
                min-width:260px;
                background:#ffffff;
                padding:25px;
                border-radius:8px;
                box-shadow:0 4px 10px rgba(0,0,0,0.1);
            ">
                <h2 style="color:#333; margin-bottom:15px;">
                    Prendre rendez-vous
                </h2>

                <p style="color:#555; line-height:1.6; margin-bottom:25px;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>

                <a href="/poo/MVC/contact"
                   style="
                       display:inline-block;
                       padding:12px 20px;
                       background:#007BFF;
                       color:#ffffff;
                       text-decoration:none;
                       border-radius:4px;
                       font-size:15px;
                   ">
                    Prendre un RDV
                </a>
            </div>

            <!-- Section Connexion -->
            <div style="
                flex:1;
                min-width:260px;
                background:#ffffff;
                padding:25px;
                border-radius:8px;
                box-shadow:0 4px 10px rgba(0,0,0,0.1);
            ">
                <h2 style="color:#333; margin-bottom:15px;">
                    Connexion
                </h2>

                <p style="color:#555; line-height:1.6; margin-bottom:25px;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Accédez à votre espace personnel pour gérer vos informations.
                </p>

                <a href="/poo/MVC/login"
                   style="
                       display:inline-block;
                       padding:12px 20px;
                       background:#28a745;
                       color:#ffffff;
                       text-decoration:none;
                       border-radius:4px;
                       font-size:15px;
                   ">
                    Se connecter
                </a>
            </div>

        </div>
    </div>

</body>
</html>
