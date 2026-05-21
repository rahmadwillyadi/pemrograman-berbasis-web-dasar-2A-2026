CREATE DATABASE db_absensi;

USE db_absensi;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user'
);

CREATE TABLE absensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    tanggal DATE NOT NULL,
    jam_absen TIME NOT NULL,
    keterangan ENUM('Hadir','Izin','Sakit','Alpha') DEFAULT 'Hadir',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE status_absensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    status ENUM('buka','tutup') NOT NULL
);



INSERT INTO users
VALUES
(
3,
'250441100081',
'Angga Yunanda',
'250441100081',
'user'
),
(
4,
'250441100094',
'Fushiguro Rahmat',
'250441100094',
'user'
);




