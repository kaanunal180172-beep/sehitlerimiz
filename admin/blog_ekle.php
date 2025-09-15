<?php
include '../detay/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isim = $_POST['isim'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $rutbe = $_POST['rutbe'] ?? '';
    
    $errorMessage = '';
    $successMessage = '';
    
    // Resim yükleme işlemi
    $resimAdi = '';
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../resimler/';
        $tmpName = $_FILES['resim']['tmp_name'];
        $orjAdi = $_FILES['resim']['name'];
        $ext = strtolower(pathinfo($orjAdi, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            $resimAdi = uniqid('img_') . '.' . $ext;
            $uploadPath = $uploadDir . $resimAdi;
            if (!move_uploaded_file($tmpName, $uploadPath)) {
                $errorMessage = "Resim yüklenemedi.";
                $resimAdi = '';
            }
        } else {
            $errorMessage = "Sadece JPG, PNG, GIF formatlarında resim yükleyebilirsiniz.";
        }
    }
    
    if (!$errorMessage) {
        if ($isim && $kategori && $rutbe) {
            $tarih = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare("INSERT INTO haberler (isim, kategori, rutbe, resim, tarih) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([$isim, $kategori, $rutbe, $resimAdi, $tarih]);
            
            if ($result) {
                $successMessage = "Blog başarıyla eklendi.";
            } else {
                $errorMessage = "Blog eklenirken hata oluştu.";
            }
        } else {
            $errorMessage = "Lütfen tüm alanları doldurun.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Blog Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
<div style="display:flex; min-height:100vh;">

    <main style="flex-grow:1; padding:30px;">
        <h2>Blog Ekle</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php elseif (!empty($errorMessage)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="isim" class="form-label">İsim</label>
                <input type="text" class="form-control" id="isim" name="isim" value="<?= htmlspecialchars($_POST['isim'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="kategori" name="kategori" value="<?= htmlspecialchars($_POST['kategori'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="rutbe" class="form-label">Rütbe</label>
                <input type="text" class="form-control" id="rutbe" name="rutbe" value="<?= htmlspecialchars($_POST['rutbe'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="resim" class="form-label">Resim</label>
                <input type="file" class="form-control" id="resim" name="resim" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Ekle</button>
        </form>
    </main>
</div>
</body>
</html>
