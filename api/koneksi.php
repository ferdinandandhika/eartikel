<?php
$host = getenv('POSTGRES_HOST');
$port = getenv('POSTGRES_PORT');
$dbname = getenv('POSTGRES_DATABASE');
$user = getenv('POSTGRES_USER');
$password = getenv('POSTGRES_PASSWORD');

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    $koneksi = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

