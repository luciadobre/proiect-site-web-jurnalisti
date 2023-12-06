<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    $sql = "INSERT INTO articole (titlu, autor, continut, categorie) VALUES ('$title', '$author', '$content', '$category')";
    if ($GLOBALS['conn']->query($sql) === TRUE) {
        echo "New post created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $GLOBALS['conn']->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>

<h1>Create a New Post</h1>

<form method="post" action="create_post.php">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    <br>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" required>
    <br>

    <label for="content">Content:</label>
    <textarea id="content" name="content" rows="4" required></textarea>
    <br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" required>
    <br>

    <button type="submit">Create Post</button>
</form>

</body>
</html>
