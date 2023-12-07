<?php
session_start();
include('connection.php');

$postId = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($postId)) {
    // If no ID, redirect to index.php
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM articole WHERE id = $postId";
$result = $GLOBALS['conn']->query($sql);

if ($result && $result->num_rows > 0) {
    $post = $result->fetch_assoc();
    //Check if the 'rol' key exists in the '$_SESSION['user']' array
    if (isset($_SESSION['user']['rol'])) {
        $userRole = $_SESSION['user']['rol'];
    } else {
        $userRole = '';
    }
} else {
    // If no post
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

<h1><?php echo $post['titlu']; ?></h1>
<p>Autor: <?php echo $post['autor']; ?></p>
<p><?php echo $post['continut']; ?></p>

<div class="button-container">
    <?php
    if ($userRole === 'jurnalist') {
        echo '<button onclick="editPost(' . $post['id'] . ')">Editare</button>';
        echo '<button onclick="deletePost(' . $post['id'] . ')">Stergere</button>';
    } elseif ($userRole === 'editor') {
        echo '<button onclick="editPost(' . $post['id'] . ')">Editare</button>';
        echo '<button onclick="deletePost(' . $post['id'] . ')">Stergere</button>';
        echo '<button onclick="validatePost(' . $post['id'] . ')">Validare</button>';
    }
    ?>
</div>

<script>
    function editPost(postId) {
        alert('Editare post cu ID ' + postId);
        // Implement redirection to the post editing page
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
