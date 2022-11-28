<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['banner_model']);

        if (!has_permissions('read', 'banners')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-banner';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Banner Management | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Banner Management | ' . $settings['app_name'];
            $id = $this->input->get('id', true);
            if (isset($id) && !empty($id)) {
                $this->data['base_banner_url'] = base_url() . 'admin/banner/banner_list?id=' . $id;
            } else {
                $this->data['base_banner_url'] = base_url() . 'admin/banner/banner_list';
            }
            $this->data['banner_result'] = $this->banner_model->get_banners();
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function banner_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->banner_model->get_banner_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function create_banner()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'banner';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Banner | ' . $settings['app_name'] : 'Add Banner | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Add Banner , Create Banner | ' . $settings['app_name'];
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['fetched_data'] = fetch_details('banners', ['id' => $_GET['edit_id']]);
            }

            $this->data['banners'] = $this->banner_model->get_banners();

            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function add_banner()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (isset($_POST['edit_banner'])) {
                if (print_msg(!has_permissions('update', 'banners'), PERMISSION_ERROR_MSG, 'banners')) {
                    return false;
                }
            } else {
                if (print_msg(!has_permissions('create', 'banners'), PERMISSION_ERROR_MSG, 'banners')) {
                    return false;
                }
            }

            $this->form_validation->set_rules('banner_input_name', 'Banner Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('banner_input_image', 'Banner Image', 'trim|xss_clean');

            if (isset($_POST['edit_banner'])) {
                $this->form_validation->set_rules('banner_input_image', 'Image', 'trim|xss_clean');
            } else {
                $this->form_validation->set_rules('banner_input_image', 'Image', 'trim|required|xss_clean', array('required' => 'Banner image is required.'));
            }

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
            } else {
                $this->banner_model->add_banner($_POST);
                $this->response['error'] = false;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $message = (isset($_POST['edit_banner'])) ? 'Banner Updated Successfully!' : 'Banner Added Successfully!';
                $this->response['message'] = $message;
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function delete_banner()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'banners'), PERMISSION_ERROR_MSG, 'banners')) {
                return false;
            }
            if (defined('SEMI_DEMO_MODE') && SEMI_DEMO_MODE == 0) {
                $this->response['error'] = true;
                $this->response['message'] = SEMI_DEMO_MODE_MSG;
                echo json_encode($this->response);
                return false;
                exit();
            }

            if ($this->banner_model->delete_banner($_GET['id']) == TRUE) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = 'Deleted Succesfully';
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
