<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../detay/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Geçersiz ID.</div>";
    exit();
}

$id = (int)$_GET['id'];

// Yönetici bilgilerini çek
$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "<div class='alert alert-danger'>Yönetici bulunamadı.</div>";
    exit();
}

$hata = "";
$basari = "";

// Form gönderildiyse işle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $hata = "Kullanıcı adı ve şifre boş bırakılamaz.";
    } else {
        // Şifreyi istersen hashle
        $guncelle = $pdo->prepare("UPDATE admins SET username = ?, password = ? WHERE id = ?");
        $guncelle->execute([$username, $password, $id]);
        $basari = "Yönetici başarıyla güncellendi.";

        // Yeniden veriyi çek
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
        $stmt->execute([$id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!-- Sayfa içeriği -->
<div class="container mt-4">
    <h3>Yönetici Düzenle</h3>

    <?php if ($hata): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <?php if ($basari): ?>
        <div class="alert alert-success"><?= htmlspecialchars($basari) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?sayfa=yonetici_duzenle&id=<?= $id ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Şifre</label>
            <input type="text" id="password" name="password" class="form-control" value="<?= htmlspecialchars($admin['password']) ?>" required>
            <small class="form-text text-muted">Şifreyi değiştirmek istemiyorsanız aynı bırakabilirsiniz.</small>
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="index.php?sayfa=yonetici_listele" class="btn btn-secondary">İptal</a>
    </form>
</div>
