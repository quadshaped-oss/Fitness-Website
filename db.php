<?php
$host = "localhost";
$user = "pptoolkj_fitness";
$pass = "Prince@1234pro";
$db = "pptoolkj_fitness";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection Failed");
}
?>