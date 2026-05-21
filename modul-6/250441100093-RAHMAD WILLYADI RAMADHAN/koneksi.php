<?php
session_start();

$koneksi = new mysqli("localhost", "root", "", "absensi");

if ($koneksi->connect_error) {
    die("Koneksi gagal");
}


// if (!isset($_SESSION['id_user'])) {
//     $_SESSION['id_user'] = 1;
//     $_SESSION['nama'] = "Admin";
//     $_SESSION['role'] = "admin";
// }

?>


