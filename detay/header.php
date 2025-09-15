<!-- detay/header.php -->

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Web Sitem</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

<style>
    /* Hover ile dropdown açma - sadece masaüstü */
    @media (min-width: 992px) {
        .navbar-nav .dropdown:hover > .dropdown-menu {
            display: block;
            margin-top: 0;
        }
    }
</style>

<!-- ÜST BAR (SİYAH) -->
<div class="header-top py-3" style="background-color:#1a1a2b; color:#fff;">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="header-contact">
            <a href="mailto:info@yeniadiniz.com" class="header-contact-link me-4" style="color:#fff; text-decoration:none;">
                <i class="fas fa-envelope me-2"></i> info@yeniadiniz.com
            </a>
            <a href="tel:+905321234567" class="header-contact-link" style="color:#fff; text-decoration:none;">
                <i class="fas fa-phone me-2"></i> +90 532 123 45 67
            </a>
        </div>
        <div class="header-social">
            <a href="https://www.instagram.com/xxx" target="_blank" class="social-media-link" style="color:#fff; text-decoration:none; display:inline-flex; align-items:center;">
                <i class="fab fa-instagram fs-5 me-2" style="border:2px solid #fff; border-radius:50%; width:30px; height:30px; line-height:26px; text-align:center; transition: all 0.3s;"></i><span>xxx</span>
            </a>
        </div>
    </div>
</div>

<!-- ANA NAVBAR -->
<header class="header-main navbar navbar-expand-lg sticky-top" style="background-color:#f2f2f2; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="resimler/asker.jpg" alt="Logo" class="logo-img me-2" style="height:60px; margin:10px 0;" />
            <span class="site-title" style="font-weight:700; font-size:1.25rem; color:#333;">Kurumsal Siteniz</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" 
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Anasayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="galeri.php">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="iletisim.php">İletişim</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Şehitlerimiz <i class="fas fa-chevron-down ms-1"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="sehitlerimiz/asker.php">Askerlerimiz</a></li>
                        <li><a class="dropdown-item" href="sehitlerimiz/polis.php">Polislerimiz</a></li>
                        <li><a class="dropdown-item" href="sehitlerimiz/memur.php">Devlet Memurlarımız</a></li>
                        <li><a class="dropdown-item" href="sehitlerimiz/sivil.php">Sivil Şehitlerimiz</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
