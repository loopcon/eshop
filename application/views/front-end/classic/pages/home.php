<!-- Categories start  -->
<div class="container">
    <section class="category-head-section">
        <div class="catbg">
            <h2 class="mhead"> Categories </h2>
        </div>
    </section>
    <section class="category-list-section">
        <div class="row p-2">
            <?php foreach ($homepage_settings['categories'] as $row) { ?>
                <div class="col-2">
                    <a href="<?= base_url('products/category/' . $row['slug']) ?>">
                        <img class="img-fluid  cimg" src="<?= $row['image'] ?>" alt="">
                        <p class="cname"> <?= $row['name'] ?></p>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
</div>
<!-- Categories end  -->

<!-- Makeup start  -->
<div class="bgmain">
    <div class="container">
        <section>
            <div>
                <h2 class="mhead"><?php echo !empty($homepage_settings['main_category_1']) ? $homepage_settings['main_category_1']['name'] : ''; ?></h2>
            </div>
        </section>
        <section>
            <div class="row category-main-sub">
                <?php if(!empty($homepage_settings['main_category_1'])) { ?>
                    <div class="col-3 p-2">
                        <div class="makeupmain">
                            <a href="<?= base_url('products/category/' . $homepage_settings['main_category_1']['slug']) ?>">
                                <img class="img-fluid" src="<?php echo base_url($homepage_settings['main_category_1']['image']); ?>" alt="">
                                <h3 class="text-center"><?php echo $homepage_settings['main_category_1']['name']; ?></h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <?php
                                $i = 0;
                                $j = 0;
                                foreach($homepage_settings['sub_categories_1'] as $sub_categories_1) {
                            ?>
                            <div class="col-3">
                                <div class="makebox">
                                    <a href="<?= base_url('products/category/' . $sub_categories_1['slug']) ?>">
                                        <img src="<?php echo base_url($sub_categories_1['image']); ?>" class="img-fluid">
                                        <h4 class="maktitle"><?php echo $sub_categories_1['name']; ?></h4>
                                    </a>
                                </div>
                            </div>
                            <?php
                                    $i++;
                                    $j++;
                                    if($i==4) {
                                        if(count($homepage_settings['sub_categories_1']) > $j) {
                                            $i = 0;
                                            echo '</div><div class="row">';
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>
</div>
<div class="container">
    <section>
        <div>
            <h2 class="mhead"><?php echo !empty($homepage_settings['main_category_2']) ? $homepage_settings['main_category_2']['name'] : ''; ?></h2>
        </div>
    </section>
    <section>
        <div class="row category-main-sub">
            <?php if(!empty($homepage_settings['main_category_2'])) { ?>
                <div class="col-3 p-2">
                    <div class="makeupmain">
                        <a href="<?= base_url('products/category/' . $homepage_settings['main_category_2']['slug']) ?>">
                            <img class="img-fluid" src="<?php echo base_url($homepage_settings['main_category_2']['image']); ?>" alt="">
                            <h3 class="text-center"><?php echo $homepage_settings['main_category_2']['name']; ?></h3>
                        </a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="row">
                        <?php
                            $i = 0;
                            $j = 0;
                            foreach($homepage_settings['sub_categories_2'] as $sub_categories_2) {
                        ?>
                        <div class="col-3">
                            <div class="makebox">
                                <a href="<?= base_url('products/category/' . $sub_categories_2['slug']) ?>">
                                    <img src="<?php echo base_url($sub_categories_2['image']); ?>" class="img-fluid">
                                    <h4 class="maktitle"><?php echo $sub_categories_2['name']; ?></h4>
                                </a>
                            </div>
                        </div>
                        <?php
                                $i++;
                                $j++;
                                if($i==4) {
                                    if(count($homepage_settings['sub_categories_2']) > $j) {
                                        $i = 0;
                                        echo '</div><div class="row">';
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</div>

<!-- discount  start  -->
<div class="bgmain discounts">
    <div class="container">
        <div>
            <h2 class="mhead">Discount</h2>
        </div>
        <section>
            <div class="row">
                <?php foreach($offers as $offer) { ?>
                    <div class="col-4 ">
                        <div class="makebox">
                            <img class="img-fluid" src="<?= base_url($offer['image']); ?>">
                            <p class="distext"><?= $offer['text']; ?></p>
                            <div class="d-flex justify-content-center">
                                <button class="disbtn"> See more</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>
</div>

<section class="common">
    <div class="container">
        <div class="row">
            <?php foreach($banners as $banner) { ?>
                <div class="col-6">
                    <img src="<?= $banner['image']; ?>" class="img-fluid">
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- top sell start   -->
<div class="bgmain">
    <div class="container">
        <h2 class="p-3"> Top sell Products</h2>
    </div>
    <div class="container">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div>
                        <div class="d-flex justify-content-center">
                            <img src="img/slide1.png" class="'img-fluid topimg">
                        </div>
                        <p>RJ kitchenware Store Container Jar Set Airtight Container Jar Set For Kitchen - 900ml Set Of 6, Jar Set For itchen, Kitchen Organizer Container Set Items, Organizer Container Set Items, Air</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div>
                        <div class="d-flex justify-content-center">
                            <img src="img/slide2.png" class="'img-fluid topimg">
                        </div>
                        <p class="text-center"> iphone </p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div>
                        <div class="d-flex justify-content-center">
                            <img src="img/slide3.png" class="'img-fluid topimg">
                        </div>
                        <p> 2 in 1Pump Plastic Dispenser for Dishwasher Liquid Holder </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- top sell end   -->

<!-- top brand start  -->
<section>
    <div class="container">
        <h2 class="mhead"> Top brands</h2>
    </div>
    <div class="container">
        <div class="row">
            <?php foreach($brands as $brand) { ?>
                <div class="col-2">
                    <img src="<?= base_url($brand['image']); ?>" class="img-fluid topbrandicon">
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- top brand end  -->

<!-- subscribe start  -->
<div class="bgmain">
    <div class="container">
        <div class="p-4">
            <div>
                <h1 class="subhead">Subscribe our newsletter</h1>
            </div>
            <div class="d-flex justify-content-center">
                <div class="form">
                    <form name="subscription-form" id="subscription-form" action="<?=base_url("home/save_subscription")?>">
                        <input type="email" class="form__email" name="email_subscription" placeholder="Enter your email address" />
                        <button type="submit" class="form__button" id="send-subscription">Send</button>
                        <span id="send-subscription-result"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- subscribe end  -->

<script src="<?=base_url("assets/admin/js/swiper-bundle.min.js");?>"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        slidesPerGroup: 3,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        }, navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>