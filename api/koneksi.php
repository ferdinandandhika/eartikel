<?php
$host = getenv('POSTGRES_HOST') ?: 'db.qecotzvnfguaxaahnanu.supabase.co';
$port = getenv('POSTGRES_PORT') ?: '5432';
$dbname = getenv('POSTGRES_DATABASE') ?: 'postgres';
$user = getenv('POSTGRES_USER') ?: 'postgres';
$password = getenv('POSTGRES_PASSWORD') ?: 'P4EizpXzzThDXIII';

try {
    // Koneksi menggunakan mysqli
    $koneksi = new mysqli($host, $user, $password, $dbname, $port);

    // Cek koneksi
    if ($koneksi->connect_error) {
        throw new Exception("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Set karakter encoding
    $koneksi->set_charset("utf8mb4");
    
    // Set timezone jika diperlukan
    $koneksi->query("SET time_zone = '+07:00'");

} catch (Exception $e) {
    // Tampilkan pesan error
    die("Error: " . $e->getMessage());
}

// Fungsi untuk membersihkan input
function clean($string) {
    global $koneksi;
    return $koneksi->real_escape_string(trim($string));
}

// Fungsi untuk mengamankan output
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>