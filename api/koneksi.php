<?php
$host = getenv('POSTGRES_HOST');
$port = getenv('POSTGRES_PORT');
$dbname = getenv('POSTGRES_DATABASE');
$user = getenv('POSTGRES_USER');
$password = getenv('POSTGRES_PASSWORD');

try {
    $koneksi = new mysqli($host, $user, $password, $dbname, $port);
    
    if ($koneksi->connect_error) {
        throw new Exception("Koneksi gagal: " . $koneksi->connect_error);
    }
    
    $koneksi->set_charset("utf8mb4");
    $koneksi->query("SET time_zone = '+07:00'");
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

function clean($string) {
    global $koneksi;
    return $koneksi->real_escape_string(trim($string));
}

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>