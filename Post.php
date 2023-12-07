<?php
class Post {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllPosts() {
        $sql = "SELECT * FROM articole";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function getPostById($postId) {
        $sql = "SELECT * FROM articole WHERE id = $postId";
        $result = $this->conn->query($sql);

        return $result->fetch_assoc();
    }
}
?>