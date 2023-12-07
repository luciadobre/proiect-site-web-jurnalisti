<?php
session_start();
include('connection.php');
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
<p><?php echo $postDetails['continut']; ?></p>

<div class="button-container">
    <?php
    if ($userRole === 'jurnalist') {
        echo '<button onclick="editPost(' . $postDetails['id'] . ')">Editare</button>';
        echo '<button onclick="deletePost(' . $postDetails['id'] . ')">Stergere</button>';
    } elseif ($userRole === 'editor') {
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
        alert('Stergere post cu ID ' + postId);
        // Implement post deletion from the database
    }

    function validatePost(postId) {
        alert('Validare post cu ID ' + postId);
        // Implement post validation logic
    }
</script>

</body>
</html>
