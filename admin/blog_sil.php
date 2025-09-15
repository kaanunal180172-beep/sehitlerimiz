<?php
session_start();
include '../detay/config.php';  // $pdo bağlantısı
if (!isset($_GET['id'])) {
    header('Location: blog_listele.php');
    exit;
}

$id = intval($_GET['id']);

// Önce resim dosyasını bulup silmek için
$stmt = $pdo->prepare("SELECT resim FROM haberler WHERE id = ?");
$stmt->execute([$id]);
$haber = $stmt->fetch(PDO::FETCH_ASSOC);

if ($haber) {
    if (!empty($haber['resim'])) {
        $resimYolu = '../resimler/' . $haber['resim'];
        if (file_exists($resimYolu)) {
            unlink($resimYolu);
        }
    }

    // Sonra veritabanından sil
    $stmt = $pdo->prepare("DELETE FROM haberler WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php?sayfa=blog_listele');
exit;
?>
