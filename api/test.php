<?php
include 'koneksi.php';

if ($koneksi->ping()) {
    echo "Koneksi database berhasil!";
    
    // Test query
    $result = $koneksi->query("SELECT NOW() as waktu");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<br>Waktu server: " . $row['waktu'];
    }
} else {
    echo "Koneksi database gagal!";
}
?>
