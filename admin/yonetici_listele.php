<h2>Yöneticiler</h2>

<?php
include '../detay/config.php';

$stmt = $pdo->query("SELECT * FROM admins ORDER BY id ASC");
$yoneticiler = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$yoneticiler) {
    echo "<p>Henüz yönetici eklenmemiş.</p>";
} else {
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr>';
    echo '<th>ID</th>';
    echo '<th>Kullanıcı Adı</th>';
    echo '<th>Kullanıcı Şifresi</th>';
    echo '<th>İşlemler</th>';
    echo '</tr></thead><tbody>';

    foreach ($yoneticiler as $yonetici) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($yonetici['id']) . '</td>';
        echo '<td>' . htmlspecialchars($yonetici['username']) . '</td>';
        echo '<td>' . htmlspecialchars($yonetici['password']) . '</td>';
        echo '<td>
                <a href="index.php?sayfa=yonetici_duzenle&id=' . $yonetici['id'] . '" class="btn btn-sm btn-primary">Düzenle</a>
                <a href="yonetici_sil.php?id=' . $yonetici['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Bu yöneticiyi silmek istediğinize emin misiniz?\')">Sil</a>
              </td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}
?>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success mt-3">Yönetici başarıyla silindi.</div>
<?php endif; ?>
