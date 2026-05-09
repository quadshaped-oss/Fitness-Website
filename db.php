<?php
$host = "localhost";
$user = "database_user";
$pass = "password";
$db = "db_name";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection Failed");
}
?>
