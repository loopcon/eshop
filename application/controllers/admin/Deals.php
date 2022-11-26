<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Deals extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['deals_model']);

        if (!has_permissions('read', 'banners')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-deals';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Deals Management | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Deals Management | ' . $settings['app_name'];
            $id = $this->input->get('id', true);
            if (isset($id) && !empty($id)) {
                $this->data['base_deals_url'] = base_url() . 'admin/deals/deals_list?id=' . $id;
            } else {
                $this->data['base_deals_url'] = base_url() . 'admin/deals/deals_list';
            }
            $this->data['deals_result'] = $this->deals_model->get_deals();
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function deals_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->deals_model->get_deals_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function create_deal()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'deal';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Deal | ' . $settings['app_name'] : 'Add Deal | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Add Deal , Create Deal | ' . $settings['app_name'];
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['fetched_data'] = fetch_details('deals', ['id' => $_GET['edit_id']]);
                $this->data['fetched_data'][0]['product_ids'] = json_decode(str_replace("\\", "", $this->data['fetched_data'][0]['product_ids']));
            }

            $this->data['products'] = $this->deals_model->get_product_list();
            $this->data['deals'] = $this->deals_model->get_deals();

            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function add_deal()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (isset($_POST['edit_deal'])) {
                if (print_msg(!has_permissions('update', 'deals'), PERMISSION_ERROR_MSG, 'deals')) {
                    return false;
                }
            } else {
                if (print_msg(!has_permissions('create', 'deals'), PERMISSION_ERROR_MSG, 'deals')) {
                    return false;
                }
            }

            $this->form_validation->set_rules('deal_input_title', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('deal_input_product_ids', 'Product', 'trim|xss_clean|callback_multiple_select');
            $this->form_validation->set_rules('deal_input_time', 'Time', 'trim|required|xss_clean');
            $this->form_validation->set_rules('deal_input_offer', 'Offer', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
            } else {
                $_POST['deal_input_product_ids'] = json_encode($this->input->post('deal_input_product_ids'));
                $this->deals_model->add_deal($_POST);
                $this->response['error'] = false;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $message = (isset($_POST['edit_deal'])) ? 'Deal Updated Successfully!' : 'Deal Added Successfully!';
                $this->response['message'] = $message;
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function multiple_select()
    {
        $arr_product = $this->input->post('deal_input_product_ids[]');
        if(empty($arr_product)) {
            $this->form_validation->set_rules('Product','Select at least one product');
            return false;
        }
        return true;
    }

    function delete_deal()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'deals'), PERMISSION_ERROR_MSG, 'deals')) {
                return false;
            }
            if (defined('SEMI_DEMO_MODE') && SEMI_DEMO_MODE == 0) {
                $this->response['error'] = true;
                $this->response['message'] = SEMI_DEMO_MODE_MSG;
                echo json_encode($this->response);
                return false;
                exit();
            }

            if ($this->deals_model->delete_deal($_GET['id']) == TRUE) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = 'Deleted Succesfully!';
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
