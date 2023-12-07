<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postId = isset($_GET['id']) ? $_GET['id'] : '';

    $sql = "DELETE FROM articole WHERE id='$postId'";
    if (Database::getConnection()->query($sql) === TRUE) {
        echo "Articol sters cu succes";
    } else {
        echo "Error: " . $sql . "<br>" . Database::getConnection()->error;
    }

    header("Location: index.php");
    exit();
}
?>