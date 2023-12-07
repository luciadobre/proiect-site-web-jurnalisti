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

    public function getAllCategories() {
        $sql = "SELECT DISTINCT categorie FROM articole";
        $result = $this->conn->query($sql);

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['categorie'];
        }

        return $categories;
    }

    public function getPostsByCategory($category) {
        $sql = "SELECT * FROM articole WHERE categorie = '$category' AND validat = 1";
        $result = $this->conn->query($sql);

        return $result;
    }
}
?>
