<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homepage_setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper', 'file']);
        $this->load->model(['Setting_model', 'category_model']);

        if (!has_permissions('read', 'settings')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'homepage-settings';
            $settings = get_settings('system_settings', true);
            $this->data['app_name'] = $settings['app_name'];
            // $this->data['logo'] = get_settings('web_logo');
            // $this->data['favicon'] = get_settings('web_favicon');
            $this->data['title'] = 'Homepage Settings | ' . $settings['app_name'];
            $this->data['categories'] = $this->category_model->get_categories();
            $this->data['homepage_settings'] = get_settings('homepage_settings', true);
            // echo "<PRE>";
            // print_r($this->data);
            // exit;
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function update_homepage_settings()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'settings'), PERMISSION_ERROR_MSG, 'settings')) {
                return false;
            }
            // echo "<PRE>";
            // print_r($this->input->post());
            // exit;
            if (defined('SEMI_DEMO_MODE') && SEMI_DEMO_MODE == 0) {
                $this->response['error'] = true;
                $this->response['message'] = SEMI_DEMO_MODE_MSG;
                echo json_encode($this->response);
                return false;
                exit();
            }
            $this->form_validation->set_rules('banner', 'Homepage Banner', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('categories', 'Categories', 'trim|xss_clean|callback_multiple_select');
            $this->form_validation->set_rules('main_category_1', 'Main Category 1', 'trim|required|xss_clean');
            $this->form_validation->set_rules('main_category_2', 'Main Category 2', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
            } else {
                $this->Setting_model->update_homepage_setting($_POST);
                $this->response['error'] = false;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = 'System Setting Updated Successfully';
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function multiple_select()
    {
        $arr_category = $this->input->post('categories[]');
        if(empty($arr_category)) {
            $this->form_validation->set_rules('Categories','Select at least one category');
            return false;
        }
        return true;
    }

    public function get_sub_category()
    {
        $category_id = $this->input->get('category_id');
        if($this->input->get('subcategory_id')) {
            $subcategory_id = json_decode($this->input->get('subcategory_id'));
        } else {
            $subcategory_id = [];
        }
        $sub_categories = fetch_details("categories", "parent_id='".$category_id."'");
        $html = "";
        if(count($sub_categories)) {
            foreach($sub_categories as $sub_cat) {
                $pre_selected = in_array($sub_cat['id'], $subcategory_id) ? "selected='selected'" : "";
                $html .= "<option value='".$sub_cat['id']."' ".$pre_selected.">".$sub_cat['name']."</option>";
            }
            $error = false;
        } else {
            $html = "";
            $error = true;
        }
        echo json_encode(array('error'=>$error, 'option'=>$html));
        exit;
    }
}
