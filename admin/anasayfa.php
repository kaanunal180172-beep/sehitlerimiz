<?php
// Veritabanı bağlantısı zaten index.php'de yapılıyor, burada tekrar gerek yok

// Admin sayısı
$stmtAdmins = $pdo->query("SELECT COUNT(*) FROM admins");
$adminSayisi = $stmtAdmins->fetchColumn();

// Blog sayısı
$stmtBlog = $pdo->query("SELECT COUNT(*) FROM haberler");
$blogSayisi = $stmtBlog->fetchColumn();

// Son 4 haber
$stmtSonHaberler = $pdo->query("SELECT * FROM haberler ORDER BY tarih DESC LIMIT 4");
$sonHaberler = $stmtSonHaberler->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Genel İstatistikler</h2>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Toplam Admin</h5>
                <p class="card-text fs-4"><?= $adminSayisi ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Toplam Blog</h5>
                <p class="card-text fs-4"><?= $blogSayisi ?></p>
            </div>
        </div>
    </div>
</div>

<h4>Son Eklenen Haberler</h4>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>İsim</th>
                <th>Kategori</th>
                <th>Rütbe</th>
                <th>Başlık</th>
                <th>Tarih</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sonHaberler as $haber): ?>
                <tr>
                    <td><?= htmlspecialchars($haber['isim']) ?></td>
                    <td><?= htmlspecialchars($haber['kategori']) ?></td>
                    <td><?= htmlspecialchars($haber['rutbe']) ?></td>
                    <td><?= htmlspecialchars($haber['baslik']) ?></td>
                    <td><?= htmlspecialchars($haber['tarih']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
