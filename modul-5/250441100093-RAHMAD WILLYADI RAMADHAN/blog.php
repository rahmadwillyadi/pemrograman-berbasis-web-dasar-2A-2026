<?php
$artikel = [
    "html" => [
        "judul" => "Belajar HTML Pertama Kali",
        "tanggal" => "1 Januari 2024",
        "isi" => "Saya mulai belajar HTML dasar seperti tag dan struktur.",
        "link" => "https://www.w3schools.com/html/"
    ],
    "error" => [
        "judul" => "Error Pertama",
        "tanggal" => "5 Januari 2024",
        "isi" => "Saya belajar cara debugging dari error pertama saya.",
        "link" => "https://stackoverflow.com"
    ]
];

$quotes = ["Jangan menyerah!", "Error terus.", "Terus konsisten."];
$quote  = $quotes[array_rand($quotes)];

$key = $_GET['post'] ?? null;
$post = $artikel[$key] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Dev</title>
    <style>
        body{ font-family: sans-serif; background: #eef1f5; margin: 0; }
        .nav{ background: #007bff; color: white; padding: 15px; }
        .container{ display: flex; gap: 20px; padding: 20px; max-width: 900px; margin: auto; }
        .sidebar{ width: 35%; }
        .content{ width: 65%; }
        .card{ background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
        img{ max-width: 100%; border-radius: 5px; }
        a{ text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="nav">📝 Blog Sederhana</div>

<div class="container">
    <div class="sidebar">
        <div class="card">
            <h3>Daftar Artikel</h3>
            <?php foreach($artikel as $k => $v): ?>
                <a href="?post=<?= $k ?>"><?= $v['judul'] ?></a><br><br>
            <?php endforeach; ?>
        </div>
        <div class="card">
            <i>"<?= $quote ?>"</i>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <?php if($post): ?>
                <h2><?= $post['judul'] ?></h2>
                <small><?= $post['tanggal'] ?></small>
                <p><?= $post['isi'] ?></p>
                <p><a href="<?= $post['link'] ?>" target="_blank">🔗 Referensi</a></p>
            <?php else: ?>
                <p>Silakan pilih artikel...</p>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <a href="index.php">Profil</a> | <a href="timeline.php">Timeline</a>
        </div>
    </div>
</div>

</body>
</html>