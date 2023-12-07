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

<h1>Bine ai venit, <?php echo isset($user['nume']) ? $user['nume'] : 'Vizitator'; ?>!</h1>

<?php if ($userRole === 'jurnalist' || $userRole === 'editor'): ?>
    <button onclick="createArticle()">Creare articol</button>
<?php endif; ?>

<?php foreach ($categories as $category): ?>
    <button onclick="filterByCategory('<?php echo $category; ?>')"><?php echo $category; ?></button>
<?php endforeach; ?>

<button onclick="resetFilters()">Resetare filtre</button>

<div id="posts-container">
    <?php $allPosts = $post->getAllPosts(); ?>
    <?php while ($row = $allPosts->fetch_assoc()): ?>
        <?php if ($row['validat'] == 1 || $userRole === 'jurnalist' || $userRole === 'editor'): ?>
            <div class="post-card" onclick="viewPost(<?php echo $row['id']; ?>)">
                <h3><?php echo $row['titlu']; ?></h3>
                <p>Autor: <?php echo $row['autor']; ?></p>
                <p><?php echo substr($row['continut'], 0, 50) . '...'; ?></p>
            </div>
        <?php endif; ?>
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
        fetch('filter_posts.php?category=' + encodeURIComponent(category))
            .then(response => response.text())
            .then(data => {
                const postsContainer = document.getElementById('posts-container');
                if (data.trim() === '') {
                    postsContainer.innerHTML = '<p>Nu am gasit articole in aceasta categorie</p>';
                } else {
                    postsContainer.innerHTML = data;
                }
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
                const postsContainer = document.getElementById('posts-container');
                postsContainer.innerHTML = '<p>Nu am gasit articole</p>';
            });
    }

    function resetFilters() {
        fetch('filter_posts.php')
            .then(response => response.text())
            .then(data => {
                const postsContainer = document.getElementById('posts-container');
                postsContainer.innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
                const postsContainer = document.getElementById('posts-container');
                postsContainer.innerHTML = '<p>Nu am gasit articole</p>';
            });
    }
</script>

</body>
</html>
