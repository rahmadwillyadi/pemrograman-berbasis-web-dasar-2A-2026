<?php
$data=[
["tahun"=>"2021","kegiatan"=>"Masuk Kuliah"],
["tahun"=>"2022","kegiatan"=>"Belajar HTML"],
["tahun"=>"2023","kegiatan"=>"Belajar CSS"],
["tahun"=>"2024","kegiatan"=>"Belajar Framework"],
["tahun"=>"2025","kegiatan"=>"Belajar Javascript"]
];

function highlight($tahun){
    return $tahun=="2024"?"highlight":"";
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{font-family:sans-serif;background:#eef1f5;margin:0;}
.nav{background:#007bff;color:white;padding:15px;}
.container{padding:20px;max-width:800px;margin:auto;}
.timeline{border-left:3px solid #007bff;padding-left:20px;}
.item{background:white;padding:10px;border-radius:8px;margin-bottom:10px;}
.highlight{background:#ffeaea;color:red;font-weight:bold;}
a{text-decoration:none;color:#007bff;margin-right:10px;}
</style>
</head>

<body>

<div class="nav">📈 Timeline Belajar</div>

<div class="container">
<div class="timeline">
<?php foreach($data as $d): ?>
<div class="item <?= highlight($d['tahun']) ?>">
<b><?= $d['tahun'] ?></b> - <?= $d['kegiatan'] ?>
</div>
<?php endforeach; ?>
</div>

<br>
<a href="index.php">Profil</a>
<a href="blog.php">Blog</a>
</div>

</body>
</html>