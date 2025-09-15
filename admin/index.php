<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// PDO bağlantısı
require_once __DIR__ . '/../detay/config.php';

// Sayfa belirleme
$sayfa = $_GET['sayfa'] ?? 'ana_sayfa';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Admin Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            margin: 0;
        }
        main {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>

<!-- Menü -->
<?php include 'admin_menu.php'; ?>

<!-- İçerik -->
<main>
    <?php
    switch ($sayfa) {
        case 'ana_sayfa':
            include 'anasayfa.php';
            break;

        // Blog işlemleri
        case 'blog_ekle':
            include 'blog_ekle.php';
            break;
        case 'blog_listele':
            include 'blog_listele.php';
            break;

        // Yönetici işlemleri
        case 'yonetici_ekle':
            include 'yonetici_ekle.php';
            break;
        case 'yonetici_listele':
            include 'yonetici_listele.php';
            break;
        case 'yonetici_duzenle':
            include 'yonetici_duzenle.php';
            break;

        default:
            echo "<h3>Sayfa bulunamadı.</h3>";
            break;
    }
    ?>
</main>

</body>
</html>
