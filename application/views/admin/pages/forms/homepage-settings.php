<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Homepage Settings</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Homepage Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/homepage_setting/update_homepage_settings') ?>" method="POST" id="homepage_setting_form" enctype="multipart/form-data">
                            <input type="hidden" name="app_name" value="<?php echo $app_name;?>" />
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="banner">Homepage Banner <span class='text-danger text-xs'>*</span></label>
                                                <div class="col-sm-10">
                                                    <div class='col-md-3'><a class="uploadFile img btn btn-primary text-white btn-sm" data-input='banner' data-isremovable='0' data-is-multiple-uploads-allowed='0' data-toggle="modal" data-target="#media-upload-modal" value="Upload Photo"><i class='fa fa-upload'></i> Upload</a></div>
                                                    <?php if (!empty($homepage_settings['banner'])) { ?>
                                                        <label class="text-danger mt-3">*Only Choose When Update is necessary</label>
                                                        <div class="container-fluid row image-upload-section">
                                                            <div class="col-md-3 col-sm-12 shadow p-3 bg-white rounded m-4 text-center grow image">
                                                                <div class=''>
                                                                    <div class='upload-media-div'><img class="img-fluid mb-2" src="<?= BASE_URL() . $homepage_settings['banner'] ?>" alt="Image Not Found"></div>
                                                                    <input type="hidden" name="banner" id='banner' value='<?= $homepage_settings['banner'] ?>'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="container-fluid row image-upload-section">
                                                            <div class="col-md-3 col-sm-12 shadow p-3 bg-white rounded m-4 text-center grow image d-none">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="categories" class="control-label">Categories</label>
                                        <div class="col-md-12">
                                            <select name="categories[]" id="hps-categories" class=" select_multiple w-100" multiple data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                                </option>
                                                <?php
                                                    $selected_val = (isset($homepage_settings['categories']) &&  !empty($homepage_settings['categories'])) ? $homepage_settings['categories'] : '';
                                                    // $selected_vals = explode(',', $selected_val);
                                                    echo get_categories_option_html($categories, $selected_val);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="main_category_1" class="control-label">Main Categroy 1</label>
                                        <div class="col-md-12">
                                            <select name="main_category_1" id="main_category_1" class=" select_multiple w-100" data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($main_categories) && empty($main_categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                                </option>
                                                <?php
                                                    $selected_val = (isset($homepage_settings['main_category_1']) &&  !empty($homepage_settings['main_category_1'])) ? $homepage_settings['main_category_1'] : '';
                                                    // $selected_vals = explode(',', $selected_val);
                                                    echo get_main_categories($selected_val);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="sub_categories_1" class="control-label">Sub Categroy 1</label>
                                        <div class="col-md-12">
                                            <select name="sub_categories_1[]" id="sub_categories_1" class=" select_multiple w-100" multiple data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="main_category_2" class="control-label">Main Categroy 2</label>
                                        <div class="col-md-12">
                                            <select name="main_category_2" id="main_category_2" class=" select_multiple w-100" data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                                </option>
                                                <?php
                                                    $selected_val = (isset($homepage_settings['main_category_2']) &&  !empty($homepage_settings['main_category_2'])) ? $homepage_settings['main_category_2'] : '';
                                                    // $selected_vals = explode(',', $selected_val);
                                                    echo get_main_categories($selected_val);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="sub_categories_2" class="control-label">Sub Categroy 2</label>
                                        <div class="col-md-12">
                                            <select name="sub_categories_2[]" id="sub_categories_2" class=" select_multiple w-100" multiple data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="main_category_3" class="control-label">Main Categroy 3</label>
                                        <div class="col-md-12">
                                            <select name="main_category_3" id="main_category_3" class=" select_multiple w-100" data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($main_categories) && empty($main_categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                                </option>
                                                <?php
                                                    $selected_val = (isset($homepage_settings['main_category_3']) &&  !empty($homepage_settings['main_category_3'])) ? $homepage_settings['main_category_3'] : '';
                                                    // $selected_vals = explode(',', $selected_val);
                                                    echo get_main_categories($selected_val);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="sub_categories_3" class="control-label">Sub Categroy 3</label>
                                        <div class="col-md-12">
                                            <select name="sub_categories_3[]" id="sub_categories_3" class=" select_multiple w-100" multiple data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="main_category_4" class="control-label">Main Categroy 4</label>
                                        <div class="col-md-12">
                                            <select name="main_category_4" id="main_category_4" class=" select_multiple w-100" data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($main_categories) && empty($main_categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                                </option>
                                                <?php
                                                    $selected_val = (isset($homepage_settings['main_category_4']) &&  !empty($homepage_settings['main_category_4'])) ? $homepage_settings['main_category_4'] : '';
                                                    // $selected_vals = explode(',', $selected_val);
                                                    echo get_main_categories($selected_val);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="sub_categories_4" class="control-label">Sub Categroy 4</label>
                                        <div class="col-md-12">
                                            <select name="sub_categories_4[]" id="sub_categories_4" class=" select_multiple w-100" multiple data-placeholder=" Type to search and select categories">
                                                <option value=""><?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-center">
                                    <div class="form-group" id="error_box">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn">Update Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>
<script>
    var main_category_1 = '<?php echo (isset($homepage_settings['main_category_1']) && !empty($homepage_settings['main_category_1'])) ? $homepage_settings['main_category_1'] : '';?>';
    var sub_categories_1 = '<?php echo (isset($homepage_settings['sub_categories_1']) && !empty($homepage_settings['sub_categories_1'])) ? json_encode($homepage_settings['sub_categories_1']) : json_encode(array());?>';
    var main_category_2 = '<?php echo (isset($homepage_settings['main_category_2']) && !empty($homepage_settings['main_category_2'])) ? $homepage_settings['main_category_2'] : '';?>';
    var sub_categories_2 = '<?php echo (isset($homepage_settings['sub_categories_2']) && !empty($homepage_settings['sub_categories_2'])) ? json_encode($homepage_settings['sub_categories_2']) : json_encode(array());?>';
    var main_category_3 = '<?php echo (isset($homepage_settings['main_category_3']) && !empty($homepage_settings['main_category_3'])) ? $homepage_settings['main_category_3'] : '';?>';
    var sub_categories_3 = '<?php echo (isset($homepage_settings['sub_categories_3']) && !empty($homepage_settings['sub_categories_3'])) ? json_encode($homepage_settings['sub_categories_3']) : json_encode(array());?>';
    var main_category_4 = '<?php echo (isset($homepage_settings['main_category_4']) && !empty($homepage_settings['main_category_4'])) ? $homepage_settings['main_category_4'] : '';?>';
    var sub_categories_4 = '<?php echo (isset($homepage_settings['sub_categories_4']) && !empty($homepage_settings['sub_categories_4'])) ? json_encode($homepage_settings['sub_categories_4']) : json_encode(array());?>';
</script>