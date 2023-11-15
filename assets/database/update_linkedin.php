<?php
session_start();

if(isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    $user_id = $_SESSION["user_id"];
    $linkedin = $mysqli->real_escape_string($_POST["linkedin"]);

    // Update the LinkedIn field in the database
    $update_sql = "UPDATE user SET linkedin = '$linkedin' WHERE id = $user_id";
    $mysqli->query($update_sql);

    header("Location: ../../profile-page.php");
    exit;
}
?>





