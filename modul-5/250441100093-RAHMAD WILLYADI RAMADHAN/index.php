<?php
function tampilData($data) {
    echo "<div class='card'>";
    echo "<h3>Hasil Input</h3>";
    echo "<table>";
    foreach ($data as $k => $v) {
        echo "<tr><td><strong>$k</strong></td><td>$v</td></tr>";
    }
    echo "</table></div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Developer - Rahmad Willyadi</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #eef1f5; }
        .nav { background: #007bff; color: white; padding: 15px; font-size: 18px; font-weight: bold; }
        .container { padding: 20px; max-width: 900px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        .profile { display: flex; align-items: center; gap: 20px; }
        .profile img { width: 100px; height: 100px; border-radius: 50%; border: 3px solid #007bff; object-fit: cover; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        input[type="text"], textarea, select { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        button:hover { background: #0056b3; }
        .links a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

    <div class="nav">🌐 Portfolio Developer</div>

    <div class="container">
        <div class="card profile">
            <img src="ASSET/FOTO SAYA BEGRON BIRU.jpg" alt="Foto Profil">
            <div>
                <h2>RAHMAD WILLYADI RAMADHAN</h2>
                <p>Frontend | Backend | Fullstack</p>
            </div>
        </div>

        <div class="card">
            <h3>Data Profil</h3>
            <table>
                <tr><td>ID Developer</td><td>DEV001</td></tr>
                <tr><td>Kota</td><td>Mojokerto</td></tr>
                <tr><td>Email</td><td>rahmad@gmail.com</td></tr>
                <tr><td>WhatsApp</td><td>0812345678910</td></tr>
            </table>
        </div>

        <div class="card">
            <h3>Form Input</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Framework/Tools (pisahkan dengan koma):</label>
                    <input type="text" name="framework" placeholder="Contoh: Laravel, React, Vue">
                </div>

                <div class="form-group">
                    <label>Cerita Pengalaman:</label>
                    <textarea name="pengalaman" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Tools Penunjang:</label><br>
                    <input type="checkbox" name="tools[]" value="VS Code"> VS Code
                    <input type="checkbox" name="tools[]" value="GitHub"> GitHub
                    <input type="checkbox" name="tools[]" value="Figma"> Figma
                </div>

                <div class="form-group" style="margin-top:15px;">
                    <label>Minat Bidang:</label><br>
                    <input type="radio" name="minat" value="Frontend"> Frontend
                    <input type="radio" name="minat" value="Backend"> Backend
                    <input type="radio" name="minat" value="Fullstack"> Fullstack
                </div>

                <div class="form-group" style="margin-top:15px;">
                    <label>Tingkat Skill:</label>
                    <select name="skill">
                        <option value="">--Pilih--</option>
                        <option value="Dasar">Dasar</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Profesional">Profesional</option>
                    </select>
                </div>

                <button type="submit" name="submit">Kirim Data</button>
            </form>
        </div>

        <?php
        if (isset($_POST['submit'])) {
            if (empty($_POST['framework']) || empty($_POST['pengalaman']) || empty($_POST['minat']) || empty($_POST['skill'])) {
                echo "<div class='card' style='color:red;'>❌ Semua form wajib diisi!</div>";
            } else {
                $fw_input = $_POST['framework'];
                $fw_array = explode(",", $fw_input);
                
                $data_hasil = [
                    "Daftar Framework" => implode(", ", $fw_array),
                    "Tools Penunjang"  => isset($_POST['tools']) ? implode(", ", $_POST['tools']) : "-",
                    "Minat Bidang"     => $_POST['minat'],
                    "Tingkat Skill"    => $_POST['skill']
                ];

                tampilData($data_hasil);

                $pengalaman = htmlspecialchars($_POST['pengalaman']);
                echo "<div class='card'><h3>Cerita Pengalaman</h3><p>" . nl2br($pengalaman) . "</p></div>";

                if (count($fw_array) > 2) {
                    echo "<div class='card' style='border-left: 5px solid green; color: green;'>
                            ✔ <strong>Hebat!</strong> Skill Anda cukup luas di bidang development!
                          </div>";
                }
            }
        }
        ?>

        <div class="links">
            <a href="timeline.php">📈 Timeline Belajar</a>
            <a href="blog.php">📝 Blog Reflektif</a>
        </div>
    </div>
</body>
</html>