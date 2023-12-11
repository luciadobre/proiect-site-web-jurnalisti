<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = isset($_POST['post_id']) ? $_POST['post_id'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    $sql = "UPDATE articole SET titlu='$title', autor='$author', continut='$content', categorie='$category' WHERE id='$postId'";
    if (Database::getConnection()->query($sql) === TRUE) {
        echo "Articol actualizat";
    } else {
        echo "Error: " . $sql . "<br>" . Database::getConnection()->error;
    }
}


$postId = isset($_GET['id']) ? $_GET['id'] : '';
$postDetails = Database::getConnection()->query("SELECT * FROM articole WHERE id='$postId'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style_edit.css">
    <title>Editare articol</title>
</head>
<body>

<h1>Editare articol</h1>

<form method="post" action="edit_post.php">
    <input type="hidden" name="post_id" value="<?php echo $postDetails['id']; ?>">

    <label for="title">Titlu:</label>
    <input type="text" id="title" name="title" value="<?php echo $postDetails['titlu']; ?>" required>
    <br>

    <label for="author">Autor:</label>
    <input type="text" id="author" name="author" value="<?php echo $postDetails['autor']; ?>" required>
    <br>

    <label for="content">Continut:</label>
    <textarea id="content" name="content" rows="4" required><?php echo $postDetails['continut']; ?></textarea>
    <br>

    <label for="category">Categorie:</label>
    <input type="text" id="category" name="category" value="<?php echo $postDetails['categorie']; ?>" required>
    <br>

    <button type="submit">Actualizare articol</button>
</form>

</body>
</html>
