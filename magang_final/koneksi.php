<?php

// Koneksi MySQLi
$koneksi = mysqli_connect("localhost", "root", "", "project_undian_fix");

// Koneksi PDO
$host = "localhost";       // Host database
$database = "project_undian_fix"; // Nama database
$username = "root";        // Username database
$password = "";            // Password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>