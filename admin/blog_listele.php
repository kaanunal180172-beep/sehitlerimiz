<?php
include '../detay/config.php';

// Tüm blogları çek
$stmt = $pdo->query("SELECT * FROM haberler ORDER BY tarih DESC");
$haberler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Düzenlenecek blog ID'si (id GET parametresi)
$edit_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$edit_blog = null;

// Mesajlar
$successMessage = '';
$errorMessage = '';

// Düzenlenecek blogu çek
if ($edit_id) {
    $stmt = $pdo->prepare("SELECT * FROM haberler WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_blog = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Form gönderildiyse ve düzenleme yapılacaksa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = (int)$_POST['edit_id'];
    $isim = $_POST['isim'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $rutbe = $_POST['rutbe'] ?? '';

    if (!$isim || !$kategori || !$rutbe) {
        $errorMessage = "Lütfen tüm alanları doldurun.";
    } else {
        // Eski resmi al
        $stmt = $pdo->prepare("SELECT resim FROM haberler WHERE id = ?");
        $stmt->execute([$edit_id]);
        $old = $stmt->fetch(PDO::FETCH_ASSOC);
        $resimAdi = $old['resim'] ?? '';

        if (isset($_FILES['resim']) && $_FILES['resim']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../resimler/';
            $tmpName = $_FILES['resim']['tmp_name'];
            $orjAdi = $_FILES['resim']['name'];
            $ext = strtolower(pathinfo($orjAdi, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($ext, $allowed)) {
                $errorMessage = "Sadece JPG, PNG, GIF formatında resim yükleyebilirsiniz.";
            } else {
                $resimAdi = uniqid('img_') . '.' . $ext;
                $uploadPath = $uploadDir . $resimAdi;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    if (!empty($old['resim']) && file_exists($uploadDir . $old['resim'])) {
                        unlink($uploadDir . $old['resim']);
                    }
                } else {
                    $errorMessage = "Resim yüklenemedi.";
                }
            }
        }

        if (!$errorMessage) {
            $stmt = $pdo->prepare("UPDATE haberler SET isim=?, kategori=?, rutbe=?, resim=? WHERE id=?");
            $stmt->execute([$isim, $kategori, $rutbe, $resimAdi, $edit_id]);
            $successMessage = "Blog başarıyla güncellendi.";

            // Güncellenmiş blogu tekrar çek
            $stmt = $pdo->prepare("SELECT * FROM haberler WHERE id = ?");
            $stmt->execute([$edit_id]);
            $edit_blog = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Blog Listele ve Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container py-5">

<h2>Bloglar</h2>

<table class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>İsim</th>
            <th>Kategori</th>
            <th>Rütbe</th>
            <th>Resim</th>
            <th>Başlık</th>
            <th>Tarih</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($haberler as $haber): ?>
            <tr>
                <td><?= htmlspecialchars($haber['id']) ?></td>
                <td><?= htmlspecialchars($haber['isim']) ?></td>
                <td><?= htmlspecialchars($haber['kategori']) ?></td>
                <td><?= htmlspecialchars($haber['rutbe']) ?></td>
                <td>
                    <?php if (!empty($haber['resim']) && file_exists('../resimler/' . $haber['resim'])): ?>
                        <img src="../resimler/<?= htmlspecialchars($haber['resim']) ?>" style="max-width: 100px;" alt="Resim">
                    <?php else: ?>
                        Resim yok
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($haber['baslik']) ?></td>
                <td><?= htmlspecialchars($haber['tarih']) ?></td>
                <td>
                    <a href="index.php?sayfa=blog_listele&id=<?= $haber['id'] ?>" class="btn btn-primary btn-sm">Düzenle</a>
                    <a href="blog_sil.php?id=<?= $haber['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($edit_blog): ?>
    <hr>
    <h3>Blog Düzenle: ID <?= $edit_blog['id'] ?></h3>

    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php elseif ($errorMessage): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" value="<?= $edit_blog['id'] ?>" />
        <div class="mb-3">
            <label for="isim" class="form-label">İsim</label>
            <input type="text" id="isim" name="isim" class="form-control" value="<?= htmlspecialchars($edit_blog['isim']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" id="kategori" name="kategori" class="form-control" value="<?= htmlspecialchars($edit_blog['kategori']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="rutbe" class="form-label">Rütbe</label>
            <input type="text" id="rutbe" name="rutbe" class="form-control" value="<?= htmlspecialchars($edit_blog['rutbe']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="resim" class="form-label">Resim (İsteğe bağlı)</label><br>
            <?php if (!empty($edit_blog['resim']) && file_exists('../resimler/' . $edit_blog['resim'])): ?>
                <img src="../resimler/<?= htmlspecialchars($edit_blog['resim']) ?>" style="max-width: 200px; margin-bottom: 10px;" alt="Mevcut Resim">
            <?php endif; ?>
            <input type="file" id="resim" name="resim" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Güncelle</button>
        <a href="index.php?sayfa=blog_listele" class="btn btn-secondary">İptal</a>
    </form>
<?php endif; ?>

</div>
</body>
</html>
