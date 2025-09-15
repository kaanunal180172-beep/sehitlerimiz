<?php
// output buffering ile hata önleyebiliriz (opsiyonel)
// ob_start();

include 'config.php';  // veritabanı bağlantısı

// POST kontrolü ve veri ekleme işlemi (çıktıdan önce olmalı)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adsoyad = $_POST['adsoyad'] ?? '';
    $iletisim = $_POST['iletisim'] ?? '';
    $mesaj = $_POST['mesaj'] ?? '';
    $link = $_POST['link'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($adsoyad) && !empty($mesaj) && !empty($email)) {
        $stmt = $pdo->prepare("INSERT INTO iletisim (adsoyad, iletisim, mesaj, link, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$adsoyad, $iletisim, $mesaj, $link, $email]);

        // Başarılıysa aynı sayfaya yönlendir
        header("Location: iletisim.php?success=1");
        exit();
    } else {
        $error = "Lütfen zorunlu alanları doldurun.";
    }
}

include 'header.php';
include 'adsense.php';

$success = isset($_GET['success']) && $_GET['success'] == 1;
?>

<div class="container py-5">
    <div class="row justify-content-center align-items-center">

        <!-- Harita -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="ratio ratio-4x3">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3060.9119225271674!2d32.85974107580625!3d39.93336338577464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d34f1d4c6d19c3%3A0xf75d5b4346d74652!2sAn%C4%B1tkabir!5e0!3m2!1str!2str!4v1693765280939!5m2!1str!2str" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Form -->
        <div class="col-md-6">
            <h3 class="mb-4 text-center">İletişim</h3>

            <?php if ($success): ?>
                <div class="alert alert-success text-center">
                    Mesajınız başarıyla gönderildi.
                </div>
            <?php elseif (!empty($error)): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="iletisim.php" method="POST">
                <div class="mb-3">
                    <label for="adsoyad" class="form-label">Ad Soyad <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="adsoyad" name="adsoyad" required>
                </div>
                <div class="mb-3">
                    <label for="iletisim" class="form-label">İletişim Numarası (opsiyonel)</label>
                    <input type="text" class="form-control" id="iletisim" name="iletisim">
                </div>
                <div class="mb-3">
                    <label for="mesaj" class="form-label">Mesajınız <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="mesaj" name="mesaj" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="link" class="form-label">Varsa Eklemek İstediğiniz Link (opsiyonel)</label>
                    <input type="url" class="form-control" id="link" name="link">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta Adresiniz <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Gönder</button>
            </form>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>

<?php
// ob_end_flush(); // Eğer ob_start() kullandıysan
?>
