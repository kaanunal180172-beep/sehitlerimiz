<footer class="footer bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">

            <!-- Logo ve Kısa Açıklama -->
            <div class="col-md-4 mb-4">
                <a href="index.php" class="d-inline-block mb-3">
                    <img src="resimler/asker.jpg" alt="Logo" style="height:60px;">
                </a>
                <p>
                    Kurumunuz hakkında kısa bir açıklama metni buraya gelecek. 
                    Misyon, vizyon veya slogan ekleyebilirsiniz.
                </p>
            </div>

            <!-- Hızlı Linkler -->
            <div class="col-md-2 mb-4">
                <h5 class="text-uppercase fw-bold">Hızlı Linkler</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="footer-link">Anasayfa</a></li>
                    <li><a href="galeri.php" class="footer-link">Galeri</a></li>
                    <li><a href="iletisim.php" class="footer-link">İletişim</a></li>
                    <li><a href="sehitlerimiz/asker.php" class="footer-link">Şehitlerimiz</a></li>
                </ul>
            </div>

            <!-- İletişim Bilgileri -->
            <div class="col-md-3 mb-4">
                <h5 class="text-uppercase fw-bold">İletişim</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i>Adresiniz buraya</p>
                <p><i class="fas fa-phone me-2"></i>+90 532 123 45 67</p>
                <p><i class="fas fa-envelope me-2"></i>info@yeniadiniz.com</p>
            </div>

            <!-- Sosyal Medya -->
            <div class="col-md-3 mb-4">
                <h5 class="text-uppercase fw-bold">Sosyal Medya</h5>
                <a href="https://instagram.com/xxx" target="_blank" class="btn btn-outline-light btn-sm me-2">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="btn btn-outline-light btn-sm me-2">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="btn btn-outline-light btn-sm">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>

        </div>

        <hr class="border-light">

        <div class="text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Tüm Hakları Saklıdır. | <strong>Şirket Adınız</strong></p>
        </div>
    </div>
</footer>


<style>


    .footer {

    
    background: #1a1a2b; /* Koyu arka plan */
    color: #ddd;
    font-size: 0.95rem;
}

.footer h5 {
    font-size: 1rem;
    margin-bottom: 1rem;
    color: #fff;
}

.footer-link {
    color: #ddd;
    text-decoration: none;
    display: block;
    margin-bottom: 0.5rem;
    transition: color 0.3s ease;
}

.footer-link:hover {
    color: #20c997;
}

.footer .btn-outline-light {
    border: 1px solid #ccc;
    color: #fff;
    transition: all 0.3s;
}

.footer .btn-outline-light:hover {
    background: #20c997;
    border-color: #20c997;
    color: #fff;
}
</style>