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
        } else {
            // authentication
            $result = $user->login($username, $password);

            // check if successful
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $userRole = $user['rol']; // get the user's role

                // store user information in session
                $_SESSION['user'] = $user;

                // redirect to index.php with user role as query
                header("Location: index.php?role=$userRole");
                exit();
            } else {
                $errorMessage = 'Username si parola nu sunt valide.';
            }
        }
    } elseif (isset($_POST['register'])) {
        header("Location: register.php");
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

<button type="button" onclick="redirectToRegister()">Inregistrare</button>

<button type="button" onclick="viewAsGuest()">Vizualizare ca vizitator</button>

<p style="color: red;"><?php echo $errorMessage; ?></p>

<script>
    function redirectToRegister() {
        window.location.href = 'register.php';
    }

    function viewAsGuest() {
        window.location.href = 'index.php';
    }
</script>

</body>
</html>
