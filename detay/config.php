<?php
$host = "localhost"; // genellikle localhost olur
$dbname = "sehitlerimiz";
$username = "kaan"; // phpmyadmin kullanıcı adı, genelde root
$password = "Deneme789.";     // phpmyadmin şifren, yoksa boş bırak
$base_url = '/';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}