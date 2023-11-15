<?php
session_start();

if(isset($_SESSION["user_id"])){
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mysqli = require __DIR__ . "/database.php";
        $description = $mysqli->real_escape_string($_POST["description"]);
        $user_id = $_SESSION["user_id"];
        
        // Update the user's description in the database
        $update_sql = "UPDATE user SET descricao = '$description' WHERE id = $user_id";
        $mysqli->query($update_sql);
    }

    header("Location: ../../profile-page.php");
    exit;
}
?>