<?php
// adsense.php - Google Adsense test reklamları ile, mobilde yan reklamlar gizli
?>

<style>
    /* Masaüstü yan reklamlar */
    .adsense-left, .adsense-right {
        position: fixed;
        top: 60%;
        transform: translateY(-50%);
        width: 160px;
        height: 600px;
        z-index: 9999;
        background-color:#f9f9f9; /* Arka plan verildi, reklam görünür olsun */
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .adsense-left {
        left: 10px;
    }
    .adsense-right {
        right: 10px;
    }

    /* Mobilde yan reklamları kesin gizle */
    @media (max-width: 768px) {
        .adsense-left, .adsense-right {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Mobil reklamlar içerikte blok olarak göster */
        .adsense-mobile {
            display: block !important;
            background-color:#f9f9f9;
            width: 320px;
            height: 100px;
            margin: 20px auto;
            text-align: center;
        }
        .adsense-mobile ins {
            max-width: 100%;
            height: auto !important;
            display: block;
            margin: 0 auto;
        }
    }

    /* Masaüstünde mobil reklam gizli */
    .adsense-mobile {
        display: none;
    }
</style>

<!-- Masaüstü Sol Reklam (Test reklam) -->
<div class="adsense-left">
    <ins class="adsbygoogle"
         style="display:inline-block;width:160px;height:600px"
         data-ad-client="ca-pub-3940256099942544"
         data-ad-slot="6300978111"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>

<!-- Masaüstü Sağ Reklam (Test reklam) -->
<div class="adsense-right">
    <ins class="adsbygoogle"
         style="display:inline-block;width:160px;height:600px"
         data-ad-client="ca-pub-3940256099942544"
         data-ad-slot="6300978111"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>

<!-- Mobil Tek Reklam (Test reklam) -->
<div class="adsense-mobile">
    <ins class="adsbygoogle"
         style="display:block;width:320px;height:100px"
         data-ad-client="ca-pub-3940256099942544"
         data-ad-slot="6300978111"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
