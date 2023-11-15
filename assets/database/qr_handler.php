<?php

//Isto foi para um teste acho ainda não funciona

session_start();

if (isset($_SESSION['user_id']) && isset($_GET['add_points'] && $_SERVER["REQUEST_METHOD"] === "POST")) {
    $user_id = intval($_SESSION['user_id']);
    $points_to_add = intval($_GET['add_points']);
    
    $mysqli = require __DIR__ . "/database.php";
    
    // Query to update points for the user
    $update_sql = "UPDATE users SET points = points + $points_to_add WHERE id = $user_id";
    $mysqli->query($update_sql);
}