<!-- Izimodal -->
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'css/iziModal.min.css' ?>" />
<!-- Favicon -->
<?php $favicon = get_settings('web_favicon');

$path = ($is_rtl == 1) ? 'rtl/' : "";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">

<!--<< font link start  -->
<link rel="stylesheet" href="https://www.1001fonts.com/typey-mctypeface-font.html">
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'css/style.css' ?>" />
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'css/products.css' ?>" />
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'css/star-rating.min.css' ?>" />
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'css/vendurs-bundle-main.css' ?>" />
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'css/daterangepicker.css' ?>" />
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'vendurs.css' ?>" />
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'vendurs-responsive.css' ?>" />
<link rel="icon" href="<?= base_url($favicon) ?>" type="image/gif" sizes="16x16">
<!-- font awesome link   -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- swier slider  -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<!-- Sweeta Alert 2 -->
<link rel="stylesheet" href="<?= THEME_ASSETS_URL . 'css/sweetalert2.min.css' ?>" />


<!-- Jquery -->
<script src="<?= THEME_ASSETS_URL . 'js/jquery.min.js' ?>"></script>
<script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- swipper slider  -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="<?= THEME_ASSETS_URL . 'js/vendurs-bundle-top-js.js' ?>"></script>
<script type="text/javascript">
    base_url = "<?= base_url() ?>";
    currency = "<?= $settings['currency'] ?>";
    csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
    save_localstorage_guest_user_id();
    function save_localstorage_guest_user_id() {
        var guest_user_id = localStorage.getItem('guest_user_id');
        $.ajax({
            type: 'POST',
            url: base_url + 'cart/save_localstorage_guest_user_id',
            data: {
                [csrfName]: csrfHash,
                guest_user_id: guest_user_id,
            },
            dataType: 'json',
            success: function (result) {
                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
            }
        });
    }
</script>