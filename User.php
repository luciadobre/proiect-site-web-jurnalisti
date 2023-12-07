<?php
class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($username, $password) {
        $errorMessage = '';

        // validation
        if (empty($username) || empty($password)) {
            $errorMessage = 'Introduceti username si parola.';
        } else {
            // authentication
            $sql = "SELECT * FROM utilizatori WHERE user = '$username' AND parola = '$password'";
            $result = $this->conn->query($sql);

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

        return $errorMessage;
    }
}
?>