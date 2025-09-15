<?php
include 'config.php';  // PDO bağlantısı

// Haberleri çekiyoruz (son tarih önce)
$sql = "SELECT * FROM haberler ORDER BY tarih DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$haberler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kategoriler
$validCategories = ['tum', 'asker', 'polis', 'memur', 'sivil'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dinamik Haberler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Menü butonları */
        .news-menu button.active,
        .news-menu button:hover {
            border-bottom: 3px solid #dc3545;
            color: #dc3545;
        }
        .news-menu button {
            border: none;
            background: transparent;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 10px 15px;
            transition: all 0.3s;
            border-radius: 0;
            cursor: pointer;
        }
        .news-menu {
            border-bottom: 2px solid #ccc;
            margin-bottom: 30px;
            justify-content: center;
        }

        /* Haber kutusu */
        .news-item {
            cursor: default;
            transition: transform 0.3s ease;
        }
        .news-item:hover {
            transform: scale(1.03);
            z-index: 10;
            position: relative;
        }
        /* Resimler kare ve kırpılmış */
        .news-item img {
            width: 100%;
            aspect-ratio: 1 / 1; /* Kare */
            object-fit: cover;
            border-radius: 6px;
            transition: transform 0.3s ease;
        }
        .news-item img:hover {
            transform: scale(1.05);
        }
        .news-item h6 {
            margin-top: 10px;
            font-weight: 600;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .news-item small {
            color: #666;
        }
        .news-item hr {
            border-top: 2px solid #dc3545;
            margin: 10px 0 5px 0;
        }

        /* Sayfalama butonları */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        .btn-pagination {
            font-weight: 700;
            font-size: 1.2rem;
            padding: 8px 16px;
            margin: 0 5px;
            border-radius: 8px;
            min-width: 120px;
            transition: background-color 0.3s;
            cursor: pointer;
            border: 1px solid #dc3545;
            background-color: white;
            color: #dc3545;
        }
        .btn-pagination:hover:not(:disabled) {
            background-color: #dc3545;
            color: white;
        }
        .btn-pagination:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- Menü -->
    <div class="d-flex news-menu mb-4 flex-wrap">
        <button class="me-3 mb-2 active" data-category="tum">Tümü</button>
        <button class="me-3 mb-2" data-category="asker">Askerlerimiz</button>
        <button class="me-3 mb-2" data-category="polis">Polislerimiz</button>
        <button class="me-3 mb-2" data-category="memur">Devlet Memurlarımız</button>
        <button class="me-3 mb-2" data-category="sivil">Sivil Şehitlerimiz</button>
    </div>

    <!-- Haberler -->
    <div class="row g-4" id="haberler-container"></div>

    <!-- Sayfalama -->
    <div class="d-flex justify-content-center mt-4">
        <button id="prevBtn" class="btn-pagination" disabled>« Geri</button>
        <button id="nextBtn" class="btn-pagination" disabled>İleri »</button>
    </div>

</div>

<script>
    // PHP'den JS'ye haberler
    const allHaberler = <?= json_encode($haberler, JSON_UNESCAPED_UNICODE) ?>;

    let currentCategory = 'tum';
    let currentPage = 1;
    const itemsPerPage = 8;

    const haberlerContainer = document.getElementById('haberler-container');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const menuButtons = document.querySelectorAll('.news-menu button');

    menuButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            menuButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            currentCategory = btn.getAttribute('data-category');
            currentPage = 1;
            renderHaberler();
        });
    });

    prevBtn.addEventListener('click', () => {
        if(currentPage > 1) {
            currentPage--;
            renderHaberler();
        }
    });

    nextBtn.addEventListener('click', () => {
        if(currentPage < getTotalPages()) {
            currentPage++;
            renderHaberler();
        }
    });

    function getFilteredHaberler() {
        if(currentCategory === 'tum') {
            return allHaberler;
        }
        return allHaberler.filter(haber => haber.kategori.toLowerCase() === currentCategory);
    }

    function getTotalPages() {
        return Math.ceil(getFilteredHaberler().length / itemsPerPage);
    }

    function renderHaberler() {
        const filtered = getFilteredHaberler();
        const start = (currentPage -1) * itemsPerPage;
        const end = start + itemsPerPage;
        const slice = filtered.slice(start, end);

        haberlerContainer.innerHTML = '';

        if(slice.length === 0) {
            haberlerContainer.innerHTML = '<p>Gösterilecek haber bulunamadı.</p>';
            prevBtn.disabled = true;
            nextBtn.disabled = true;
            return;
        }

        slice.forEach(haber => {
            const div = document.createElement('div');
            div.classList.add('col-lg-3', 'col-md-4', 'col-sm-6', 'news-item');

            div.innerHTML = `
                <img src="resimler/${haber.resim}" alt="${haber.baslik}" />
                <hr />
                <h6 title="${haber.isim}">${haber.isim} - ${haber.kategori} - ${haber.rutbe}</h6>
                <small>Eklenme Tarihi: ${new Date(haber.tarih).toLocaleString('tr-TR')}</small>
            `;
            haberlerContainer.appendChild(div);
        });

        prevBtn.disabled = (currentPage === 1);
        nextBtn.disabled = (currentPage === getTotalPages());
    }

    renderHaberler();
</script>

</body>
</html>
