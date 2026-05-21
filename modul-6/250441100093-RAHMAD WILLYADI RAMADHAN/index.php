<?php
require_once 'koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: tampil_data.php");
    exit;
}

$pesan = "";    
$username = "";
$password_input = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    if ($username == "admin") {
        $ambil_admin = $koneksi->prepare("
            SELECT * FROM users
            WHERE nim='admin'
            AND role='admin'
        ");
        $ambil_admin->execute();
        $data_admin = $ambil_admin->get_result()->fetch_assoc();

        if ($data_admin) {
            if ($password_input == $data_admin['password']) {
                $_SESSION['id_user'] = $data_admin['id'];
                $_SESSION['nim']     = $data_admin['nim'];
                $_SESSION['nama']    = $data_admin['nama'];
                $_SESSION['role']    = $data_admin['role'];

                header("Location: tampil_data.php");
                exit;
            } else {
                $pesan = "Password admin salah";
            }
        } else {
            $pesan = "Admin tidak ditemukan";
        }
    } else {
        if (strlen($username) != 12 || strlen($password_input) != 12) {
            $pesan = "NIM dan Password harus 12 angka";
        } else {
            $ambil_user = $koneksi->prepare("
                SELECT * FROM users
                WHERE nim=?
                AND role='user'
            ");
            $ambil_user->bind_param("s", $username);
            $ambil_user->execute();
            $data_user = $ambil_user->get_result()->fetch_assoc();

            if ($data_user) {
                if ($password_input == $data_user['password']) {
                    $_SESSION['id_user'] = $data_user['id'];
                    $_SESSION['nim']     = $data_user['nim'];
                    $_SESSION['nama']    = $data_user['nama'];
                    $_SESSION['role']    = $data_user['role'];

                    header("Location: tampil_data.php");
                    exit;
                } else {
                    $pesan = "Password mahasiswa salah";
                }
            } else {
                $pesan = "NIM mahasiswa tidak ditemukan";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            background-color: #dde3f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 900px;
            min-height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(0, 0, 30, 0.22);
            position: relative;
            background: linear-gradient(150deg, #2979FF 0%, #1a3fbe 45%, #0d2899 100%);
        }

        .left-panel {
            position: absolute;
            top: 0;
            left: 0;
            width: 44%;
            height: 100%;
            background: #fff;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px 20px 44px 44px;
            clip-path: path('M0,0 L340,0 C340,0 305,80 318,165 C331,250 360,295 338,375 C316,455 340,500 340,500 L0,500 Z');
        }

        .logo-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 24px;
            margin-bottom: 24px;
            margin-left: 20px;
        }

        .left-welcome h2 {
            font-size: 26px;
            font-weight: 900;
            color: #1565C0;
            margin-top: 10px;
            letter-spacing: -0.3px;
            padding-left: 0px;
        }

        .left-welcome p {
            font-size: 15px;
            color: #666;
            line-height: 20px;
            padding-left: 5px;
            margin-top: 200x;
        }

        .right-panel {
            position: absolute;
            top: 0;
            right: 0;
            width: 62%;
            height: 100%;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 56px 52px 60px;
            overflow: hidden;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: -70px;
            right: -70px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -90px;
            right: 40px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .form-wrap {
            position: relative;
            z-index: 2;
        }

        .sign-in-title {
            text-align: center;
            color: #fff;
            font-size: 26px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .sign-in-sub {
            text-align: center;
            color: rgba(255,255,255,0.6);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 36px;
        }

        .field-group {
            position: relative;
            margin-bottom: 18px;
        }

        .field-group .f-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #90a4ae;
            line-height: 1;
        }

        .field-group input {
            width: 100%;
            padding: 14px 20px 14px 46px;
            border-radius: 40px;
            border: none;
            background: #fff;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: box-shadow 0.2s;
        }

        .field-group input::placeholder {
            color: #b0bec5;
        }

        .field-group input:focus {
            box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border-radius: 40px;
            border: none;
            background: linear-gradient(90deg, #2ecc71, #27ae60);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            margin-top: 6px;
            transition: opacity 0.2s, transform 0.15s;
        }

        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-2px);
        }

        .alert-custom {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.35);
            border-radius: 12px;
            color: #fff;
            padding: 10px 18px;
            font-size: 13px;
            margin-bottom: 18px;
            text-align: center;
        }

        @media (max-width: 680px) {
            .login-wrapper {
                width: 95%;
                min-height: unset;
                background: #fff;
            }

            .left-panel {
                position: static;
                width: 100%;
                height: auto;
                clip-path: none;
                padding: 32px;
            }

            .right-panel {
                position: static;
                width: 100%;
                height: auto;
                padding: 32px;
                background: linear-gradient(150deg, #2979FF 0%, #0d2899 100%);
            }

            .login-wrapper {
                display: flex;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <div class="left-panel">
        <div class="left-welcome">
            <img src="asset/logo.jpg" class="logo-img">
            <h2>SELAMAT DATANG</h2>
            <p>Masukkan NIM dan Password anda</p>
        </div>
    </div>

    <div class="right-panel">
        <div class="form-wrap">
            <div class="sign-in-title">Sign In</div>
            <div class="sign-in-sub">To Access The Portal</div>

            <?php if ($pesan != "") : ?>
                <div class="alert-custom">
                    <?= htmlspecialchars($pesan); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="field-group">
                    <span class="f-icon">&#128100;</span>
                    <input
                        type="text"
                        name="username"
                        placeholder="Masukkan Username atau NIM"
                        value="<?= htmlspecialchars($username); ?>"
                        required
                    >
                </div>

                <div class="field-group">
                    <span class="f-icon">&#128273;</span>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan Password"
                        value="<?= htmlspecialchars($password_input); ?>"
                        required
                    >
                </div>

                <button type="submit" name="login" class="btn-login">Login</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>