<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['category_model']);
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller() && ($this->ion_auth->seller_status() == 1 || $this->ion_auth->seller_status() == 0 || $this->ion_auth->seller_status() == 3)) {
            $this->data['main_page'] = TABLES . 'manage-category';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Category Management | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Category Management | ' . $settings['app_name'];
            $id = $this->input->get('id', true);
            if (isset($id) && !empty($id)) {
                $this->data['base_category_url'] = base_url() . 'seller/category/category_list?id=' . $id;
            } else {
                $this->data['base_category_url']  = base_url() . 'seller/category/category_list';
            }
            $this->data['category_result'] = $this->category_model->get_categories();
            $this->load->view('seller/template', $this->data);
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    public function get_categories()
    {

        $ignore_status = isset($_GET['ignore_status']) && $_GET['ignore_status'] == 1 ? 1 : '';
        $seller_id = (isset($_GET['seller_id']) && !empty($_GET['seller_id'])) ? $_GET['seller_id'] : $this->session->userdata('user_id');
        $response['data'] = $this->data['category_result'] = $this->category_model->get_categories(NULL, '', '', 'row_order', 'ASC', 'true', '', $ignore_status, $seller_id);
        echo json_encode($response);
        return;
    }

    public function get_seller_categories()
    {
        $seller_id = (isset($_GET['seller_id']) && !empty($_GET['seller_id'])) ? $this->input->get('seller_id', true) :  $this->session->userdata('user_id');
        $ignore_status = isset($_GET['ignore_status']) && $_GET['ignore_status'] == 1 ? 1 : '';
        $response['data'] = $this->category_model->get_seller_categories($seller_id);
        echo json_encode($response);
        return;
    }

    public function category_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller() && ($this->ion_auth->seller_status() == 1 || $this->ion_auth->seller_status() == 0 || $this->ion_auth->seller_status() == 3)) {
            $user_id = $this->session->userdata('user_id');
            $from = 'Seller';
            return $this->category_model->get_category_list($user_id, $from);
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    public function create_category()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller() && ($this->ion_auth->seller_status() == 1 || $this->ion_auth->seller_status() == 0 || $this->ion_auth->seller_status() == 3)) {
            $this->data['main_page'] = FORMS . 'category';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Category | ' . $settings['app_name'] : 'Add Category | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Add Category , Create Category | ' . $settings['app_name'];
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['fetched_data'] = fetch_details('categories', ['id' => $_GET['edit_id']]);
            }

            $this->data['categories'] = $this->category_model->get_categories(NULL, '', '', 'row_order', 'ASC', 'true', '', '', $this->session->userdata('user_id'));

            $this->load->view('seller/template', $this->data);
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    public function add_category()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller()) {
            /*if (isset($_POST['edit_category'])) {
                if (print_msg(!has_permissions('update', 'categories'), PERMISSION_ERROR_MSG, 'categories')) {
                    return false;
                }
            } else {
                if (print_msg(!has_permissions('create', 'categories'), PERMISSION_ERROR_MSG, 'categories')) {
                    return false;
                }
            }*/

            $this->form_validation->set_rules('selected_categories', 'Category', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('banner', 'Banner', 'trim|xss_clean');

            /*if (isset($_POST['edit_category'])) {
                $this->form_validation->set_rules('category_input_image', 'Image', 'trim|xss_clean');
            } else {
                $this->form_validation->set_rules('category_input_image', 'Image', 'trim|required|xss_clean', array('required' => 'Category image is required.'));
            }*/

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
            } else {
                $selected_categories = $_POST['selected_categories'];
                $categories = explode(",", $selected_categories);
                delete_details(array("seller_id"=>$this->session->userdata('user_id')), "seller_categories");
                foreach($categories as $category) {
                    $seller_categories_data = array(
                        "seller_id" => $this->session->userdata('user_id'),
                        "category_id" => $category
                    );
                    insert_details($seller_categories_data, "seller_categories");
                    $seller_commission_data = array(
                        'seller_id' => $this->session->userdata('user_id'),
                        'category_id'=>$category, 'commission'=>0
                    );
                    insert_details($seller_commission_data, "seller_commission");
                }
                // $_POST['added_id'] = $this->session->userdata('user_id');
                // $_POST['added_by'] = 'Seller';
                // $this->category_model->add_category($_POST);
                // $seller_category = fetch_details('categories', ['added_id'=>$this->session->userdata('user_id'), 'added_by'=>'Seller']);
                // $categories = array();
                // foreach($seller_category as $category) {
                //     $categories[] = $category['id'];
                // }
                update_details(array('category_ids'=>$selected_categories), array('user_id'=>$this->session->userdata('user_id')), 'seller_data');
                $this->response['error'] = false;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $message = (isset($_POST['edit_category'])) ? 'Category Updated Successfully!' : 'Category Added Successfully!';
                $this->response['message'] = $message;
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
