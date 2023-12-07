<?php
session_start();
include('connection.php');

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userRole = isset($_GET['role']) ? $_GET['role'] : '';

$sql = "SELECT * FROM articole";
$result = $GLOBALS['conn']->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard utilizator</title>
    <style>
        .post-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Bine ai venit, <?php echo isset($user['nume']) ? $user['nume'] : 'Guest'; ?>!</h1>

<?php if ($userRole === 'jurnalist' || $userRole === 'editor'): ?>
    <button onclick="createArticle()">Creare articol</button>
<?php endif; ?>

<?php while ($row = $result->fetch_assoc()): ?>
    <div class="post-card" onclick="viewPost(<?php echo $row['id']; ?>)">
        <h3><?php echo $row['titlu']; ?></h3>
        <p>Autor: <?php echo $row['autor']; ?></p>
        <p><?php echo substr($row['continut'], 0, 50) . '...'; ?></p>
    </div>
<?php endwhile; ?>

<script>
    function createArticle() {
        window.location.href = 'create_post.php';
    }
    function viewPost(postId) {
        window.location.href = 'view_post.php?id=' + postId;
    }
</script>

</body>
</html>
