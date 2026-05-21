<?php

require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak");
}

$id = $_GET['id'];

$hapus_data = $koneksi->prepare("DELETE FROM absensi WHERE id = ?");
$hapus_data->bind_param("i", $id);
$hapus_data->execute();

header("Location: tampil_data.php");
exit;