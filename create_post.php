<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    $sql = "INSERT INTO articole (titlu, autor, continut, categorie, validat) VALUES ('$title', '$author', '$content', '$category', FALSE)";
    if (Database::getConnection()->query($sql) === TRUE) {
        echo "Articol nou creat";
    } else {
        echo "Error: " . $sql . "<br>" . Database::getConnection()->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style_create.css">
    <title>Creare articol</title>
</head>
<body>

<h1>Creare articol nou</h1>

<form method="post" action="create_post.php">
    <label for="title">Titlu:</label>
    <input type="text" id="title" name="title" required>
    <br>

    <label for="author">Autor:</label>
    <input type="text" id="author" name="author" required>
    <br>

    <label for="content">Continut:</label>
    <textarea id="content" name="content" rows="4" required></textarea>
    <br>

    <label for="category">Categorie:</label>
    <input type="text" id="category" name="category" required>
    <br>

    <button type="submit">Creare articol</button>
</form>

</body>
</html>
