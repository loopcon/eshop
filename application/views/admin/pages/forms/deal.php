<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Add Deal</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Deal</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/deals/add_deal'); ?>" method="POST" id="add_deal_form" enctype="multipart/form-data">
                            <?php if (isset($fetched_data[0]['id'])) { ?>
                                <input type="hidden" name="edit_deal" value="<?= @$fetched_data[0]['id'] ?>">
                            <?php } ?>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="deal_input_title" class="col-sm-2 col-form-label">Title <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="deal_input_title" placeholder="Title" name="deal_input_title" maxlength="40" value="<?= isset($fetched_data[0]['title'])?output_escaping($fetched_data[0]['title']):"" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="deal_input_product_ids" class="col-sm-2 col-form-label">Product <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10">
                                        <select name="deal_input_product_ids[]" class="select_multiple w-100" multiple data-placeholder=" Type to search and select products">
                                            <option value=""><?= (isset($products) && empty($products)) ? 'No Products Exist' : 'Select Products' ?>
                                            </option>
                                            <?php
                                                $selected_val = (isset($fetched_data[0]['product_ids']) &&  !empty($fetched_data[0]['product_ids'])) ? $fetched_data[0]['product_ids'] : '';
                                                // $selected_vals = explode(',', $selected_val);
                                                echo get_products_option_html($products, $selected_val);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="deal_input_time" class="col-sm-2 col-form-label">Time <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="deal_input_time" placeholder="Time" name="deal_input_time" value="<?= isset($fetched_data[0]['time_hours'])?output_escaping($fetched_data[0]['time_hours']):"" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="deal_input_offer" class="col-sm-2 col-form-label">Offer <span class='text-danger text-sm'>*</span></label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="deal_input_offer" placeholder="Offer" name="deal_input_offer"  value="<?= isset($fetched_data[0]['offer'])?output_escaping($fetched_data[0]['offer']):"" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Deal' : 'Add Deal' ?></button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="form-group" id="error_box">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--/.card-->
                </div>
                <!--/.col-md-12-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>