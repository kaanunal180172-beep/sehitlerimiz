<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$adminUser = $_SESSION['admin_username'] ?? 'admin';
$currentPage = basename($_SERVER['PHP_SELF']);
$sayfa = $_GET['sayfa'] ?? '';

$isHome = ($currentPage === 'index.php' && ($sayfa === '' || $sayfa === 'ana_sayfa'));

$isBlogAdd = ($sayfa === 'blog_ekle');
$isBlogList = ($sayfa === 'blog_listele');


$isYoneticiAdd = ($sayfa === 'yonetici_ekle');
$isYoneticiList = ($sayfa === 'yonetici_listele');
$isYoneticiEdit = ($sayfa === 'yonetici_duzenle');

// Alt menü açık mı?
$haberlerOpen = $isBlogAdd || $isBlogList;
$yoneticiOpen = $isYoneticiAdd || $isYoneticiList || $isYoneticiEdit;

function isActive($condition) {
    return $condition ? 'active' : '';
}
?>


<style>
    * { box-sizing: border-box; }
    body, html {
        margin: 0;
        padding: 0;
        height: 100vh;
        font-family: Arial, sans-serif;
    }
    nav {
        width: 250px;
        background-color: #2c3e50;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    nav a {
        color: #fff;
        display: block;
        padding: 15px 20px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    nav a:hover,
    nav a.active {
        background-color: #28a745;
        color: white;
    }
    nav .header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    nav .header .logout-icon {
        color: white;
        font-size: 1.3rem;
        text-decoration: none;
        margin-left: 10px;
    }
    nav .header .logout-icon:hover {
        color: #dc3545;
    }
    nav .sub-item {
        padding-left: 35px;
        font-size: 0.95em;
        color: #ccc;
    }
    nav .sub-item.active {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        margin-left: 10px;
        border-radius: 4px;
    }
    nav .dropdown-header {
        cursor: pointer;
        padding: 15px 20px;
        color: white;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    nav .dropdown-header:hover {
        background-color: #28a745;
    }
    nav .toggle-icon {
        font-size: 14px;
        transition: transform 0.3s ease;
    }
    nav .toggle-icon.open {
        transform: rotate(180deg);
    }
    nav .submenu {
        display: none;
        flex-direction: column;
        background-color: #34495e;
    }
    nav .submenu.open {
        display: flex;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const headers = document.querySelectorAll('nav .dropdown-header');
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const submenu = header.nextElementSibling;
                const icon = header.querySelector('.toggle-icon');
                submenu.classList.toggle('open');
                icon.classList.toggle('open');
            });
        });
    });
</script>

<nav>
    <div class="header" title="Çıkış Yap">
        <span>Hoşgeldiniz, <?= htmlspecialchars($adminUser) ?></span>
        <a href="logout.php" class="logout-icon" title="Çıkış Yap">⎋</a>
    </div>

    <a href="index.php?sayfa=ana_sayfa" class="<?= isActive($isHome) ?>">Ana Sayfa</a>

    <!-- HABERLER -->
    <div class="dropdown-header <?= $haberlerOpen ? 'active' : '' ?>">
        Haberler
        <span class="toggle-icon <?= $haberlerOpen ? 'open' : '' ?>">▼</span>
    </div>
    <div class="submenu <?= $haberlerOpen ? 'open' : '' ?>">
        <a href="index.php?sayfa=blog_ekle" class="<?= isActive($isBlogAdd) ?>">Blog Ekle</a>
        <a href="index.php?sayfa=blog_listele" class="<?= isActive($isBlogList) ?>">Blog Listele</a>
    </div>

    <!-- YÖNETİCİLER -->
    <div class="dropdown-header <?= $yoneticiOpen ? 'active' : '' ?>">
        Yöneticiler
        <span class="toggle-icon <?= $yoneticiOpen ? 'open' : '' ?>">▼</span>
    </div>
    <div class="submenu <?= $yoneticiOpen ? 'open' : '' ?>">
        <a href="index.php?sayfa=yonetici_ekle" class="<?= isActive($isYoneticiAdd) ?>">Yönetici Ekle</a>
        <a href="index.php?sayfa=yonetici_listele" class="<?= isActive($isYoneticiList) ?>">Yönetici Listele</a>
        <?php if ($isYoneticiEdit): ?>
            <div class="sub-item active">→ Yönetici Düzenleniyor</div>
        <?php endif; ?>
    </div>
</nav>
