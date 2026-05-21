<?php
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $keterangan = $_POST['keterangan'];

    $update_status = $koneksi->prepare("
        UPDATE absensi
        SET keterangan = ?
        WHERE id = ?
    ");
    $update_status->bind_param("si", $keterangan, $id);
    $update_status->execute();

    header("Location: tampil_data.php");
    exit;
}

$id = $_GET['id'];

$ambil_absensi = $koneksi->prepare("
    SELECT * FROM absensi
    WHERE id = ?
");
$ambil_absensi->bind_param("i", $id);
$ambil_absensi->execute();

$data_absensi = $ambil_absensi->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Status Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #eef2ff;
            font-family: sans-serif;
        }

        .main-box {
            width: 500px;
            margin: auto;
            margin-top: 50px;
        }

        .card-box {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: white;
        }

        .top-header {
            background: linear-gradient(135deg, #4f46e5, #2563eb);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .top-header h2 {
            margin: 0;
            font-weight: bold;
        }

        .card-body {
            padding: 30px;
        }

        .nama-box {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .radio-item {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 12px;
            transition: 0.2s;
        }

        .radio-item:hover {
            border-color: #2563eb;
            background: #f8fbff;
        }

        .btn-simpan {
            width: 100%;
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: bold;
        }

        .btn-kembali {
            width: 100%;
            display: block;
            text-align: center;
            margin-top: 12px;
            text-decoration: none;
            background: #64748b;
            color: white;
            padding: 12px;
            border-radius: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="main-box">
    <div class="card card-box">
        <div class="top-header">
            <h2>Update Status Absensi</h2>
        </div>

        <div class="card-body">
            <div class="nama-box">
                <b>Nama Mahasiswa :</b>
                <br><br>
                <?= $data_absensi['nama_mahasiswa']; ?>
            </div>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $data_absensi['id']; ?>">

                <div class="radio-item">
                    <input 
                        type="radio" 
                        name="keterangan" 
                        value="Izin" 
                        <?= $data_absensi['keterangan'] == 'Izin' ? 'checked' : ''; ?> 
                        required
                    >
                    Izin
                </div>

                <div class="radio-item">
                    <input 
                        type="radio" 
                        name="keterangan" 
                        value="Sakit" 
                        <?= $data_absensi['keterangan'] == 'Sakit' ? 'checked' : ''; ?>
                    >
                    Sakit
                </div>

                <div class="radio-item">
                    <input 
                        type="radio" 
                        name="keterangan" 
                        value="Alpha" 
                        <?= $data_absensi['keterangan'] == 'Alpha' ? 'checked' : ''; ?>>
                    Alpha
                </div>

                <button type="submit" name="update" class="btn-simpan">Simpan Status</button>
                <a href="tampil_data.php" class="btn-kembali">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>