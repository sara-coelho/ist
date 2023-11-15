<?php

// validar os dados inseridos

if (empty($_POST["user"])){
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8){
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-zA-Z]/", $_POST["password"])) {
    die("Password must contain at least one letter");
}
if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}
if ($_POST["password"] != $_POST["password_confirmation"]){
    die("Passwords do not match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php"; // this will save in the variable $mysqli what is being returned in the database.php file

$sql = "INSERT INTO user (user, email, password_hash) VALUES (?, ?, ?)";
$insertStmt = $mysqli->stmt_init();

if (!$insertStmt->prepare($sql)){
    die("SQL error: " . $mysqli->error);
}

$insertStmt->bind_param("sss", $_POST["user"], $_POST["email"], $password_hash);

$checkEmailQuery = "SELECT COUNT(*) FROM user WHERE email = ?";
$checkStmt = $mysqli->stmt_init();

if (!$checkStmt->prepare($checkEmailQuery)){
    die("SQL error: " . $mysqli->error);
}

$checkStmt->bind_param("s", $_POST["email"]);
$checkStmt->execute();
$checkStmt->bind_result($emailCount);
$checkStmt->fetch();
$checkStmt->close();

if ($emailCount > 0) {
    die("Email address already exists. Please choose a different email.");
} else {
    if (!$insertStmt->execute()) {
        die("SQL error: " . $insertStmt->error);
    }
    $insertStmt->close();
    header("Location: ../../signup-success.html");
    exit;
}


?>