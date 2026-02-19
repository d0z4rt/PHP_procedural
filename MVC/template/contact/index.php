<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
</head>
<body style="margin:0; padding:0; font-family:Arial, Helvetica, sans-serif; background-color:#f4f4f4;">

    <?php 
        include(dirname(__DIR__)."/components/header.php") ;
        // var_dump(dirname(__DIR__)."/components/header.php");
    ?>
    <div style="
        max-width:500px;
        margin:50px auto;
        background:#ffffff;
        padding:30px;
        border-radius:8px;
        box-shadow:0 4px 10px rgba(0,0,0,0.1);
    ">
        <h2 style="margin-bottom:20px; text-align:center; color:#333;">
            Contactez-nous
        </h2>

        <form method="post" action="">
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; color:#555;">
                    Nom
                </label>
                <input type="text" name="name" required
                    style="
                        width:100%;
                        padding:10px;
                        border:1px solid #ccc;
                        border-radius:4px;
                        font-size:14px;
                    ">
            </div>

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
                    Message
                </label>
                <textarea name="message" rows="5" required
                    style="
                        width:100%;
                        padding:10px;
                        border:1px solid #ccc;
                        border-radius:4px;
                        font-size:14px;
                        resize:vertical;
                    "></textarea>
            </div>

            <button type="submit"
                style="
                    width:100%;
                    padding:12px;
                    background:#007BFF;
                    color:#ffffff;
                    border:none;
                    border-radius:4px;
                    font-size:16px;
                    cursor:pointer;
                ">
                Envoyer
            </button>
        </form>
    </div>

</body>
</html>
