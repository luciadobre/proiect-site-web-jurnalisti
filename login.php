<?php
session_start();
include('connection.php');
include('User.php');

$user = new User(Database::getConnection());

$username = '';
$password = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $errorMessage = $user->login($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<form method="post" action="login.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
    <br>

    <label for="password">Parola:</label>
    <input type="password" id="password" name="password" required>
    <br>

    <button type="submit">Login</button>
</form>

<p style="color: red;"><?php echo $errorMessage; ?></p>

</body>
</html>
