<h2>Yeni Yönetici Ekle</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici = $_POST['kullanici_adi']; // burası formdaki name ile aynı olmalı
    $sifre = $_POST['sifre'];

    $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute([$kullanici, $sifre]);

    echo '<div class="alert alert-success mt-3">Yönetici başarıyla eklendi.</div>';
}
?>

<form method="POST">
    <div class="mb-3">
        <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
        <input type="text" name="kullanici_adi" id="kullanici_adi" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="sifre" class="form-label">Şifre</label>
        <input type="text" name="sifre" id="sifre" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Ekle</button>
</form>
