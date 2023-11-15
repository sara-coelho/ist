<?php
session_start();

if (isset($_SESSION["user_id"]) && isset($_POST['update_workshops'])) {
    $mysqli = require __DIR__ . "/database.php";
    $user_id = $_SESSION["user_id"];

    // Fetch the current workshops field value
    $sql = "SELECT workshops FROM user WHERE id = $user_id";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    // Check if the field is empty
    $workshops = empty($row['workshops']) ? "1" : $row['workshops'] . ",1";

    // Update the workshops field in the database
    $update_sql = "UPDATE user SET workshops = '$workshops' WHERE id = $user_id";
    $mysqli->query($update_sql);

    header("Location: ../../profile-page.php");
    exit;
}
?>






