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
    DROP TABLE IF EXISTS utilizatori;
    DROP TABLE IF EXISTS articole;
    
    CREATE TABLE utilizatori (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nume VARCHAR(255) NOT NULL,
        user VARCHAR(255) NOT NULL,
        parola VARCHAR(255) NOT NULL,
        rol VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    
    CREATE TABLE articole (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titlu VARCHAR(255) NOT NULL,
        autor VARCHAR(255) NOT NULL,
        continut TEXT NOT NULL,
        categorie VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    
    INSERT INTO utilizatori (nume, user, parola, rol) VALUES
    ('Jurnalist 1', 'jurnalist1', 'password1', 'jurnalist'),
    ('Editor 1', 'editor1', 'password1', 'editor'),
    ('Cititor 1', 'cititor1', 'password1', 'cititor');
    
    INSERT INTO articole (titlu, autor, continut, categorie) VALUES
    ('Articol 1', 'Jurnalist 1', 'Continut articol 1', 'artistic'),
    ('Articol 2', 'Jurnalist 1', 'Continut articol 2', 'tehnic'),
    ('Articol 3', 'Jurnalist 1', 'Continut articol 3', 'stiinta');
";

if ($conn->multi_query($sql) === TRUE) {
    echo "tabele si date create cu succes\n";
} else {
    echo "eroare la crearea tabelelor si datelor: " . $conn->error . "\n";
}

$conn->close();
?>
