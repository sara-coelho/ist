<?php

$host = "db.tecnico.ulisboa.pt"; //same as the webserver
$dbname = "ist1102881"; //name of the database
$username = "ist1102881"; //only recomended when connecting locally (ver o que isto implica)
$password = "tusc9505";

$mysqli = new mysqli($host, $username, $password, $dbname); //nesta ordem

if($mysqli->connect_errno){
    die("Connection error" . $mysqli->connect_error);
}

return $mysqli;

?>