<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postId = isset($_GET['id']) ? $_GET['id'] : '';

    $sql = "UPDATE articole SET validat = TRUE WHERE id='$postId'";
    if (Database::getConnection()->query($sql) === TRUE) {
        echo "Articol validat cu succes";
    } else {
        echo "Error: " . $sql . "<br>" . Database::getConnection()->error;
    }

    header("Location: index.php");
    exit();
}
?>
