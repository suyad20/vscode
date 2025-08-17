<?php
$hostname = "localhost";  
$username = "root";
$password = "";           
$database = "absensidigital";

// Membuat koneksi
$koneksi = mysqli_connect($hostname, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Definisikan BASE_URL (ubah sesuai folder project)
define("BASE_URL", "http://localhost/Absensi_Digital_main/");
?>
