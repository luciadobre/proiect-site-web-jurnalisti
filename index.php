<?php
session_start();
include('connection.php');

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Verifica daca formularul de filtrare a fost trimis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter_category'])) {
    $selectedCategory = $_POST['filter_category'];
    // Afisare articole in functie de categoria aleasa
    $sql = "SELECT * FROM articole WHERE categorie = '$selectedCategory'";
} else {
    // Afisare articole by default
    $sql = "SELECT * FROM articole";
}
$result = $GLOBALS['conn']->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        .post-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            cursor: pointer;
        }
        .login-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #000;
            font-size: 25px;
        }
    </style>
</head>
<body>

<?php if ($user && isset($_GET['role'])): ?>
    <?php $userRole = $_GET['role']; ?>
    <h1>Bine ai venit, <?php echo isset($user['nume']) ? $user['nume'] : 'Guest'; ?>!</h1>

    <!-- Fomular filtrare -->
    <form method="post" action="">
        <label for="filter_category">Filtrează după categorie:</label>
        <select id="filter_category" name="filter_category">
            <option value="artistic">Artistic</option>
            <option value="tehnic">Tehnic</option>
            <option value="stiinta">Științific</option>
            <option value="moda">Modă</option>
        </select>
        <button type="submit">Filtrează</button>
    </form>
<!-- Creare buton jurnalist -->
<?php if ($userRole === 'jurnalist'): ?>
        <button onclick="createArticle()">Creare articol</button>
    <?php endif; ?>
    <!-- Afisare articole -->
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="post-card" onclick="viewPost(<?php echo $row['id']; ?>)">
            <h3><?php echo $row['titlu']; ?></h3>
            <p>Author: <?php echo $row['autor']; ?></p>
            <p>Creation Date: <?php echo $row['created_at']; ?></p>
            <p><?php echo substr($row['continut'], 0, 200) . '...'; ?></p>
        </div>
    <?php endwhile; ?>

    

    <script>
        function viewPost(postId) {
            window.location.href = '<?php echo $user ? "view_post.php?id=" : "login.php"; ?>' + postId;
        }
        function createArticle() {
            window.location.href = 'create_post.php';
        }
    </script>

<?php else: ?>
    <!-- Guest view -->
    <h1>Bine ai venit, Guest!</h1>
    <a href="login.php" class="login-button"><b>Login</b></a>

    <!-- Formular filtrare -->
    <form method="post" action="">
        <label for="filter_category">Filtrează după categorie:</label>
        <select id="filter_category" name="filter_category">
            <option value="artistic">Artistic</option>
            <option value="tehnic">Tehnic</option>
            <option value="stiinta">Științific</option>
            <option value="moda">Modă</option>
        </select>
        <button type="submit">Filtrează</button>
    </form>

    <!-- Afisare articole pentru guest -->
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="post-card" onclick="viewPost(<?php echo $row['id']; ?>)">
            <h3><?php echo $row['titlu']; ?></h3>
            <p>Author: <?php echo $row['autor']; ?></p>
            <p>Creation Date: <?php echo $row['created_at']; ?></p>
            <p><?php echo substr($row['continut'], 0, 200) . '...'; ?></p>
        </div>
    <?php endwhile; ?>

    <script>
        function viewPost(postId) {
            alert('For reading the article please log in!');
            // Guest redirect to login.php 
            window.location.href = 'login.php';
        }
    </script>

<?php endif; ?>

</body>
</html>
