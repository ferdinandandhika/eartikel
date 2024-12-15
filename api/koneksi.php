<?php
$host = getenv('POSTGRES_HOST') ?: 'aws-0-ap-southeast-1.pooler.supabase.com';
$user = getenv('POSTGRES_USER') ?: 'postgres.qecotzvnfguaxaahnanu';
$pass = getenv('POSTGRES_PASSWORD') ?: 'P4EizpXzzThDXIII';
$db   = getenv('POSTGRES_DATABASE') ?: 'postgres';
$port = getenv('POSTGRES_PORT') ?: '6543';

try {
    $connection_string = "host=$host port=$port dbname=$db user=$user password=$pass sslmode=require";
    $koneksi = pg_connect($connection_string);
    
    if (!$koneksi) {
        throw new Exception("Koneksi database gagal: " . pg_last_error());
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

