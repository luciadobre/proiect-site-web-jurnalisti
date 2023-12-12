<?php
session_start();
include('Database.php');
include('User.php');
include('Post.php');

$user = new User(Database::getConnection());
$post = new Post(Database::getConnection());

$postId = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($postId)) {
    // If no ID, redirect to index.php
    header("Location: index.php");
    exit();
}

// If no user is logged in, redirect to login.php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$postDetails = $post->getPostById($postId);

if (empty($postDetails)) {
    // If no post
    header("Location: index.php");
    exit();
}

// Check if the 'rol' key exists in the '$_SESSION['user']' array
$userRole = isset($_SESSION['user']['rol']) ? $_SESSION['user']['rol'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style_post.css">
    <title>View Post</title>
    <style>
        .button-container {
            margin-top: 10px;
        }

        .button-container button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<h1><?php echo $postDetails['titlu']; ?></h1>
<p>Autor: <?php echo $postDetails['autor']; ?></p>
<p>Continut: <?php echo $postDetails['continut']; ?></p>

<p>Status validare: <?php echo $postDetails['validat'] ? 'Validat' : 'Nevalidat'; ?></p>

<div class="button-container">
    <?php
    if ($userRole === 'jurnalist' || $userRole === 'editor') {
        echo '<button onclick="editPost(' . $postDetails['id'] . ')">Editare</button>';
        echo '<button onclick="deletePost(' . $postDetails['id'] . ')">Stergere</button>';
        echo '<button onclick="validatePost(' . $postDetails['id'] . ')">Validare</button>';
    }
    ?>
</div>

<script>
    function editPost(postId) {
        window.location.href = 'edit_post.php?id=' + postId;
    }

    function deletePost(postId) {
        if (confirm('Sunteti sigur ca doriti sa stergeti acest articol?')) {
            window.location.href = 'delete_post.php?id=' + postId;
        }
    }

    function validatePost(postId) {
        if (confirm('Validati acest articol?')) {
            window.location.href = 'validate_post.php?id=' + postId;
        }
    }
</script>

</body>
</html>
