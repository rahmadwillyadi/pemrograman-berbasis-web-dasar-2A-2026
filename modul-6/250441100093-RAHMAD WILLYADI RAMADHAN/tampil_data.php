<?php
require_once 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
} 

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$tanggal_hari_ini = date('Y-m-d');

$cek_status = $koneksi->prepare("
    SELECT * FROM status_absensi
    WHERE tanggal = ?
");
$cek_status->bind_param("s", $tanggal_hari_ini);
$cek_status->execute();
$data_status = $cek_status->get_result()->fetch_assoc();

if ($_SESSION['role'] == 'admin') {
    $ambil_data = $koneksi->query("
        SELECT
            users.id,
            users.nim,
            users.nama AS nama_mahasiswa,
            absensi.id AS id_absensi,
            absensi.tanggal,
            absensi.jam_absen,
            absensi.keterangan AS status_kehadiran
        FROM users
        LEFT JOIN absensi ON users.id = absensi.user_id AND absensi.tanggal = CURDATE()
        WHERE users.role = 'user'
        ORDER BY users.nama ASC
    ");
} else {
    $id_user = $_SESSION['id_user'];
    $ambil_data = $koneksi->prepare("
        SELECT * FROM absensi
        WHERE user_id=?
        ORDER BY id DESC
    ");
    $ambil_data->bind_param("i", $id_user);
    $ambil_data->execute();
    $ambil_data = $ambil_data->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
            height: 100vh;
            position: relative;
            background: #eef2ff;
        }

        .bg-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .main-content {
            padding: 14px;
            height: 100vh;
        }

        .topbar {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 18px;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .logo-title {
            font-size: 24px;
            font-weight: 900;
            color: #1f2937;
        }

        .logo-title span {
            color: #4f46e5;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #dc2626;
            color: white;
        }

        .hero-box {
            background: linear-gradient(135deg, rgba(109, 74, 255, 0.92), rgba(50, 157, 255, 0.92));
            height: 220px;
            border-radius: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 14px;
        }

        .hero-label {
            background: rgba(255, 255, 255, 0.12);
            padding: 8px 22px;
            border-radius: 50px;
            color: white;
            font-size: 15px;
            margin-bottom: 16px;
        }

        .hero-time {
            font-size: 64px;
            font-weight: 900;
            color: white;
            line-height: 1;
        }

        .hero-date {
            color: white;
            font-size: 16px;
            margin-top: 16px;
        }

        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 14px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 22px;
            padding: 20px;
            text-align: center;
            height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-title {
            font-size: 15px;
            color: #4b5563;
            margin-bottom: 14px;
            font-weight: 700;
        }

        .info-value {
            font-size: 28px;
            font-weight: 900;
            color: #111827;
            line-height: 1.2;
        }

        .status-open {
            color: #22c55e;
        }

        .status-close {
            color: #ef4444;
        }

        .btn-absen {
            width: 100%;
            height: 160px;
            border: none;
            border-radius: 22px;
            background: linear-gradient(135deg, #6d4aff, #329dff);
            color: white;
            font-size: 26px;
            font-weight: 900;
        }

        .btn-disabled {
            background: #cbd5e1 !important;
            cursor: not-allowed;
        }

        .card-box {
            background: rgba(255, 255, 255, 0.94);
            padding: 20px;
            border-radius: 18px;
        }

        .table thead {
            background: #2563eb;
            color: white;
        }

        .table {
            margin: 0;
        }

        .table td, .table th {
            padding: 10px;
            font-size: 14px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<img src="asset/2.jpg" class="bg-img">

<div class="main-content">
    <div class="topbar">
        <div class="logo-title">ABSENSI <span>MAHASISWA</span></div>
        <a href="tampil_data.php?logout=1" class="logout-btn">Logout</a>
    </div>

    <?php if ($_SESSION['role'] == 'admin') : ?>
        <?php if (!$data_status || $data_status['status'] == 'tutup') : ?>
            <form action="proses.php" method="POST">
                <button type="submit" name="buka_absensi" class="btn btn-success mb-3">
                    Buka Absensi Hari Ini
                </button>
            </form>
        <?php else : ?>
            <form action="proses.php" method="POST">
                <button type="submit" name="tutup_absensi" class="btn btn-danger mb-3">
                    Akhiri Absensi Hari Ini
                </button>
            </form>
        <?php endif; ?>

        <div class="card-box">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    while ($data = $ambil_data->fetch_assoc()) :
                    ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= htmlspecialchars($data['nim']); ?></td>
                            <td><?= htmlspecialchars($data['nama_mahasiswa']); ?></td>
                            <td>
                                <?php
                                if ($data['tanggal']) {
                                    echo htmlspecialchars($data['tanggal']);
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($data['jam_absen']) {
                                    echo htmlspecialchars($data['jam_absen']);
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($data['tanggal'] == NULL) {
                                    echo 'Belum Absen';
                                } else {
                                    if ($data['status_kehadiran'] == NULL) {
                                        echo 'Hadir';
                                    } else {
                                        echo htmlspecialchars($data['status_kehadiran']);
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($data['tanggal'] != NULL) : ?>
                                    <a href="update.php?id=<?= $data['id_absensi']; ?>" class="btn btn-warning btn-sm">Update</a>
                                    <a href="hapus.php?id=<?= $data['id_absensi']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                <?php else : ?>
                                    <span class="text-muted">Belum Ada Data</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    <?php else : ?>

        <div class="hero-box">
            <div class="hero-label">Waktu Absensi</div>
            <div class="hero-time"><?= date('H:i:s'); ?></div>
            <div class="hero-date"><?= date('d F Y'); ?></div>
        </div>

        <div class="bottom-grid">
            <div class="info-card">
                <div class="info-title">Status Kehadiran</div>
                <div class="info-value">
                    <?php
                    $id_user = $_SESSION['id_user'];
                    $cek_sudah_absen = $koneksi->prepare("
                        SELECT * FROM absensi
                        WHERE user_id = ? AND tanggal = ?
                    ");
                    $cek_sudah_absen->bind_param("is", $id_user, $tanggal_hari_ini);
                    $cek_sudah_absen->execute();
                    $hasil_sudah_absen = $cek_sudah_absen->get_result();

                    if ($hasil_sudah_absen->num_rows > 0) {
                        echo '<span class="status-open">Sudah Absen</span>';
                    } else {
                        echo '<span class="status-close">Belum Absen</span>';
                    }
                    ?>
                </div>
            </div>

            <div class="info-card">
                <div class="info-title">Status Absensi</div>
                <div class="info-value">
                    <?php
                    if ($data_status && $data_status['status'] == 'buka') {
                        echo '<span class="status-open">Dibuka</span>';
                    } else {
                        echo '<span class="status-close">Ditutup</span>';
                    }
                    ?>
                </div>
            </div>

            <div>
                <?php
                $id_user = $_SESSION['id_user'];
                $cek_sudah_absen = $koneksi->prepare("
                    SELECT * FROM absensi
                    WHERE user_id = ? AND tanggal = ?
                ");
                $cek_sudah_absen->bind_param("is", $id_user, $tanggal_hari_ini);
                $cek_sudah_absen->execute();
                $hasil_sudah_absen = $cek_sudah_absen->get_result();

                if ($data_status && $data_status['status'] == 'buka') :
                    if ($hasil_sudah_absen->num_rows > 0) :
                ?>
                        <button class="btn-absen btn-disabled" disabled>SUDAH ABSEN</button>
                    <?php else : ?>
                        <form action="proses.php" method="POST">
                            <button type="submit" name="submit" class="btn-absen">ABSEN</button>
                        </form>
                    <?php endif; ?>
                <?php else : ?>
                    <button class="btn-absen btn-disabled" disabled>TUTUP</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>