<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body style="margin:0; padding:0; font-family:Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
    <?php 
        include(dirname(__DIR__) . "/components/header.php") ;
        // var_dump(dirname(__DIR__)."/components/header.php");
    ?>
    <div style="
        max-width:400px;
        margin:80px auto;
        background:#ffffff;
        padding:30px;
        border-radius:8px;
        box-shadow:0 4px 10px rgba(0,0,0,0.1);
    ">
        <h2 style="margin-bottom:25px; text-align:center; color:#333;">
            Connexion
        </h2>

        <!-- <form method="post" action="">
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; color:#555;">
                    Email
                </label>
                <input type="email" name="email" required
                    style="
                        width:100%;
                        padding:10px;
                        border:1px solid #ccc;
                        border-radius:4px;
                        font-size:14px;
                    ">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; color:#555;">
                    Mot de passe
                </label>
                <input type="password" name="password" required
                    style="
                        width:100%;
                        padding:10px;
                        border:1px solid #ccc;
                        border-radius:4px;
                        font-size:14px;
                    ">
            </div>

            <button type="submit"
                style="
                    width:100%;
                    padding:12px;
                    background:#28a745;
                    color:#ffffff;
                    border:none;
                    border-radius:4px;
                    font-size:16px;
                    cursor:pointer;
                ">
                Se connecter
            </button>
        </form> -->

        <?php 
            echo $form->render();
        ?>

        <p style="margin-top:15px; text-align:center; font-size:14px;">
            <a href="/register" style="color:#007BFF; text-decoration:none;">
                Créer un compte
            </a>
        </p>
    </div>

</body>
</html>
