<?php

    $is_invalid = false;

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $mysqli = require __DIR__ . "/assets/database/database.php";

        if ($mysqli->connect_error) {
            die("Database connection failed: " . $mysqli->connect_error);
        }

        $sql = sprintf("SELECT * FROM user
                WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();
        
        if ($user){
            if (password_verify($_POST["password"], $user["password_hash"])){
                
                session_start();

                session_regenerate_id();
                
                $_SESSION["user_id"] = $user["id"];
                echo '<script>';
                echo 'console.log(' . json_encode($user) . ');';
                echo '</script>';
                header("Location: index.php");
                exit;
            }
        }

        $is_invalid = true;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/styles/styles_login_signup.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Poiret One' rel='stylesheet'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="row">
            <div class="signupDesign"></div>
            <div class="signupForm">
                <div class="inSignForm">
                    <h1 style="margin-bottom: 0px;">Bem Vind@!</h1>
                    <h2 style="margin-top: -5px; margin-bottom: 30px;">DE VOLTA</h2>
                    <form method="post">
                        <div>
                            <label for="email">Endereço de Email</label>
                            <input type="email" name="email" id="email"
                            value = "<?= htmlspecialchars($_POST["email"] ?? "")?>">
                        </div>
                        <div>
                            <label for="password">Palavra Passe</label>
                            <?php if ($is_invalid): ?>
                                    <em>Invalid login</em>
                            <?php endif; ?>
                            <input type="password" name="password" id="password">
                        </div>
                        <button>LOG IN</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
