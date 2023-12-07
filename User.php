<?php
class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($username, $password) {
        $errorMessage = $this->validateLogin($username, $password);

        if (empty($errorMessage)) {
            $user = $this->authenticateUser($username, $password);
            if ($user) {
                $userRole = $user['rol'];
                $_SESSION['user'] = $user;
                header("Location: index.php?role=$userRole");
                exit();
            } else {
                $errorMessage = 'Username si parola nu sunt valide.';
            }
        }

        return $errorMessage;
    }

    private function validateLogin($username, $password) {
        if (empty($username) || empty($password)) {
            return 'Introduceti username si parola.';
        }

        return '';
    }

    private function authenticateUser($username, $password) {
        $sql = "SELECT * FROM utilizatori WHERE user = '$username' AND parola = '$password'";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function createUser($username, $password, $name, $role) {
        $sql = "INSERT INTO utilizatori (user, parola, nume, rol) VALUES ('$username', '$password', '$name', '$role')";
        return $this->conn->query($sql);
    }

    public function checkUsernameExists($username) {
        $sql = "SELECT * FROM utilizatori WHERE user = '$username'";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }
}
?>
