<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../detay/config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Yönetici sil
    $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->execute([$id]);

    // Silme sonrası ana listeye yönlendir
    header("Location: index.php?sayfa=yonetici_listele&deleted=1");
    exit();
} else {
    header("Location: index.php?sayfa=yonetici_listele");
    exit();
}
?>
