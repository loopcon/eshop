<?php
$this->load->model('category_model');
$categories = $this->category_model->get_categories(null, 8);
$language = get_languages();
$cookie_lang = $this->input->cookie('language', TRUE);
$language_index = 0;
if (!empty($cookie_lang)) {
    $language_index = array_search($cookie_lang, array_column($language, "language"));
}
$web_settings = get_settings('web_settings', true);
?>
<div id="mySidenav" class="sidenav is-closed-left">
    <div class="container">
        <div class="row my-2 pr-2 text-uppercase d-flex align-items-center">
            <div class="col-12 text-right close-sidenav"> <a href='#' onclick="closeNav();"><?= !empty($this->lang->line('close')) ? $this->lang->line('close') : '' ?> <i class="fa fa-times"></i></a></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <select class='search_product' name="search"></select>
            </div>
        </div>
    </div>
    <hr>
    <!-- Nav Mobile tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" data-toggle="tab" href="#Menu"><?= !empty($this->lang->line('menu')) ? $this->lang->line('menu') : 'Menu' ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#Categories"><?= !empty($this->lang->line('category')) ? $this->lang->line('category') : 'Category ' ?></a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-0 mt-1">
        <div id="Menu" class="tab-pane active show">
            <aside class="sidebar">
                <div id="leftside-navigation" class="nano">
                    <ul class="nano-content">
                        <li><a href="<?= base_url('products') ?>"><i class="fas fa-box-open fa-lg"></i> <span><?= !empty($this->lang->line('products')) ? $this->lang->line('products') : 'Products' ?></span></a></li>
                        <?php if ($this->ion_auth->logged_in()) { ?>
                            <li><a href="<?= base_url('my-account/wallet') ?>"><i class="fa fa-wallet fa-lg"></i> <?= !empty($this->lang->line('balance')) ? $this->lang->line('balance') : 'Balance' ?> <?= ' : ' . $settings['currency'] . ' ' . $user->balance ?></a></li>
                            <li><a href="<?= base_url('my-account') ?>"><i class="far fa-user-circle fa-lg"></i> <?= !empty($this->lang->line('my_account')) ? $this->lang->line('my_account') : 'My Account' ?></a></li>
                            <li><a href="<?= base_url('my-account/orders') ?>"><i class="fa fa-history fa-lg"></i> <?= !empty($this->lang->line('my_orders')) ? $this->lang->line('my_orders') : 'My Orders' ?></a></li>
                            <li><a href="<?= base_url('my-account/favorites') ?>"><i class="far fa-heart fa-lg"></i> <?= !empty($this->lang->line('favorite')) ? $this->lang->line('favorite') : 'Favorite' ?></a></li>
                        <?php } else { ?>
                            <li><a href="" class="auth_model" data-izimodal-open=".auth-modal" data-value="login"><i class="far fa-user-circle fa-lg"></i> <?= !empty($this->lang->line('my_account')) ? $this->lang->line('my_account') : 'My Account' ?></a></li>
                            <li><a href="" class="auth_model" data-izimodal-open=".auth-modal" data-value="login"><i class="fa fa-history fa-lg"></i> <?= !empty($this->lang->line('my_orders')) ? $this->lang->line('my_orders') : 'My Orders' ?></a></li>
                            <li><a href="" class="auth_model" data-izimodal-open=".auth-modal" data-value="login"><i class="far fa-heart fa-lg"></i> <?= !empty($this->lang->line('favorite')) ? $this->lang->line('favorite') : 'Favorite' ?></a></li>
                            <li><a href="" class="auth_model" data-izimodal-open=".auth-modal" data-value="login"><i class="fa fa-sign-in-alt fa-lg"></i> <?= !empty($this->lang->line('login')) ? $this->lang->line('login') : 'Login' ?></a></li>
                            <li><a href="" class="auth_model" data-izimodal-open=".auth-modal" data-value="register"><i class="fa fa-user-check fa-lg"></i> <?= !empty($this->lang->line('register')) ? $this->lang->line('register') : 'Register' ?></a></li>
                        <?php } ?>
                        <li><a href="<?= base_url('home/about-us') ?>"><i class="fa fa-info fa-lg"></i> <span><?= !empty($this->lang->line('about_us')) ? $this->lang->line('about_us') : 'About Us' ?></span></a></li>
                        <li><a href="<?= base_url('home/contact-us') ?>"><i class="fa fa-envelope fa-lg"></i> <span><?= !empty($this->lang->line('contact_us')) ? $this->lang->line('contact_us') : 'Contact Us' ?></span></a></li>
                        <?php if ($this->ion_auth->logged_in()) { ?>
                            <li><a href="<?= base_url('login/logout') ?>"><i class="fa fa-sign-out-alt fa-lg"></i> <?= !empty($this->lang->line('logout')) ? $this->lang->line('logout') : 'Logout' ?></a></li>
                        <?php } ?>
                        <li class="sub-menu">
                            <a href="javascript:void(0);"><i class="fa fa-language fa-lg"></i> <span><?= !empty($this->lang->line('language')) ? $this->lang->line('language') : 'Language' ?></span><i class="arrow fa fa-angle-left float-right"></i></a>
                            <ul>
                                <?php foreach ($language as $row) { ?>
                                    <li><a href="<?= base_url('home/lang/' . strtolower($row['language'])) ?>"><?= strtoupper($row['code']) . ' - ' . ucfirst($row['language']) ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
        <div id="Categories" class="tab-pane fade">
            <aside class="sidebar">
                <div id="leftside-navigation" class="nano mobile-categories">
                    <ul class="nano-content">
                        <?php
                        foreach ($categories as $row) { ?>
                            <li class="sub-menu">
                                <a href="<?= base_url('products/category/' . $row['slug']) ?>">
                                    <span class="category-span">
                                        <img class="svg-icon-image lazy" data-src="<?= $row['image'] ?>" />
                                        <span class="category-line-height"><?= $row['name'] ?></span>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="see-all-category">
                            <a href="<?= base_url('home/categories') ?>"><?= !empty($this->lang->line('see_all')) ? $this->lang->line('see_all') : 'See All' ?></a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>
<div class="shopping-cart-sidebar is-closed-right bg-white">
    <input type="hidden" name="is_loggedin" id="is_loggedin" value="<?= (isset($user->id)) ? 1 : 0 ?>">
    <div class="container header ">
        <div class="my-2 text-uppercase d-flex align-items-center">
            <div class="col-8 title">
                <h1><?= !empty($this->lang->line('shopping_cart')) ? $this->lang->line('shopping_cart') : 'Shopping Cart' ?></h1>
            </div>
            <div class="col-4 text-right close-sidebar"> <a href='#' onclick="closeNav();"><?= !empty($this->lang->line('close')) ? $this->lang->line('close') : '' ?> <i class="fa fa-times"></i></a></div>
        </div>
    </div>
    <hr class="m-0">
    <div class="text-center mt-2"><a class="button button-danger button-rounded" href="<?= base_url('products') ?>"> <?= !empty($this->lang->line('return_to_shop')) ? $this->lang->line('return_to_shop') : 'Return To Shop' ?></a></div>
    <div class="shopping-cart-sm container bg-white rounded mt-4 mb-2" id="cart-item-sidebar">
        <?php
            // if (isset($user->id)) {
            if ($is_logged_in) {
                $cart_items = $this->cart_model->get_user_cart($user->id);
                if (count($cart_items) != 0) {
                    foreach ($cart_items as $items) {
                        $price = $items['special_price'] != '' && $items['special_price'] > 0 && $items['special_price'] != null ? $items['special_price'] : $items['price'];
        ?>
            <div class="">
                <div class="cart-product product-sm col-md-12">
                    <div class="product-image">
                        <img class="pic-1 lazy" data-src="<?= base_url($items['image']) ?>" alt="<?= html_escape($items['name']) ?>" title="<?= html_escape($items['name']) ?>">
                    </div>
                    <div class="product-details">
                        <?php $check_current_stock_status = validate_stock([$items['product_variant_id']], [$items['qty']]); ?>
                        <div class="product-title"><?= strip_tags(output_escaping(str_replace('\r\n', '&#13;&#10;', $items['name']))) ?> <?= (isset($check_current_stock_status['error'])  && $check_current_stock_status['error'] == TRUE) ? "<span class='badge badge-danger'>  Out of Stock </span>" :  "" ?> </div>
                        <span>
                            <?php if (!empty($items['product_variants'])) { ?>
                                <?= str_replace(',', ' | ', $items['product_variants'][0]['variant_values']) ?>
                            <?php } ?>
                        </span>
                        <?php /* <p class="product-descriptions"><?= strip_tags(output_escaping(str_replace('\r\n', '&#13;&#10;', $items['short_description']))) ?></p> */ ?>
                    </div>
                    <div class="product-pricing d-flex py-2 px-1 w-100">
                        <div class="product-price align-self-center"><?= $settings['currency'] . ' ' . $price ?></div>
                        <div class="product-quantity product-sm-quantity px-1">
                            <input type="number" name="header_qty" class="form-input" value="<?= $items['qty'] ?>" data-id="<?= $items['product_variant_id'] ?>" data-price="<?= $price ?>" min="<?= $items['minimum_order_quantity'] ?>" max="<?= $items['total_allowed_quantity'] ?>" step="<?= $items['quantity_step_size'] ?>">
                        </div>
                        <div class="product-sm-removal align-self-center">
                            <button class="remove-product button button-danger" data-id="<?= $items['product_variant_id'] ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <div class="product-line-price align-self-center px-1"><?= $settings['currency'] . ' ' . number_format($items['qty'] * $price, 2) ?></div>
                    </div>
                </div>
            </div>
        <?php
                    }
                } else {
        ?>
            <h1 class="h4 text-center"><?= !empty($this->lang->line('empty_cart_message')) ? $this->lang->line('empty_cart_message') : 'Your Cart Is Empty' ?></h1>
        <?php
                }
            } else {
                $user_id = $this->session->userdata('guest_user_id');
                $cart_items = $this->cart_model->get_user_cart($user_id, 0, '', 1);
                if (count($cart_items) != 0) {
                    foreach ($cart_items as $items) {
                        $price = $items['special_price'] != '' && $items['special_price'] > 0 && $items['special_price'] != null ? $items['special_price'] : $items['price'];
        ?>
            <div class="">
                <div class="cart-product product-sm col-md-12">
                    <div class="product-image">
                        <img class="pic-1 lazy" data-src="<?= base_url($items['image']) ?>" alt="<?= html_escape($items['name']) ?>" title="<?= html_escape($items['name']) ?>">
                    </div>
                    <div class="product-details">
                        <?php $check_current_stock_status = validate_stock([$items['product_variant_id']], [$items['qty']]); ?>
                        <div class="product-title"><?= strip_tags(output_escaping(str_replace('\r\n', '&#13;&#10;', $items['name']))) ?> <?= (isset($check_current_stock_status['error'])  && $check_current_stock_status['error'] == TRUE) ? "<span class='badge badge-danger'>  Out of Stock </span>" :  "" ?> </div>
                        <span>
                            <?php if (!empty($items['product_variants'])) { ?>
                                <?= str_replace(',', ' | ', $items['product_variants'][0]['variant_values']) ?>
                            <?php } ?>
                        </span>
                        <?php /* <p class="product-descriptions"><?= strip_tags(output_escaping(str_replace('\r\n', '&#13;&#10;', $items['short_description']))) ?></p> */ ?>
                    </div>
                    <div class="product-pricing d-flex py-2 px-1 w-100">
                        <div class="product-price align-self-center"><?= $settings['currency'] . ' ' . $price ?></div>
                        <div class="product-quantity product-sm-quantity px-1">
                            <input type="number" name="header_qty" class="form-input" value="<?= $items['qty'] ?>" data-id="<?= $items['product_variant_id'] ?>" data-price="<?= $price ?>" min="<?= $items['minimum_order_quantity'] ?>" max="<?= $items['total_allowed_quantity'] ?>" step="<?= $items['quantity_step_size'] ?>">
                        </div>
                        <div class="product-sm-removal align-self-center">
                            <button class="remove-product button button-danger" data-id="<?= $items['product_variant_id'] ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <div class="product-line-price align-self-center px-1"><?= $settings['currency'] . ' ' . number_format($items['qty'] * $price, 2) ?></div>
                    </div>
                </div>
            </div>
        <?php
                    }
                } else {
        ?>
            <h1 class="h4 text-center"><?= !empty($this->lang->line('empty_cart_message')) ? $this->lang->line('empty_cart_message') : 'Your Cart Is Empty' ?></h1>
        <?php
                }
            }
        ?>
    </div>
    <div class="text-center mt-2"><a class="button button-success button-rounded view_cart_button" href="<?= base_url('cart') ?>"><?= !empty($this->lang->line('view_cart')) ? $this->lang->line('view_cart') : 'View Cart' ?></a></div>
</div>
<!-- navbar start  -->
<div>
    <div class="<?=($this->router->fetch_class()=="home" && $this->router->fetch_method()=="index" ? "navbg" : ""); ?>" <?=($this->router->fetch_class()=="home" && $this->router->fetch_method()=="index" ? 'style="background:url(\''.$homepage_settings['banner'].'\');background-repeat:no-repeat;background-size:100%;"' : '');?>>
        <div class="container">
            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <img src="<?= THEME_ASSETS_URL. 'img/vendurs 149-144.png' ?>" class="logo p-2">
                    <a class="navbar-brand brandname" href="<?= base_url() ?>"> Vendurs </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php if($this->router->fetch_class()!="home") { ?>
                        <div class="search-box-header">
                            <form class="search" action="<?php echo base_url('products/search'); ?>" method="get">
                                <div>
                                    <input class="form-field search-input" type="text" name="q" placeholder="Search for product">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass  searchiconheader "></i></button>
                                </div>
                                <div id="search-list" class="d-none"></div>
                            </form>
                        </div>
                    <?php } ?>
                    <?php if($this->router->fetch_class()=="home" && $this->router->fetch_method()=="index") { ?>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="nav-item dropdown ms-auto marketplace-menu">
                                <a class="nav-link nava marketplace" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop the marketplace <i class="fa-solid fa-angle-down"></i></a>
                                <div class="dropdown-menu category-menu">
                                    <div class="row">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 user-login-menu">
                            <?php if ($this->ion_auth->logged_in()) { ?>
                                <li class="nav-item dropdown active">
                                    <a class="m-1" data-toggle="dropdown" href="#"><i class="fas fa-user fa-lg link-color"></i>
                                        <span class="text-dark font-weight-bold"> <?= (isset($user->username) && !empty($user->username)) ? "Hello " . $user->username  : 'Login / Register' ?></span>
                                        <i class="fas fa-angle-down link-color"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-lg after-login-menu">
                                        <a href="<?= base_url('my-account/wallet') ?>" class="dropdown-item"><i class="fas fa-wallet mr-2 text-primary link-color"></i> <?= $settings['currency'] . ' ' . number_format($user->balance, 2) ?></a>
                                        <a href="<?= base_url('my-account') ?>" class="dropdown-item"><i class="fas fa-user mr-2 text-primary link-color"></i> <?= !empty($this->lang->line('profile')) ? $this->lang->line('profile') : 'Profile' ?> </a>
                                        <a href="<?= base_url('my-account/orders') ?>" class="dropdown-item"><i class="fas fa-history mr-2 text-primary link-color"></i> <?= !empty($this->lang->line('orders')) ? $this->lang->line('orders') : 'Orders' ?> </a>
                                        <a href="<?= base_url('login/logout') ?>" class="dropdown-item"><i class="fa fa-sign-out-alt mr-2 text-primary link-color"></i><?= !empty($this->lang->line('logout')) ? $this->lang->line('logout') : 'Logout' ?></a>
                                    </div>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link nava auth_model" data-izimodal-open=".auth-modal" data-value="login" href="javascript:void(0);"> <?= !empty($this->lang->line('login')) ? $this->lang->line('login') : 'Login' ?> <img src="<?= THEME_ASSETS_URL. 'img/login.png' ?>"> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nava auth_model" data-izimodal-open=".auth-modal" data-value="register" href="javascript:void(0);"> <?= !empty($this->lang->line('register')) ? $this->lang->line('register') : 'Register' ?> <img src="<?= THEME_ASSETS_URL. 'img/register.png' ?>"> </a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link nava auth_model" data-izimodal-open=".auth-modal" data-value="register-as-seller" href="javascript:void(0);"> <?= !empty($this->lang->line('register_as_seller')) ? $this->lang->line('register_as_seller') : 'Register as seller' ?> <img src="<?= THEME_ASSETS_URL. 'img/register.png' ?>"> </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a href="<?= base_url('my-account/favorites') ?>"> <img src="<?= THEME_ASSETS_URL. 'img/like.png' ?>" class="m-2 "> </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('compare') ?>" onclick=display_compare() data-product-id="<?= (isset($row['id']) && $row['id']) != 0 ? $row['id'] : '' ?>"> <img src="<?= THEME_ASSETS_URL. 'img/ri_exchange-fill.png' ?>" class="m-2"> </a>
                            </li>
                            <?php $page = $this->uri->segment(2) == 'checkout' ? 'checkout' : '' ?>
                            <?php if ($page == 'checkout') { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('cart') ?>" class="">
                                        <img src="<?= THEME_ASSETS_URL. 'img/bxs_cart-add.png' ?>" class="m-2">
                                        <span class="badge badge-danger badge-sm" id='cart-count'>
                                            <?php if($is_logged_in==1) { ?>
                                                <?= (count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) != 0 ? count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) : '0'); ?>
                                            <?php } else { ?>
                                                <?= (count($this->cart_model->get_user_cart($this->session->userdata('guest_user_id'), 0, '', 1)) != 0 ? count($this->cart_model->get_user_cart($this->session->userdata('guest_user_id'), 0, '', 1)) : '0'); ?>
                                            <?php } ?>
                                        </span>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="" onclick=openCartSidebar()>
                                        <img src="<?= THEME_ASSETS_URL. 'img/bxs_cart-add.png' ?>" class="m-2">
                                        <span class="badge badge-danger badge-sm" id='cart-count'>
                                            <?php if($is_logged_in==1) { ?>
                                                <?= (count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) != 0 ? count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) : '0'); ?>
                                            <?php } else { ?>
                                                <?= (count($this->cart_model->get_user_cart($this->session->userdata('guest_user_id'), 0, '', 1)) != 0 ? count($this->cart_model->get_user_cart($this->session->userdata('guest_user_id'), 0, '', 1)) : '0'); ?>
                                            <?php } ?>
                                        </span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php if($this->router->fetch_class()=="home" && $this->router->fetch_method()=="index") { ?>
                <div class="searchmain">
                    <form class="search" action="<?php echo base_url('products/search'); ?>" method="get">
                        <div>
                            <input class="form-field search-input" type="text" name="q" placeholder="Search for product">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass  searchbox "></i></button>
                        </div>
                        <div id="search-list" class="d-none"></div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click", ".marketplace", function() {
        var categories = <?php echo json_encode($categories); ?>;
        var level1 = '';
        var level2 = '';
        var level3 = '';
        var html = '<div class="col-12 row">';
        level1 += '<div class="col-4 mb-2 mb-lg-0 cat-level-1">';
        level1 += '<ul>';
        $.each(categories, function(i) {
            level1 += '<li data-cat1slug="'+categories[i].slug+'" class="l1-menu"><a class="dropdown-item" href="'+base_url+'products/category/'+categories[i].slug+'">'+categories[i].name+' <i class="fa fa-angle-right arrow-level-1"></i></a></li>';
            level2 += '<div id="'+categories[i].slug+'" class="col-4 mb-2 mb-lg-0 cat-level-2 d-none">';
            if(categories[i]['children'].length > 0) {
                level2 += '<ul>';
                $.each(categories[i]['children'], function(j) {
                    level2 += '<li data-cat2slug="'+categories[i]['children'][j].slug+'" class="l2-menu"><a class="dropdown-item" href="'+base_url+'products/category/'+categories[i]['children'][j].slug+'">'+categories[i]['children'][j].name+' <i class="fa fa-angle-right arrow-level-2"></i></a></li>';
                    level3 += '<div id="'+categories[i]['children'][j].slug+'" class="col-4 mb-2 mb-lg-0 cat-level-3 d-none">';
                    if(categories[i]['children'][j]['children'].length > 0) {
                        level3 += '<ul>';
                        $.each(categories[i]['children'][j]['children'], function(k) {
                            level3 += '<li class="l3-menu"><a class="dropdown-item" href="'+base_url+'products/category/'+categories[i]['children'][j]['children'][k].slug+'">'+categories[i]['children'][j]['children'][k].name+'</a></li>';
                        });
                        level3 += '</ul>';
                    }
                    level3 += '</div>';
                });
                level2 += '</ul>';
            }
            level2 += '</div>';
        });
        level1 += '</ul>';
        level1 += '</div>';
        html += level1 + level2 + level3;
        html += '</div>';
        $(this).closest('.marketplace-menu').find('.category-menu .row').html(html);
    });
    $(document).on("mouseover", ".l1-menu", function() {
        var cat1slug = $(this).data('cat1slug');
        $('.cat-level-2').addClass('d-none');
        $('.cat-level-3').addClass('d-none');
        $('#'+cat1slug).removeClass('d-none');
    });
    $(document).on("mouseover", ".l2-menu", function() {
        var cat2slug = $(this).data('cat2slug');
        $('.cat-level-3').addClass('d-none');
        $('#'+cat2slug).removeClass('d-none');
    });
</script>
<?php /*
<div class='block-div' onclick="closeNav()"></div>
<header id="header" class="topper-white header-varient">
    <div class="topbar topbar-text-color">
        <div class="main-content">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="topbar-left text-lg-left text-center">
                        <ul class="list-inline">
                            <?php if (isset($web_settings['support_number']) && !empty($web_settings['support_number'])) { ?>
                                <li><a href="tel:<?= $web_settings['support_number'] ?>"><i class="fa fa-phone-alt"></i> <?= $web_settings['support_number'] ?></a></li>
                            <?php } ?>
                            <?php if (isset($web_settings['support_email']) && !empty($web_settings['support_email'])) { ?>
                                <li><a href="mailto:<?= $web_settings['support_email'] ?>"> <i class="fa fa-envelope"></i> <?= $web_settings['support_email'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="topbar-right text-lg-right">
                        <ul class="list-inline">
                            <?php if (isset($web_settings['facebook_link']) &&  !empty($web_settings['facebook_link'])) { ?>
                                <li><a href="<?= $web_settings['facebook_link'] ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <?php } ?>
                            <?php if (isset($web_settings['twitter_link']) && !empty($web_settings['twitter_link'])) { ?>
                                <li><a href="<?= $web_settings['twitter_link'] ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <?php } ?>
                            <?php if (isset($web_settings['instagram_link']) &&  !empty($web_settings['instagram_link'])) { ?>
                                <li><a href="<?= $web_settings['instagram_link'] ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <?php } ?>
                            <?php if (isset($web_settings['youtube_link']) &&  !empty($web_settings['youtube_link'])) { ?>
                                <li><a href="<?= $web_settings['youtube_link'] ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <?php } ?>
                            <li><a href="<?= base_url('home/contact-us') ?>" class="hide-sec"><?= !empty($this->lang->line('contact_us')) ? $this->lang->line('contact_us') : 'CONTACT US' ?></a></li>
                            <li><a href="<?= base_url('home/faq') ?>" class="hide-sec"><?= !empty($this->lang->line('faq')) ? $this->lang->line('faq') : 'FAQs' ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white main-content">
        <button class="navbar-toggler border-0" type="button" onclick="openNav()">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php $logo = get_settings('web_logo'); ?>
        <a class="navbar-brand" href="<?= base_url() ?>"><img src="<?= base_url($logo) ?>" data-src="<?= base_url($logo) ?>" class="brand-logo-link"></a>
        <?php $page = $this->uri->segment(2) == 'checkout' ? 'checkout' : '' ?>
        <?php if ($page == 'checkout') { ?>
            <a class="shopping-cart-sidebar-btn d-none" href="<?= base_url('cart') ?>">
                <i class="fa-cart fa-cart-plus fas link-color"></i>
            </a>

        <?php } else { ?>
            <a class="shopping-cart-sidebar-btn d-none" href="#" onclick="openCartSidebar()">
                <i class="fa-cart fa-cart-plus fas link-color"></i>
            </a>
        <?php } ?>

        <div class="navbar-collapse collapse" id="navbarNavDropdown">
            <div class="col-md-6">
                <form class="mt-2 w-100">
                    <div class="input-group md-form form-sm form-2 pl-0 h-50 mx-auto navbar-top-search-box">
                        <!-- <input > -->
                        <select class="form-control my-0 py-1 p-2 rounded-0 search_product" type="text" aria-label="Search"></select>
                    </div>
                </form>
            </div>
            <div class="col-md-6 d-flex justify-content-end px-0">
                <div class="navbar-nav">
                    <li class="nav-item dropdown active">
                        <a class="m-1" data-toggle="dropdown" href="#">
                            <?php if ($cookie_lang) { ?>
                                <span class="text-dark font-weight-bold"><?= ucfirst($language[$language_index]['code']) ?></span>
                            <?php } else { ?>
                                <span class="text-dark font-weight-bold">En</span>
                            <?php } ?>
                            <i class="fas fa-angle-down link-color"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg">
                            <?php foreach ($language as $row) { ?>
                                <a href="<?= base_url('home/lang/' . strtolower($row['language'])) ?>" class="dropdown-item"><?= strtoupper($row['code']) . ' - ' . ucfirst($row['language']) ?></a>
                            <?php } ?>
                        </div>
                    </li>
                    <?php if ($this->ion_auth->logged_in()) { ?>
                        <li class="nav-item dropdown active">
                            <a class="m-1" data-toggle="dropdown" href="#"><i class="fas fa-user fa-lg link-color"></i>
                                <span class="text-dark font-weight-bold"> <?= (isset($user->username) && !empty($user->username)) ? "Hello " . $user->username  : 'Login / Register' ?></span>
                                <i class="fas fa-angle-down link-color"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg">
                                <a href="<?= base_url('my-account/wallet') ?>" class="dropdown-item"><i class="fas fa-wallet mr-2 text-primary link-color"></i> <?= $settings['currency'] . ' ' . number_format($user->balance, 2) ?></a>
                                <a href="<?= base_url('my-account') ?>" class="dropdown-item"><i class="fas fa-user mr-2 text-primary link-color"></i> <?= !empty($this->lang->line('profile')) ? $this->lang->line('profile') : 'Profile' ?> </a>
                                <a href="<?= base_url('my-account/orders') ?>" class="dropdown-item"><i class="fas fa-history mr-2 text-primary link-color"></i> <?= !empty($this->lang->line('orders')) ? $this->lang->line('orders') : 'Orders' ?> </a>
                                <a href="<?= base_url('login/logout') ?>" class="dropdown-item"><i class="fa fa-sign-out-alt mr-2 text-primary link-color"></i><?= !empty($this->lang->line('logout')) ? $this->lang->line('logout') : 'Logout' ?></a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item active"><a href="" class="m-2 auth_model" data-izimodal-open=".auth-modal" data-value="login"><span class="text-dark font-weight-bold"><?= !empty($this->lang->line('login')) ? $this->lang->line('login') : 'Login' ?></a></li>/
                        <li class="nav-item active"><a href="" class="m-2 auth_model" data-izimodal-open=".auth-modal" data-value="register"><span class="text-dark font-weight-bold"><?= !empty($this->lang->line('register')) ? $this->lang->line('register') : 'Register' ?></a></li>
                        <li class="nav-item active"><a href="<?= base_url('seller/login') ?>" class="m-2" data-value="login-as-seller"><span class="text-dark font-weight-bold"><?= !empty($this->lang->line('login')) ? $this->lang->line('login') : 'Login' ?></a></li> /
                        <?php /* <li class="nav-item active"><a href="<?= base_url('seller/auth/sign_up') ?>" class="m-2" data-value="register-as-seller"><span class="text-dark font-weight-bold"><?= !empty($this->lang->line('register_as_seller')) ? $this->lang->line('register_as_seller') : 'Register as seller' ?></a></li> * / ?>
                        <li class="nav-item active"><a href="" class="m-2 auth_model" data-izimodal-open=".auth-modal" data-value="register-as-seller"><span class="text-dark font-weight-bold"><?= !empty($this->lang->line('register_as_seller')) ? $this->lang->line('register_as_seller') : 'Register as seller' ?></a></li>
                    <?php } ?>
                    <li class="nav-item active">
                        <a href="<?= base_url('my-account/favorites') ?>" class="p-2 header-icon">
                            <i class="far fa-heart fa-lg link-color"></i>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="<?= base_url('compare') ?>" class="p-2 header-icon" onclick=display_compare() data-product-id="<?= ($row['id']) != 0 ? $row['id'] : '' ?>">
                            <i class="fa-random fa-random-plus fa-lg fas link-color"></i>
                            <span class="badge badge-danger badge-sm" id='compare_count'></span>
                        </a>
                    </li>
                    <?php $page = $this->uri->segment(2) == 'checkout' ? 'checkout' : '' ?>
                    <?php if ($page == 'checkout') { ?>
                        <li class="nav-item active">
                            <a href="<?= base_url('cart') ?>" class="p-2 header-icon">
                                <i class="fa-cart fa-cart-plus fa-lg fas link-color"></i>
                                <span class="badge badge-danger badge-sm" id='cart-count'><?= (count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) != 0 ? count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) : ''); ?></span>
                            </a>
                        </li>

                    <?php } else { ?>
                        <li class="nav-item active">
                            <a href="javascript:void(0);" class="p-2 header-icon" onclick=openCartSidebar()>
                                <i class="fa-cart fa-cart-plus fa-lg fas link-color"></i>
                                <span class="badge badge-danger badge-sm" id='cart-count'><?= (count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) != 0 ? count($this->cart_model->get_user_cart($this->session->userdata('user_id'))) : ''); ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <div class="header-bottom">
        <div class="main-content">
            <div class="row header-bottom-inner mx-0">
                <div class="column col-left">
                    <div class="header-categories-nav <?= (current_url() == base_url() || current_url() == base_url('home')) ? 'show-menu' : 'show-menu' ?>">
                        <div class="header-categories-nav-wrap">
                            <span class="menu-opener">
                                <span class="burger-menu"><i class="fas fa-bars"></i></span>
                                <span class="menu-label"><?= !empty($this->lang->line('category')) ? $this->lang->line('category') : 'Browse Categories' ?></span>
                                <span class="arrow-hover"> <i class="fas fa-angle-down"></i></span>
                            </span>
                            <div class="categories-menu-dropdown vertical-navigation">
                                <div class="menu-categorie-container">
                                    <ul class="nav vertical-nav menu">
                                        <?php
                                        foreach ($categories as $row) { ?>
                                            <a href="<?= base_url('products/category/' . $row['slug']) ?>">
                                                <li class="category-span"><img class="svg-icon-image lazy" data-src="<?= $row['image'] ?>" />
                                                    <span class="category-line-height"><?= $row['name'] ?></span>
                                                </li>
                                            </a>
                                        <?php } ?>
                                        <a href="<?= base_url('home/categories') ?>">
                                            <li class="see-all-category">
                                                <?= !empty($this->lang->line('see_all')) ? $this->lang->line('see_all') : 'See All' ?>
                                            </li>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column col-center">
                    <div class="main-nav menu-left">
                        <div class="menu-main-navigation-container">
                            <div class="cd-morph-dropdown cd-dp">
                                <a href="#0" class="nav-trigger"><?= !empty($this->lang->line('open_nav')) ? $this->lang->line('open_nav') : 'Open Nav' ?><span aria-hidden="true"></span></a>
                                <nav class="main-nav">
                                    <ul>
                                        <li class="morph-text">
                                            <a href="<?= base_url() ?>"><?= !empty($this->lang->line('home')) ? $this->lang->line('home') : 'Home' ?></a>
                                        </li>
                                        <li class="morph-text">
                                            <a href="<?= base_url('products') ?>"><?= !empty($this->lang->line('products')) ? $this->lang->line('products') : 'Products' ?></a>
                                        </li>
                                        <li class="morph-text">
                                            <a href="<?= base_url('sellers') ?>"><?= !empty($this->lang->line('sellers')) ? $this->lang->line('sellers') : 'Sellers' ?></a>
                                        </li>
                                        <li class="morph-text">
                                            <a href="<?= base_url('home/contact-us') ?>"><?= !empty($this->lang->line('contact_us')) ? $this->lang->line('contact_us') : 'Contact Us' ?></a>
                                        </li>
                                        <li class="morph-text">
                                            <a href="<?= base_url('home/about-us') ?>"><?= !empty($this->lang->line('about_us')) ? $this->lang->line('about_us') : 'About Us' ?></a>
                                        </li>
                                        <li class="morph-text">
                                            <a href="<?= base_url('home/faq') ?>"><?= !empty($this->lang->line('faq')) ? $this->lang->line('faq') : 'FAQs' ?></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> */ ?>
<!-- header ends -->