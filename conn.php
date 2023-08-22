<?php 

$host = "localhost"; // Ganti dengan nama host MySQL Anda
$username = "mysql"; // Ganti dengan nama pengguna MySQL Anda
$password = "root"; // Ganti dengan kata sandi MySQL Anda
$database = "vsga"; // Ganti dengan nama database yang Anda gunakan

$koneksi = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo "Koneksi gagal: " . mysqli_connect_error();
}
