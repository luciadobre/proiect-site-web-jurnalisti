<?php
session_start();
include('connection.php');
include('User.php');

$user = new User(Database::getConnection());

$username = '';
$password = '';
$name = '';
$role = '';
$errorMessage = '';

$validRoles = ['editor', 'cititor', 'jurnalist'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // validation
    if (empty($username) || empty($password) || empty($name) || empty($role)) {
        $errorMessage = 'Introduceti toate campurile.';
    } elseif (!in_array($role, $validRoles)) {
        $errorMessage = 'Rolul poate fi doar editor, cititor sau jurnalist.';
    } else {
        $userExists = $user->checkUsernameExists($username);

        if ($userExists) {
            $errorMessage = 'Username-ul exista deja. Va rugam alegeti alt username.';
        } else {

            $user->createUser($username, $password, $name, $role);

            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style_register.css">
    <title>Inregistrare</title>
</head>
<body>

<h1>Inregistrare</h1>

<form method="post" action="register.php" id="registerForm">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
    <br>

    <label for="password">Parola:</label>
    <input type="password" id="password" name="password" required>
    <br>

    <label for="name">Nume:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
    <br>

    <label for="role">Rol:</label>
    <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($role); ?>" required>
    <br>

    <button type="submit" name="register">Inregistrare</button>
</form>

<p style="color: red;"><?php echo $errorMessage; ?></p>

<p>Deja ai cont? <a href="login.php">Login aici</a>.</p>

</body>
</html>
