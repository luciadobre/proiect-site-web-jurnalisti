<?php
session_start();
include('connection.php');
include('User.php');

$user = new User(Database::getConnection());

$username = '';
$password = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // validation
        if (empty($username) || empty($password)) {
            $errorMessage = 'Introduceti username si parola.';
            // early return if validation fails
            return;
        }

        // authentication
        $result = $user->login($username, $password);

        // check if successful
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userRole = $user['rol']; // get the user's role

            // store user information in session
            $_SESSION['user'] = $user;

            // redirect based on user role
            $redirectPage = in_array($userRole, ['editor', 'jurnalist', 'cititor']) ? "index.php?role=$userRole" : "login.php";
            echo "<script>window.location.href = '$redirectPage';</script>";
            exit();
        } else {
            $errorMessage = 'Username si parola nu sunt valide.';
        }
    } elseif (isset($_POST['register'])) {
        echo "<script>window.location.href = 'register.php';</script>";
        exit();
    }
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

<form method="post" action="login.php" id="loginForm">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
    <br>

    <label for="password">Parola:</label>
    <input type="password" id="password" name="password" required>
    <br>

    <button type="submit" name="login">Login</button>
</form>

<button type="button" onclick="window.location.href = 'register.php'">Inregistrare</button>

<button type="button" onclick="window.location.href = 'index.php'">Vizualizare ca vizitator</button>

<p style="color: red;"><?php echo $errorMessage; ?></p>

</body>
</html>
