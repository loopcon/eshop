<?php $web_settings = get_settings('web_settings', true); ?>
<!-- footer start -->
<section class="footer-section footer-saperator pt-5">
    <div class="container container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="d-flex justify-content-center ">
                    <?php $logo = get_settings('web_logo'); ?>
                    <img src="<?= base_url($logo) ?>" class="img-fluid footerlogo">
                </div>
            </div>
            <div class="col-9">
                <div class="row footermain">
                    <div class="col-3">
                        <h5>GET TO KNOW US</h5>
                        <li><a href="<?= base_url('home/contact-us') ?>"><?= !empty($this->lang->line('contact_us')) ? $this->lang->line('contact_us') : 'Contact Us' ?></a></li>
                        <li><a href="<?= base_url('home/about-us') ?>"><?= !empty($this->lang->line('about_us')) ? $this->lang->line('about_us') : 'About Us' ?></a></li>
                    </div>
                    <div class="col-3">
                        <h5>POLICY</h5>
                        <li><a href="<?= base_url('home/return-policy') ?>"><?= !empty($this->lang->line('return_policy')) ? $this->lang->line('return_policy') : 'Return Policy' ?></a></li>
                        <li><a href="<?= base_url('home/terms-and-conditions') ?>"><?= !empty($this->lang->line('terms_and_condition')) ? $this->lang->line('terms_and_condition') : 'Terms of Use' ?></a></li>
                        <li><a href="<?= base_url('home/privacy-policy') ?>"><?= !empty($this->lang->line('privacy_policy')) ? $this->lang->line('privacy_policy') : 'Privacy Policy' ?></a></li>
                        <?php /* <li><a href="">Sitemap</a></li> */ ?>
                    </div>
                    <div class="col-2">
                        <h5>HELP</h5>
                        <li><a href="<?= base_url('home/shipping-policy') ?>"><?= !empty($this->lang->line('shipping_policy')) ? $this->lang->line('shipping_policy') : 'Shipping' ?></a></li>
                        <?php /* <li><a href=""><?= !empty($this->lang->line('faq')) ? $this->lang->line('faq') : 'FAQ' ?></a></li> */ ?>
                    </div>
                    <div class="col-4">
                        <li><img src="<?= THEME_ASSETS_URL.'images/fastdelivery.png';?>"> <a>Fast Delivery & Shipping</a></li>
                        <li><img src="<?= THEME_ASSETS_URL.'images/topoffer.png';?>"> <a>Top Offers</a></li>
                        <li><img src="<?= THEME_ASSETS_URL.'images/moneycash.png';?>"> <a>Money Cashback</a></li>
                        <li><img src="<?= THEME_ASSETS_URL.'images/friendly.png';?>"> <a>Friendly Support 24/7</a></li>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-2">
                            <img class="img-fluid " src="<?= THEME_ASSETS_URL.'images/paypal.png';?>">
                        </div>
                        <div class="col-2">
                            <img class="img-fluid " src="<?= THEME_ASSETS_URL.'images/mastercard.png';?>">
                        </div>
                        <div class="col-2">
                            <img class="img-fluid paymenticon" src="<?= THEME_ASSETS_URL.'images/visa.png';?>">
                        </div>
                        <div class="col-2">
                            <img class="img-fluid paymenticon" src="<?= THEME_ASSETS_URL.'images/skrill.png';?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php /* <!-- Category List - Start -->
    <div class="p-4">
        <div class="container container-fluid">
            <?php $categories = get_categories(); ?>
            <?php foreach($categories as $category_level_1) { ?>
                <div class="row footer-cat-link">
                    <div class="col-2">
                        <p><strong><a href="<?=base_url('products/category/' . $category_level_1['slug']) ?>"><?=$category_level_1['name']?></a> :-</strong></p>
                    </div>
                    <div class="col-10">
                        <p>
                            <?php
                                $level_2 = [];
                                $count_level_2 = 0;
                                foreach($category_level_1['children'] as $category_level_2) {
                                    echo "<a href='".base_url('products/category/' . $category_level_2['slug'])."'>".stripslashes($category_level_2['name'])."</a>";
                                    $count_level_2++;
                                    if($count_level_2 < count($category_level_1['children'])) {
                                        echo ", ";
                                    }
                                    $count_level_3 = 0;
                                    foreach($category_level_2['children'] as $category_level_3) {
                                        echo "<a href='".base_url('products/category/' . $category_level_3['slug'])."'>".stripslashes($category_level_3['name'])."</a>";
                                        $count_level_3++;
                                        if($count_level_3 < count($category_level_2['children'])) {
                                            echo ", ";
                                        }
                                    }
                                }
                            ?>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Category List - End --> */ ?>
</section>
<!-- detail end  -->
<?php if (ALLOW_MODIFICATION == 0) { ?>
    <!-- color switcher -->
    <div id="colors-switcher">
        <h6><?= !empty($this->lang->line('pick_your_favorite_color')) ? $this->lang->line('pick_your_favorite_color') : 'Pick Your Favorite Color' ?></h6>
        <ul class="color-style text-center mb-2">
            <li class="list-item-inline">
                <a href="#" class="peach"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="default"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="yellow"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="green"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="purple"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="red"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="dark-blue"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="orange"></a>
            </li>
            <li class="list-item-inline">
                <a href="#" class="cyan-dark"></a>
            </li>
        </ul>
        <div class="color-bottom">
            <a href="#" class="settings bg-white d-block"><i class="fa fa-cog fa-lg fa-spin setting-icon"></i></a>
        </div>
    </div> <!-- end color switcher -->
<?php } ?>

<div id="modal-custom" class="auth-modal" data-iziModal-group="group1">
    <button data-iziModal-close class="icon-close">x</button>
    <header>
        <a href="" id="login"><?= !empty($this->lang->line('login')) ? $this->lang->line('login') : 'Login' ?></a>
        <a href="" id="register"><?= !empty($this->lang->line('register')) ? $this->lang->line('register') : 'Register' ?></a>
        <?php /* <a href="" id="login-as-seller"><?= !empty($this->lang->line('login_as_seller')) ? $this->lang->line('login_as_seller') : 'Login as seller' ?></a> */ ?>
        <a href="" id="register-as-seller"><?= !empty($this->lang->line('register_as_seller')) ? $this->lang->line('register_as_seller') : 'Register as seller' ?></a>
    </header>
    <section class="hide" id="login_div">
        <form action="<?= base_url('home/login') ?>" class='form-submit-event' id="login_form" method="post">
            <div class="input-group">
                <input type="email" class="form-control" name="identity" placeholder="Email" value="" required>
            </div>
            <div class="input-group">
                <input type="password" class="form-control" name="password" placeholder="Password" value="" required>
            </div>
            <div class="mb-4 text-right">
                <a href="<?= base_url() ?>" id="forgot_password_link"><?= !empty($this->lang->line('forgot_password')) ? $this->lang->line('forgot_password') : 'Forgot Password' ?> ?</a>
            </div>
            <footer>
                <button type="button" data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button type="submit" class="submit_btn  btn btn-primary btn-block"><?= !empty($this->lang->line('login')) ? $this->lang->line('login') : 'Login' ?></button>
            </footer>
            <br>
            <div class="d-flex justify-content-center">
                <div class="form-group" id="error_box"></div>
            </div>
        </form>
    </section>
    <section class="hide" id="register_div">
        <?php /* <form id='send-otp-form' class='send-otp-form' action='#'>
            <div class="row sign-up-verify-number">
                <div class="col-12 d-flex justify-content-center pb-4">
                    <input type="text" class='form-input' placeholder="Enter Mobile Number" id="phone-number" required>
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <div id="error-msg" class="hide text-danger"><?= !empty($this->lang->line('enter_valid_number')) ? $this->lang->line('enter_valid_number') : 'Enter a valid number' ?></div>
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <div id="recaptcha-container"></div>
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <div id='is-user-exist-error' class='text-center p-3 text-danger'></div>
                </div>
            </div>
            <footer>
                <button type="button" data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button id='send-otp-button'><?= !empty($this->lang->line('send_otp')) ? $this->lang->line('send_otp') : 'Send OTP' ?></button>
            </footer>
        </form> */ ?>
        <form id='register-form' class='verify-otp-form' action='<?= base_url('auth/register-user') ?>' method="POST">
            <div class="row sign-up-verify-number">
                <?php /* <div class="col-12 d-flex justify-content-center pb-4">
                    <input type="text" class='form-input' placeholder="Enter Mobile Number" id="phone-number" required>
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <input type="text" class='form-input' placeholder="OTP" id="otp" name="otp" autocomplete="off">
                </div> */ ?>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <input type="text" class='form-input' maxlength="40" placeholder="Username" id="name" name="name">
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <input type="email" class='form-input' placeholder="Email" id="email" name="email">
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <input type="password" class='form-input' placeholder="Password" id="password" name="password">
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <input type="password" class='form-input' placeholder="Confirm Password" id="confirm password" name="confirm password">
                </div>
                <div class="col-12 d-flex justify-content-center pb-4">
                    <div id='registration-error' class='text-center p-3 text-danger'></div>
                </div>
            </div>
            <footer>
                <button data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button type="submit" id='register_submit_btn'><?= !empty($this->lang->line('submit')) ? $this->lang->line('submit') : 'Submit' ?></button>
            </footer>
        </form>
        <form id='sign-up-form' class='sign-up-form collapse' action='#'>
            <input type="text" placeholder="Username" name='username' class='form-input' required>
            <input type="text" placeholder="email" name='email' class='form-input' required>
            <input type="password" placeholder="Password" name='password' class='form-input' required>
            <div id='sign-up-error' class='text-center p-3'></div>
            <footer>
                <button type="button" data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button type='submit'><?= !empty($this->lang->line('register')) ? $this->lang->line('register') : 'Register' ?></button>
            </footer>
        </form>
    </section>
    <section class="hide pt-0" id="forgot_password_div">
        <div class="text-center h5"><?= !empty($this->lang->line('forgot_password')) ? $this->lang->line('forgot_password') : 'Forgot Password' ?></div>
        <hr class="mt-0">
        <form id="forgot_password_form" method="POST" action="#">
            <div class="input-group">
                <input type="text" class="form-control" name="email" id="forgot_password_email" placeholder="Email" value="">
            </div>
            <?php /* <div class="col-12 d-flex justify-content-center pb-4 mt-3">
                <div id="recaptcha-container-2"></div>
            </div> */ ?>
            <footer>
                <button type="button" data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button type="submit" id="forgot_password_submit_btn" class="submit_btn  btn btn-primary btn-block"><?= !empty($this->lang->line('submit')) ? $this->lang->line('submit') : 'Submit' ?></button>
            </footer>
            <br>
            <div class="d-flex justify-content-center">
                <div class="form-group" id="forgot_pass_error_box"></div>
            </div>
        </form>
        <form id="forgot_password_new_password_form" class="d-none" method="post" action="#">
            <?php /* <div class="input-group">
                <input type="text" id="forgot_password_otp" class="form-control" name="otp" placeholder="OTP" value="" autocomplete="off" required>
            </div> */ ?>
            <div class="input-group">
                <input type="password" class="form-control" name="new_password" placeholder="New Password" value="" required>
            </div>
            <footer>
                <button type="button" data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button type="submit" class="submit_btn  btn btn-primary btn-block" id="reset_password_submit_btn"><?= !empty($this->lang->line('submit')) ? $this->lang->line('submit') : 'Submit' ?></button>
            </footer>
            <br>
            <div class="d-flex justify-content-center">
                <div class="form-group" id="set_password_error_box"></div>
            </div>
        </form>
    </section>
    <section class="hide" id="register_as_seller_div">
        <form id='register-as-seller-form' class='register-seller-form' action='<?= base_url('auth/register-seller') ?>' method="POST">
            <div class="row seller-signup">
                <div class="col-12 d-flex justify-content-center">
                    <input type="text" class='form-input' maxlength="40" placeholder="Business Name" id="store_name" name="store_name">
                    <?php echo form_error('store_name', '<div class="error">', '</div>'); ?>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="text" class='form-input' maxlength="40" placeholder="First Name" id="first_name" name="first_name">
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="text" class='form-input' maxlength="40" placeholder="Last Name" id="last_name" name="last_name">
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="email" class='form-input' placeholder="Email" id="seller_email" name="email">
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="text" class='form-input' placeholder="Mobile" id="seller_mobile" maxlength="12"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="mobile">
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input type="text" class='form-input' placeholder="Address Line" id="address" name="address">
                </div>
                <div class="col-6 justify-content-center">
                    <?php $countries = fetch_details("countries", NULL, 'id, name, iso3, iso2'); ?>
                    <select class='form-input w-100' name="country" id="country">
                        <option value="">Select country</option>
                        <?php foreach($countries as $country) { ?>
                            <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-6 d-flex justify-content-center">
<<<<<<< HEAD
                    <input type="text" class='form-input' maxlength="30" placeholder="City" id="city" name="city">
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="text" class='form-input' placeholder="State" maxlength="30" id="state" name="state">
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="text" class='form-input' maxlength="6"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Postal / Zip code" id="zipcode" name="zipcode">
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="text" class='form-input' maxlength="30" placeholder="Country" id="country" name="country">
=======
                    <select class='form-input w-100' name="state" id="state">
                        <option value="">Select state</option>
                    </select>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <select class='form-input w-100' name="city" id="city">
                        <option value="">Select city</option>
                    </select>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <select class='form-input w-100' name="area" id="area">
                        <option value="">Select area</option>
                    </select>
                </div>
                <div class="col-6 d-flex justify-content-center">
                    <input type="text" class='form-input' placeholder="Postal / Zip code" id="zipcode" name="zipcode">
>>>>>>> 3c305cb074cf4066206b969cea3b2bf27c24f177
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input type="password" class='form-input' placeholder="Password" id="seller_password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" name="password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input type="password" class='form-input' placeholder="Retype password" id="seller_confirm_password" name="confirm_password">
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input type="checkbox" class="form-input" name="agree_terms" id="agree_terms">&nbsp;<span> I agree to the <a href="<?= base_url('home/terms-and-conditions') ?>">terms</a></span>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div id='seller-registration-error' class='text-center p-3 text-danger'></div>
                </div>
            </div>
            <footer>
                <button type="button" data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button type="submit" id="register_seller_submit_btn"><?= !empty($this->lang->line('submit')) ? $this->lang->line('submit') : 'Register' ?></button>
            </footer>
        </form>
    </section>
    <section class="hide" id="login_as_seller_div">
        <form action="<?= base_url('home/login-seller') ?>" class='seller-login-form-submit-event' id="login_form" method="post">
            <div class="input-group">
                <input type="email" class="form-control" name="identity" placeholder="Email" value="" required>
            </div>
            <div class="input-group">
                <input type="password" class="form-control" name="password" placeholder="Password" value="" required>
            </div>
            <div class="mb-4 text-right">
                <a href="<?= base_url() ?>" id="forgot_password_link"><?= !empty($this->lang->line('forgot_password')) ? $this->lang->line('forgot_password') : 'Forgot Password' ?> ?</a>
            </div>
            <footer>
                <button type="button" data-iziModal-close><?= !empty($this->lang->line('cancel')) ? $this->lang->line('cancel') : 'Cancel' ?></button>
                <button type="submit" class="submit_btn  btn btn-primary btn-block"><?= !empty($this->lang->line('login')) ? $this->lang->line('login') : 'Login' ?></button>
            </footer>
            <br>
            <div class="d-flex justify-content-center">
                <div class="form-group" id="error_box"></div>
            </div>
        </form>
    </section>
</div>
<!-- quick view -->
<div id="quick-view" data-iziModal-group="grupo3" class='product-page-content'>
    <button data-iziModal-close class="icon-close">x</button>
    <div class="row p-4">
        <div class="col-12 col-sm-6 product-preview-image-section-md">
            <div class="swiper-container gallery-top">
                <div class="swiper-wrapper"></div>
                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-black"></div>
                <div class="swiper-button-prev swiper-button-black"></div>
            </div>
            <div class="swiper-container gallery-thumbs">
                <div class="swiper-wrapper" id="gal1"></div>
            </div>
        </div>
        <!-- Mobile Product Image Slider -->
        <div class="col-12 col-sm-6 product-preview-image-section-sm">
            <div class=" swiper-container mobile-image-swiper">
                <div class="swiper-wrapper"></div>
                <div class="swiper-pagination mobile-image-swiper-pagination text-center"></div>
            </div>
        </div>
        <div class="col-12 col-sm-6 product-page-details">
            <h3 class="my-3 product-title" id="modal-product-title"></h3>
            <div id="modal-product-sellers">
            </div>
            <hr>
            <p id="modal-product-short-description"></p>
            <hr class="mb-0">
            <div class="mb-3 product-rating-small">
                <input type="text" class="kv-fa rating rating-loading" id="modal-product-rating" value="0" data-show-caption="false" data-size="sm" data-show-clear="false" title="" readonly>
                (<span class="rating-status" id="modal-product-no-of-ratings">1203</span> <?= !empty($this->lang->line('reviews')) ? $this->lang->line('reviews') : 'reviews' ?> )
            </div>
            <p class="mb-0 price">
                <span id="modal-product-price"></span>
                <sup>
                    <span class="striped-price text-danger" id="modal-product-special-price-div">
                        <s id="modal-product-special-price"></s>
                    </span>
                </sup>
            </p>
            <div id="modal-product-variant-attributes"></div>
            <div id="modal-product-variants-div"></div>
            <div class="num-block skin-2 py-2 pt-4 pb-4">
                <div class="num-in">
                    <span class="minus dis"></span>
                    <input type="text" class="in-num" id="modal-product-quantity">
                    <span class="plus"></span>
                </div>
            </div>
            <div class="pt-4 pb-4 text-center text-md-left">
                <div class="button button-sm m-0 p-0">
                    <button type="button" name="compare" class="buttons btn-6-6 extra-small m-0 compare" id="compare"><i class="fa fa-random"></i> <?= !empty($this->lang->line('compare')) ? $this->lang->line('compare') : 'Compare' ?></button>
                </div>
                <div class="button button-sm m-0 p-0">
                    <button class="buttons primary-button m-0 add_to_cart" id="modal-add-to-cart-button"><i class="fas fa-cart-plus"></i> <?= !empty($this->lang->line('add_to_cart')) ? $this->lang->line('add_to_cart') : 'Add To Cart' ?></button>
                </div>
                <div class="button button-sm m-0 p-0">
                    <button class="buttons red-button m-0" id="add_to_favorite_btn"><i class="far fa-heart"></i> <span><?= !empty($this->lang->line('add_to_favorite')) ? $this->lang->line('add_to_favorite') : 'Add to Favorite' ?></span></button>
                </div>
            </div>

            <div class="mt-2">
                <div id="modal-product-tags"></div>

                </span>
            </div>
        </div>
    </div>
</div>

<!-- footer end  -->
<!-- main content ends -->