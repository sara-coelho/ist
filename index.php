<?php

session_start();

if(isset($_SESSION["user_id"])){
    $mysqli = require __DIR__ . "/assets/database/database.php";
    $sql = "SELECT * FROM user WHERE id={$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>index</title>
        <meta charset="UTF-8">
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <style>
            .qrcodeReader{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            #reader{
                width: 600px;
            }
            #result{
                text-align: center;
                font-size: 1.5rem;
            }
            #reader__scan_region img{
                display: none;
            }
        </style>
    </head>
    <body>
        <h1>Home</h1>
        <?php if (isset($user)):?>
            <p>Hello, <?= htmlspecialchars($user["user"])?></p>
            <a href="assets/database/logout.php">Log Out</a>
            <form method="post" action="assets/database/qr_handler.php">
                <div class="qrcodeReader">
                    <div id="reader"></div>
                    <div id="result"></div>
                </div>
            </form>
            

        <?php else: ?>
            <p><a href="login.php">Log In</a> or <a href="signup.html">Sign Up</a>.</p>
        <?php endif; ?>


        <script>
            const scanner = new Html5QrcodeScanner('reader', {
                qrbox: {
                    width: 250,
                    height: 250,
                },
                fps: 20,
            });

            scanner.render(success, error);

            function success(result){
                console.log(result);
                document.getElementById('result').innerHTML = `
                    <h2>Success!</h2>
                    <p><a href="${result}">${result}</a></p>
                `;

                scanner.clear();
                document.getElementById('reader').remove();
            }

            function error(err){
                console.log(err);
            }

        </script>
    </body>

</html>