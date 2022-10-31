<!-- breadcrumb -->
<section class="breadcrumb-title-bar colored-breadcrumb">
    <div class="main-content responsive-breadcrumb">
        <h2><?= !empty($this->lang->line('store_details')) ? $this->lang->line('store_details') : 'Store Details' ?></h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><?= !empty($this->lang->line('home')) ? $this->lang->line('home') : 'Home' ?></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('my-account') ?>"><?= !empty($this->lang->line('dashboard')) ? $this->lang->line('dashboard') : 'Dashboard' ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?= !empty($this->lang->line('store_details')) ? $this->lang->line('store_details') : 'Store Details' ?></a></li>
            </ol>
        </nav>
    </div>

</section>
<!-- end breadcrumb -->
<section class="my-account-section">
    <div class="main-content">
        <div class="col-md-12 mt-5 mb-3">
            <div class="user-detail align-items-center">
                <div class="ml-3">
                    <h6 class="text-muted mb-0"><?= !empty($this->lang->line('hello')) ? $this->lang->line('hello') : 'Hello' ?></h6>
                    <h5 class="mb-0"><?= $user->username ?></h5>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-4">
                <?php $this->load->view('front-end/' . THEME . '/pages/my-account-sidebar') ?>
            </div>
            <div class="col-md-8 col-12">
                <div class=' border-0'>
                    <form action="<?= base_url('my-account/update-store-details') ?>" method="POST" id="store-details-form" class="" enctype="multipart/form-data">
                        <input type="hidden" name="old_store_logo" value="<?=$store_details[0]['logo']?>">
                        <input type="hidden" name="old_national_identity_card" value="<?=$store_details[0]['national_identity_card']?>">
                        <section id="store-details" class="mb-4">
                            <div class="row card-header bg-white">
                                <h1 class="h4"><?= !empty($this->lang->line('store_details')) ? $this->lang->line('store_details') : 'Store Details' ?></h1>
                            </div>
                            <div class="row mt-3 py-3">
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="store_name" class="control-label"><?= !empty($this->lang->line('store_name')) ? $this->lang->line('store_name') : 'Store Name' ?>*</label>
                                    <input type="text" class="form-control" id="store_name" name="store_name" placeholder="Store Name" value="<?=$store_details[0]['store_name']?>" />
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="store_url" class="control-label"><?= !empty($this->lang->line('store_url')) ? $this->lang->line('store_url') : 'Store URL' ?></label>
                                    <input type="text" class="form-control" id="store_url" name="store_url" placeholder="Store URL" value="<?=$store_details[0]['store_url']?>" />
                                </div>
                                <?php /* <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="mobile_number" class="control-label"><?= !empty($this->lang->line('mobile_number')) ? $this->lang->line('mobile_number') : 'Mobile Number' ?></label>
                                    <input type="text" class="form-control" id="mobile_number" name="mobile" placeholder="Mobile Number" />
                                </div> */ ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="store_description" class="control-label"><?= !empty($this->lang->line('store_description')) ? $this->lang->line('store_description') : 'Store Description' ?></label>
                                    <textarea name="store_description" class="form-control" id="store_description" cols="30" rows="4" placeholder="<?= !empty($this->lang->line('store_description')) ? $this->lang->line('store_description') : 'Store Description' ?>"><?=$store_details[0]['store_description']?></textarea>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="store_logo" class="control-label"><?= !empty($this->lang->line('store_logo')) ? $this->lang->line('store_logo') : 'Store Logo' ?>*</label>
                                    <div class="">
                                        <input type="file" class="form-control" name="logo" id="store_logo" accept="image/*" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group lg-img <?php if (isset($store_details[0]['logo']) && !empty($store_details[0]['logo'])) { ?><?php } else { ?>d-none<?php } ?>">
                                    <div class="form-group row">
                                        <div class="mx-auto product-image">
                                            <img src="<?= base_url($store_details[0]['logo']); ?>" class="img-fluid rounded" width="110">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section id="bank-details" class="mb-4">
                            <div class="row card-header bg-white">
                                <h1 class="h4"><?= !empty($this->lang->line('bank_details')) ? $this->lang->line('bank_details') : 'Bank Details' ?></h1>
                            </div>
                            <div class="row mt-3 py-3">
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="account_number" class="control-label"><?= !empty($this->lang->line('account_number')) ? $this->lang->line('account_number') : 'Account Number' ?></label>
                                    <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number" value="<?= @$store_details[0]['account_number'] ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="account_name" class="control-label"><?= !empty($this->lang->line('account_name')) ? $this->lang->line('account_name') : 'Account Name' ?></label>
                                    <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name" value="<?= @$store_details[0]['account_name'] ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="bank_code" class="control-label"><?= !empty($this->lang->line('bank_code')) ? $this->lang->line('bank_code') : 'Bank Code' ?></label>
                                    <input type="text" class="form-control" id="bank_code" name="bank_code" placeholder="Bank Code" value="<?= @$store_details[0]['bank_code'] ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="bank_name" class="control-label"><?= !empty($this->lang->line('bank_name')) ? $this->lang->line('bank_name') : 'Bank Name' ?></label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?= @$store_details[0]['bank_name'] ?>">
                                </div>
                            </div>
                        </section>
                        <section id="other-details" class="mb-4">
                            <div class="row card-header bg-white">
                                <h1 class="h4"><?= !empty($this->lang->line('other_details')) ? $this->lang->line('other_details') : 'Other Details' ?></h1>
                            </div>
                            <div class="row mt-3 py-3">
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="national_identity_card" class="control-label"><?= !empty($this->lang->line('national_identity_card')) ? $this->lang->line('national_identity_card') : 'National Identity Card' ?>*</label>
                                    <div class="">
                                        <input type="file" class="form-control" name="national_identity_card" id="national_identity_card" accept="image/*" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group nid-img <?php if (isset($store_details[0]['national_identity_card']) && !empty($store_details[0]['national_identity_card'])) { ?><?php } else { ?>d-none<?php } ?>">
                                    <div class="form-group row">
                                        <div class="mx-auto product-image">
                                            <img src="<?= base_url($store_details[0]['national_identity_card']); ?>" class="img-fluid rounded" width="110">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="tax_name" class="control-label"><?= !empty($this->lang->line('tax_name')) ? $this->lang->line('tax_name') : 'Tax name' ?>*</label>
                                    <input type="text" class="form-control" id="tax_name" name="tax_name" placeholder="Tax name" value="<?= @$store_details[0]['tax_name'] ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="tax_number" class="control-label"><?= !empty($this->lang->line('tax_number')) ? $this->lang->line('tax_number') : 'Tax number' ?>*</label>
                                    <input type="text" class="form-control" id="tax_number" name="tax_number" placeholder="Tax number" value="<?= @$store_details[0]['tax_number'] ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="pan_number" class="control-label"><?= !empty($this->lang->line('pan_number')) ? $this->lang->line('pan_number') : 'Pan number' ?></label>
                                    <input type="text" class="form-control" id="pan_number" name="pan_number" placeholder="Pan number" value="<?= @$store_details[0]['pan_number'] ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="latitude" class="control-label"><?= !empty($this->lang->line('latitude')) ? $this->lang->line('latitude') : 'Latitude' ?></label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" value="<?= @$store_details[0]['latitude'] ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label for="longitude" class="control-label"><?= !empty($this->lang->line('longitude')) ? $this->lang->line('longitude') : 'Longitude' ?></label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" value="<?= @$store_details[0]['longitude'] ?>">
                                </div>
                            </div>
                            <div class="row col-md-12 col-sm-12 col-xs-12 pb-3">
                                <input type="submit" class="btn btn-primary" id="save-store-detail-submit-btn" value="Save" />
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                <div id="save-store-detail-result"></div>
                            </div>
                        </section>
                        </div>
                    </form>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
<div class="modal fade edit-modal-lg" id="address-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?= !empty($this->lang->line('edit_address')) ? $this->lang->line('edit_address') : 'Edit Address' ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('my-account/edit-address') ?>" method="POST" id="edit-address-form" class="mt-4">
                    <input type="hidden" name="id" id="address_id" value="" />
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label for="name" class="control-label"><?= !empty($this->lang->line('name')) ? $this->lang->line('name') : 'Name' ?></label>
                            <input type="text" class="form-control" id="edit_name" name="name" placeholder="Name" />
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label for="mobile_number" class="control-label"><?= !empty($this->lang->line('mobile_number')) ? $this->lang->line('mobile_number') : 'Mobile Number' ?></label>
                            <input type="text" class="form-control" id="edit_mobile" name="mobile" placeholder="Mobile Number" />
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label for="address" class="control-label"><?= !empty($this->lang->line('address')) ? $this->lang->line('address') : 'Address' ?></label>
                            <input type="text" class="form-control" name="address" id="edit_address" placeholder="Address" />
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                            <label for="city" class="control-label"><?= !empty($this->lang->line('city')) ? $this->lang->line('city') : 'City' ?></label>
                            <select name="city_id" id="edit_city" class="form-control">
                                <option value=""><?= !empty($this->lang->line('select_city')) ? $this->lang->line('select_city') : '--Select City--' ?></option>
                                <?php foreach ($cities as $row) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                            <label for="area" class="control-label"><?= !empty($this->lang->line('area')) ? $this->lang->line('area') : 'Area' ?></label>
                            <select name="area_id" id="edit_area" class="form-control">
                                <option value=""><?= !empty($this->lang->line('select_area')) ? $this->lang->line('select_area') : '--Select Area--' ?></option>

                            </select>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label for="pincode" class="control-label"><?= !empty($this->lang->line('pincode')) ? $this->lang->line('pincode') : 'Zipcode' ?></label>
                            <input type="text" class="form-control" id="edit_pincode" name="pincode" placeholder="Name" readonly />
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label for="state" class="control-label"><?= !empty($this->lang->line('state')) ? $this->lang->line('state') : 'State' ?></label>
                            <input type="text" class="form-control" id="edit_state" name="state" placeholder="State" />
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label for="country" class="control-label"><?= !empty($this->lang->line('country')) ? $this->lang->line('country') : 'Country' ?></label>
                            <input type="text" class="form-control" name="country" id="edit_country" placeholder="Country" />
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="country" class="control-label"><?= !empty($this->lang->line('type')) ? $this->lang->line('type') : 'Type : ' ?></label>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="type" id="edit_home" value="home" />
                                <label for="home" class="form-check-label text-dark"><?= !empty($this->lang->line('home')) ? $this->lang->line('home') : 'Home' ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="type" id="edit_office" value="office" placeholder="Office" />
                                <label for="office" class="form-check-label text-dark"><?= !empty($this->lang->line('office')) ? $this->lang->line('office') : 'Office' ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="type" id="edit_other" value="other" placeholder="Other" />
                                <label for="other" class="form-check-label text-dark"><?= !empty($this->lang->line('other')) ? $this->lang->line('other') : 'Other' ?></label>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <input type="submit" class="btn btn-primary" id="edit-address-submit-btn" value="Save" />
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center mt-2">
                            <div id="edit-address-result"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>