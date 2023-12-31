<?php
include('Database.php');
include('Post.php');

$post = new Post(Database::getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category'])) {
    $category = $_GET['category'];
    $filteredPosts = $post->getPostsByCategory($category);

    echo '<div id="filtered-posts-container">';
    while ($row = $filteredPosts->fetch_assoc()) {
        echo '<div class="post-card">';
        echo '<h3>' . $row['titlu'] . '</h3>';
        echo '<p>Autor: ' . $row['autor'] . '</p>';
        echo '<p>' . substr($row['continut'], 0, 50) . '...</p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    $allPosts = $post->getAllPosts();

    echo '<div id="filtered-posts-container">';
    while ($row = $allPosts->fetch_assoc()) {
        echo '<div class="post-card">';
        echo '<h3>' . $row['titlu'] . '</h3>';
        echo '<p>Autor: ' . $row['autor'] . '</p>';
        echo '<p>' . substr($row['continut'], 0, 50) . '...</p>';
        echo '</div>';
    }
    echo '</div>';
}
?>
