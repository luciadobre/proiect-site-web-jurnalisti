<?php
$servername = "mysql";
$username = "root";
$password = "root";
$database = "articole";

$conn = new mysqli($servername, $username, $password);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
