<?php
$servername = "localhost";
$connusername = "mohanned";
$connpassword = "1105";
$database_name = "durar";

$conn = mysqli_connect($servername, $connusername, $connpassword, $database_name);

mysqli_set_charset($conn, "utf8");

if (!$conn) {
    die("connection failed:" . mysqli_connect_error());
}
?>
