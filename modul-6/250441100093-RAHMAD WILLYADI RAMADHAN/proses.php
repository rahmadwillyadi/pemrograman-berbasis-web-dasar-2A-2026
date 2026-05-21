<?php
require_once 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

$tanggal_hari_ini = date('Y-m-d');

if (isset($_POST['buka_absensi'])) {
    $cek_status = $koneksi->prepare("
        SELECT * FROM status_absensi
        WHERE tanggal = ?
    ");
    $cek_status->bind_param("s", $tanggal_hari_ini);
    $cek_status->execute();
    $hasil_status = $cek_status->get_result();

    if ($hasil_status->num_rows == 0) {
        $status = "buka";
        $simpan_status = $koneksi->prepare("
            INSERT INTO status_absensi (tanggal, status) 
            VALUES (?, ?)
        ");
        $simpan_status->bind_param("ss", $tanggal_hari_ini, $status);
        $simpan_status->execute();
    } else {
        $status = "buka";
        $update_status = $koneksi->prepare("
            UPDATE status_absensi
            SET status = ?
            WHERE tanggal = ?
        ");
        $update_status->bind_param("ss", $status, $tanggal_hari_ini);
        $update_status->execute();
    }

    header("Location: tampil_data.php");
    exit;
}

if (isset($_POST['tutup_absensi'])) {
    $status = "tutup";
    $update_status = $koneksi->prepare("
        UPDATE status_absensi
        SET status = ?
        WHERE tanggal = ?
    ");
    $update_status->bind_param("ss", $status, $tanggal_hari_ini);
    $update_status->execute();

    header("Location: tampil_data.php");
    exit;
}

if (isset($_POST['submit'])) {
    $cek_absensi_dibuka = $koneksi->prepare("
        SELECT * FROM status_absensi
        WHERE tanggal = ? AND status = 'buka'
    ");
    $cek_absensi_dibuka->bind_param("s", $tanggal_hari_ini);
    $cek_absensi_dibuka->execute();
    $hasil_buka = $cek_absensi_dibuka->get_result();

    if ($hasil_buka->num_rows == 0) {
        header("Location: tampil_data.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    $nama_mahasiswa = $_SESSION['nama'];
    $jam_absen = date('H:i:s');
    $keterangan = "Hadir";

    $cek_absensi = $koneksi->prepare("
        SELECT * FROM absensi
        WHERE user_id = ? AND tanggal = ?
    ");
    $cek_absensi->bind_param("is", $id_user, $tanggal_hari_ini);
    $cek_absensi->execute();
    $hasil_absensi = $cek_absensi->get_result();

    if ($hasil_absensi->num_rows > 0) {
        header("Location: tampil_data.php");
        exit;
    }

    $simpan_absensi = $koneksi->prepare("
        INSERT INTO absensi (user_id, nama_mahasiswa, tanggal, jam_absen, keterangan) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $simpan_absensi->bind_param("issss", $id_user, $nama_mahasiswa, $tanggal_hari_ini, $jam_absen, $keterangan);
    $simpan_absensi->execute();

    header("Location: tampil_data.php");
    exit;
}
?>