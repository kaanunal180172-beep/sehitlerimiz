<?php
include '../detay/config.php';

if (!isset($_GET['id'])) {
    die('Düzenlenecek blog ID belirtilmedi.');
}

$id = (int)$_GET['id'];

// Blog verisini çek
$stmt = $pdo->prepare("SELECT * FROM haberler WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    die('Blog bulunamadı.');
}

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isim = $_POST['isim'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $rutbe = $_POST['rutbe'] ?? '';

    if (!$isim || !$kategori || !$rutbe) {
        $errorMessage = "Lütfen tüm alanları doldurun.";
    } else {
        $stmt = $pdo->prepare("UPDATE haberler SET isim = ?, kategori = ?, rutbe = ? WHERE id = ?");
        $stmt->execute([$isim, $kategori, $rutbe, $id]);
        $successMessage = "Blog başarıyla güncellendi.";

        // Güncellenmiş veriyi tekrar çek
        $stmt = $pdo->prepare("SELECT * FROM haberler WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Blog Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container py-5">
    <h2>Blog Düzenle: ID <?= htmlspecialchars($blog['id']) ?></h2>

    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php elseif ($errorMessage): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="isim" class="form-label">İsim</label>
            <input type="text" class="form-control" id="isim" name="isim" value="<?= htmlspecialchars($blog['isim']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="<?= htmlspecialchars($blog['kategori']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="rutbe" class="form-label">Rütbe</label>
            <input type="text" class="form-control" id="rutbe" name="rutbe" value="<?= htmlspecialchars($blog['rutbe']) ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Güncelle</button>
        <a href="blog_listele.php" class="btn btn-secondary">Geri</a>
    </form>
</div>
</body>
</html>
