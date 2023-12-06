<?php
session_start();
include('connection.php');

$postId = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($postId)) {
    // if no id
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM articole WHERE id = $postId";
$result = $GLOBALS['conn']->query($sql);

if ($result && $result->num_rows > 0) {
    $post = $result->fetch_assoc();
} else {
    // if no post
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
</head>
<body>

<h1><?php echo $post['titlu']; ?></h1>
<p>Autor: <?php echo $post['autor']; ?></p>
<p><?php echo $post['continut']; ?></p>

</body>
</html>
