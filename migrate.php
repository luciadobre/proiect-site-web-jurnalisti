<?php
$servername = "localhost";
$port = "8081";
$username = "root";
$password = "root";
$database = "articole";

$conn = new mysqli($servername, $username, $password);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// create db
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Baza de date a fost creata\n";
} else {
    echo "Eroare baza de date: " . $conn->error . "\n";
}

$conn->close();

$conn = new mysqli($servername, $username, $password, $database);

// verificare conexiune
if ($conn->connect_error) {
    die("Conexiune esuata: " . $conn->connect_error);
}

// crearea bazei de date cu tabel
$sql = "
    CREATE TABLE IF NOT EXISTS articole (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titlu VARCHAR(255) NOT NULL,
        autor VARCHAR(255) NOT NULL,
        continut TEXT NOT NULL,
        categorie VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    INSERT INTO articole (title, author, content, category) VALUES
    ('articol 1', 'autor 1', 'continut 1', 'artistic'),
    ('articol 2', 'autor 2', 'continut 2', 'tehnic'),
    ('articol 3', 'autor 3', 'continut 3', 'stiinta'),
    ('articol 4', 'autor 4', 'continut 4', 'moda');
";

if ($conn->multi_query($sql) === TRUE) {
    echo "tabele si date create cu succes\n";
} else {
    echo "eroare la crearea tabelelor si datelor: " . $conn->error . "\n";
}

$conn->close();
?>
