<?php
session_start();
include('connection.php');
include('Post.php');

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userRole = isset($_GET['role']) ? $_GET['role'] : '';

$post = new Post(Database::getConnection());
$categories = $post->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Dashboard utilizator</title>
</head>
<body>

<h1>Bine ai venit, <?php echo isset($user['nume']) ? $user['nume'] : 'Vizitator'; ?>!</h1>

<div class="button-container">
    <?php if ($userRole === 'jurnalist' || $userRole === 'editor'): ?>
        <button onclick="createArticle()">Creare articol</button>
    <?php endif; ?>

    <?php foreach ($categories as $category): ?>
        <button onclick="filterByCategory('<?php echo $category; ?>')"><?php echo $category; ?></button>
    <?php endforeach; ?>

    <button onclick="resetFilters()">Resetare filtre</button>
</div>

<div id="posts-container">
    <?php $allPosts = $post->getAllPosts(); ?>
    <?php while ($row = $allPosts->fetch_assoc()): ?>
        <?php
        $isValidat = $row['validat'];
        $userIsCititor = $userRole === 'cititor' || !$userRole;
        $statusText = $isValidat ? 'Validat' : 'Nevalidat';
        $postCardClasses = 'post-card ' . ($isValidat ? 'validat' : 'nevalidat') . ($userIsCititor && !$isValidat ? ' hidden-nevalidat' : '');
        ?>
        <div class="<?php echo $postCardClasses; ?>" data-category="<?php echo $row['categorie']; ?>" onclick="viewPost(<?php echo $row['id']; ?>)">
            <h3><?php echo $row['titlu']; ?></h3>
            <p>Autor: <?php echo $row['autor']; ?></p>
            <p><?php echo substr($row['continut'], 0, 50) . '...'; ?></p>
            <?php if ($userRole === 'jurnalist' || $userRole === 'editor'): ?>
                <p>Status validare: <?php echo $statusText; ?></p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>


<script>
    function createArticle() {
        window.location.href = 'create_post.php';
    }

    function viewPost(postId) {
        window.location.href = 'view_post.php?id=' + postId;
    }

    function filterByCategory(category) {
        const posts = document.getElementsByClassName('post-card');
        for (const post of posts) {
            const isValidat = post.classList.contains('validat');
            const isVisible = (isValidat || category === '') && post.getAttribute('data-category') === category;

            post.style.display = isVisible ? 'block' : 'none';
        }
    }

    function resetFilters() {
        const posts = document.getElementsByClassName('post-card');
        for (const post of posts) {
            post.style.display = 'block';
        }
    }
</script>


</body>
</html>
