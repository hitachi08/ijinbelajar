<?php
$host     = 'localhost';
$dbname   = 'db_izinbelajar';
$username = 'root';
$password = '';

$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
);

try {
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Koneksi database gagal.');
}
