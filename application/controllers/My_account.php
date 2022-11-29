<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_account extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'pagination', 'upload']);
        $this->load->helper(['url', 'language']);
        $this->load->model(['cart_model', 'category_model', 'address_model', 'order_model', 'Transaction_model', 'Promo_code_model']);
        $this->lang->load('auth');
        $this->data['is_logged_in'] = ($this->ion_auth->logged_in()) ? 1 : 0;
        $this->data['user'] = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : array();
        $this->data['settings'] = get_settings('system_settings', true);
        $this->data['web_settings'] = get_settings('web_settings', true);
        $this->response['csrfName'] = $this->security->get_csrf_token_name();
        $this->response['csrfHash'] = $this->security->get_csrf_hash();
    }


    public function index()
    {
        if ($this->data['is_logged_in']) {
            $this->data['main_page'] = 'dashboard';
            $this->data['title'] = 'Dashboard | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Dashboard, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Dashboard | ' . $this->data['web_settings']['meta_description'];
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function profile()
    {
        if ($this->ion_auth->logged_in()) {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['users'] = $this->ion_auth->user()->row();
            $this->data['identity_column'] = $identity_column;
            $this->data['main_page'] = 'profile';
            $this->data['title'] = 'Profile | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = $this->data['web_settings']['meta_description'];
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function orders()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['main_page'] = 'orders';
            $this->data['title'] = 'Orders | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Orders, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Orders | ' . $this->data['web_settings']['meta_description'];
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $total = fetch_orders(false, $this->data['user']->id, false, false, 1, NULL, NULL, NULL, NULL);
            $limit = 10;
            $config['base_url'] = base_url('my-account/orders');
            $config['total_rows'] = $total['total'];
            $config['per_page'] = $limit;
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
            $config['page_query_string'] = FALSE;
            $config['uri_segment'] = 3;
            $config['attributes'] = array('class' => 'page-link');

            $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
            $config['full_tag_close'] = '</ul>';

            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_link'] = 'First';
            $config['first_tag_close'] = '</li>';

            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_link'] = 'Last';
            $config['last_tag_close'] = '</li>';

            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_link'] = '<i class="fa fa-arrow-left"></i>';
            $config['prev_tag_close'] = '</li>';

            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_link'] = '<i class="fa fa-arrow-right"></i>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

            $page_no = (empty($this->uri->segment(3))) ? 1 : $this->uri->segment(3);
            if (!is_numeric($page_no)) {
                redirect(base_url('my-account/orders'));
            }
            $offset = ($page_no - 1) * $limit;
            $this->pagination->initialize($config);
            $this->data['links'] =  $this->pagination->create_links();
            $this->data['orders'] = fetch_orders(false, $this->data['user']->id, false, false, $limit, $offset, 'date_added', 'DESC', NULL);
            $this->data['payment_methods'] = get_settings('payment_method', true);
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function order_details()
    {
        if ($this->ion_auth->logged_in()) {
            $bank_transfer = array();
            $this->data['main_page'] = 'order-details';
            $this->data['title'] = 'Orders | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Orders, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Orders | ' . $this->data['web_settings']['meta_description'];
            $order_id = $this->uri->segment(3);
            $order = fetch_orders($order_id, $this->data['user']->id, false, false, 1, NULL, NULL, NULL, NULL);
            if (!isset($order['order_data']) || empty($order['order_data'])) {
                redirect(base_url('my-account/orders'));
            }
            $this->data['order'] = $order['order_data'][0];
            if ($order['order_data'][0]['payment_method'] == "Bank Transfer") {
                $bank_transfer = fetch_details('order_bank_transfer', ['order_id' => $order['order_data'][0]['id']]);
            }
            $this->data['bank_transfer'] = $bank_transfer;
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function order_invoice($order_id)
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['main_page'] = VIEW . 'api-order-invoice';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Invoice Management |' . $settings['app_name'];
            $this->data['meta_description'] = 'Invoice Management | ' . $this->data['web_settings']['meta_description'];;
            if (isset($order_id) && !empty($order_id)) {
                $res = $this->order_model->get_order_details(['o.id' => $order_id], true);
                if (!empty($res)) {
                    $items = [];
                    $promo_code = [];
                    if (!empty($res[0]['promo_code'])) {
                        $promo_code = fetch_details('promo_codes', ['promo_code' => trim($res[0]['promo_code'])]);
                    }
                    foreach ($res as $row) {
                        $row = output_escaping($row);
                        $temp['product_id'] = $row['product_id'];
                        $temp['seller_id'] = $row['seller_id'];
                        $temp['product_variant_id'] = $row['product_variant_id'];
                        $temp['pname'] = $row['pname'];
                        $temp['quantity'] = $row['quantity'];
                        $temp['discounted_price'] = $row['discounted_price'];
                        $temp['tax_percent'] = $row['tax_percent'];
                        $temp['tax_amount'] = $row['tax_amount'];
                        $temp['price'] = $row['price'];
                        $temp['delivery_boy'] = $row['delivery_boy'];
                        $temp['active_status'] = $row['oi_active_status'];
                        array_push($items, $temp);
                    }
                    $this->data['order_detls'] = $res;
                    $this->data['items'] = $items;
                    $this->data['promo_code'] = $promo_code;
                    $this->data['print_btn_enabled'] = true;
                    $this->data['settings'] = get_settings('system_settings', true);
                    $this->load->view('admin/invoice-template', $this->data);
                } else {
                    redirect(base_url(), 'refresh');
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function update_order_item_status()
    {
        $this->form_validation->set_rules('order_item_id', 'Order item id', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean|in_list[cancelled,returned]');
        if (!$this->form_validation->run()) {
            $this->response['error'] = true;
            $this->response['message'] = strip_tags(validation_errors());
            $this->response['data'] = array();
        } else {
            $this->response = $this->order_model->update_order_item($_POST['order_item_id'], trim($_POST['status']));
            if (trim($_POST['status']) != 'returned' && $this->response['error'] == false) {
                process_refund($_POST['order_item_id'], trim($_POST['status']), 'order_items');
            }
            if ($this->response['error'] == false && trim($_POST['status']) == 'cancelled') {
                $data = fetch_details('order_items', ['id' => $_POST['order_item_id']], 'product_variant_id,quantity');
                update_stock($data[0]['product_variant_id'], $data[0]['quantity'], 'plus');
            }
        }
        print_r(json_encode($this->response));
    }

    public function update_order()
    {
        $this->form_validation->set_rules('order_id', 'Order id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean|in_list[cancelled,returned]');
        if (!$this->form_validation->run()) {
            $this->response['error'] = true;
            $this->response['message'] = validation_errors();
            $this->response['data'] = array();
            print_r(json_encode($this->response));
            return false;
        } else {
            $res = validate_order_status($_POST['order_id'], $_POST['status'], 'orders');
            if ($res['error']) {
                $this->response['error'] = (isset($res['return_request_flag'])) ? false : true;
                $this->response['message'] = $res['message'];
                $this->response['data'] = $res['data'];
                print_r(json_encode($this->response));
                return false;
            }
            if ($this->order_model->update_order(['status' => $_POST['status']], ['id' => $_POST['order_id']], true)) {
                $this->order_model->update_order(['active_status' => $_POST['status']], ['id' => $_POST['order_id']], false);
                if ($this->order_model->update_order(['status' => $_POST['status']], ['order_id' => $_POST['order_id']], true, 'order_items')) {
                    $this->order_model->update_order(['active_status' => $_POST['status']], ['order_id' => $_POST['order_id']], false, 'order_items');
                    process_refund($_POST['order_id'], $_POST['status'], 'orders');
                    if (trim($_POST['status'] == 'cancelled')) {
                        $data = fetch_details('order_items', ['order_id' => $_POST['order_id']], 'product_variant_id,quantity');
                        $product_variant_ids = [];
                        $qtns = [];
                        foreach ($data as $d) {
                            array_push($product_variant_ids, $d['product_variant_id']);
                            array_push($qtns, $d['quantity']);
                        }

                        update_stock($product_variant_ids, $qtns, 'plus');
                    }
                    $this->response['error'] = false;
                    $this->response['message'] = 'Order Updated Successfully';
                    $this->response['data'] = array();
                    print_r(json_encode($this->response));
                    return false;
                }
            }
        }
    }

    public function notifications()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['main_page'] = 'notifications';
            $this->data['title'] = 'Notification | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Notification, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Notification | ' . $this->data['web_settings']['meta_description'];
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function manage_address()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['main_page'] = 'address';
            $this->data['title'] = 'Address | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Address, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Address | ' . $this->data['web_settings']['meta_description'];
            $this->data['countries'] = fetch_details('countries', NULL);
            // $this->data['cities'] = get_cities();
            $this->data['areas'] = fetch_details('areas', NULL);
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function wallet()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['main_page'] = 'wallet';
            $this->data['title'] = 'Wallet | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Wallet, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Wallet | ' . $this->data['web_settings']['meta_description'];
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function transactions()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['main_page'] = 'transactions';
            $this->data['title'] = 'Transactions | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Transactions, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Transactions | ' . $this->data['web_settings']['meta_description'];
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function add_address()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('type', 'Type', 'trim|xss_clean');
            $this->form_validation->set_rules('country_code', 'Country Code', 'trim|xss_clean');
            $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|numeric|xss_clean|required');
            $this->form_validation->set_rules('alternate_mobile', 'Alternative Mobile', 'trim|numeric|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|required');
            $this->form_validation->set_rules('landmark', 'Landmark', 'trim|xss_clean');
            $this->form_validation->set_rules('country_id', 'Country', 'trim|xss_clean|required');
            $this->form_validation->set_rules('state_id', 'State', 'trim|xss_clean|required');
            $this->form_validation->set_rules('city_id', 'City', 'trim|xss_clean|required');
            $this->form_validation->set_rules('area_id', 'Area', 'trim|xss_clean|required');
            // $this->form_validation->set_rules('pincode', 'Pincode', 'trim|xss_clean|required');
            $this->form_validation->set_rules('latitude', 'Latitude', 'trim|xss_clean');
            $this->form_validation->set_rules('longitude', 'Longitude', 'trim|xss_clean');

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                $this->response['data'] = array();
                print_r(json_encode($this->response));
                return false;
            }

            $arr = $this->input->post(null, true);
            $arr['user_id'] = $this->data['user']->id;
            $this->address_model->set_address($arr);
            $res = $this->address_model->get_address($this->data['user']->id, false, true);
            $this->response['error'] = false;
            $this->response['message'] = 'Address Added Successfully';
            $this->response['data'] = $res;
            print_r(json_encode($this->response));
            return false;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }

    public function edit_address()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('id', 'Id', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('type', 'Type', 'trim|xss_clean');
            $this->form_validation->set_rules('country_code', 'Country Code', 'trim|xss_clean');
            $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|numeric|xss_clean');
            $this->form_validation->set_rules('alternate_mobile', 'Alternative Mobile', 'trim|numeric|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
            $this->form_validation->set_rules('landmark', 'Landmark', 'trim|xss_clean');
            $this->form_validation->set_rules('area_id', 'Area', 'trim|xss_clean');
            $this->form_validation->set_rules('city_id', 'City', 'trim|xss_clean');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|numeric|xss_clean');
            $this->form_validation->set_rules('state', 'State', 'trim|xss_clean');
            $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                $this->response['data'] = array();
                print_r(json_encode($this->response));
                return false;
            }
            $this->address_model->set_address($_POST);
            $res = $this->address_model->get_address(null, $_POST['id'], true);
            $this->response['error'] = false;
            $this->response['message'] = 'Address updated Successfully';
            $this->response['data'] = $res;
            print_r(json_encode($this->response));
            return false;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }

    //delete_address
    public function delete_address()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('id', 'Id', 'trim|required|numeric|xss_clean');
            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                $this->response['data'] = array();
                print_r(json_encode($this->response));
                return false;
            }
            $this->address_model->delete_address($_POST);
            $this->response['error'] = false;
            $this->response['message'] = 'Address Deleted Successfully';
            $this->response['data'] = array();
            print_r(json_encode($this->response));
            return false;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }

    //set default_address
    public function set_default_address()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('id', 'Id', 'trim|required|numeric|xss_clean');
            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                $this->response['data'] = array();
                print_r(json_encode($this->response));
                return false;
            }
            $_POST['is_default'] = true;
            $this->address_model->set_address($_POST);
            $this->response['error'] = false;
            $this->response['message'] = 'Set as default successfully';
            $this->response['data'] = array();
            print_r(json_encode($this->response));
            return false;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }

    //get_address
    public function get_address()
    {
        if ($this->ion_auth->logged_in()) {
            $res = $this->address_model->get_address($this->data['user']->id);
            if (!empty($res)) {
                $this->response['error'] = false;
                $this->response['message'] = 'Address Retrieved Successfully';
                $this->response['data'] = $res;
            } else {
                $this->response['error'] = true;
                $this->response['message'] = "No Details Found !";
                $this->response['data'] = array();
            }
            print_r(json_encode($this->response));
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }
    public function get_promo_codes()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('sort', 'sort', 'trim|xss_clean');
            $this->form_validation->set_rules('limit', 'limit', 'trim|numeric|xss_clean');
            $this->form_validation->set_rules('offset', 'offset', 'trim|numeric|xss_clean');
            $this->form_validation->set_rules('order', 'order', 'trim|xss_clean');

            if (!$this->form_validation->run()) {

                $this->response['error'] = true;
                $this->response['message'] = strip_tags(validation_errors());
                $this->response['data'] = array();
                print_r(json_encode($this->response));
                return;
            } else {
                $limit = (isset($_POST['limit']) && is_numeric($_POST['limit']) && !empty(trim($_POST['limit']))) ? $this->input->post('limit', true) : 25;
                $offset = (isset($_POST['offset']) && is_numeric($_POST['offset']) && !empty(trim($_POST['offset']))) ? $this->input->post('offset', true) : 0;
                $order = (isset($_POST['order']) && !empty(trim($_POST['order']))) ? $_POST['order'] : 'DESC';
                $sort = (isset($_POST['sort']) && !empty(trim($_POST['sort']))) ? $_POST['sort'] : 'id';
                $this->response['error'] = false;
                $this->response['message'] = 'Promocodes retrived Successfully !';
                $result = $this->Promo_code_model->get_promo_codes($limit, $offset, $sort, $order);
                $this->response['total'] = $result['total'];
                $this->response['offset'] = (isset($offset) && !empty($offset)) ? $offset : '0';
                $this->response['promo_codes'] = $result['data'];
                print_r(json_encode($this->response));
                return;
            }
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }

    public function get_address_list()
    {
        if ($this->ion_auth->logged_in()) {
            return $this->address_model->get_address_list($this->data['user']->id);
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }

    public function get_areas()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('city_id', 'City Id', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
                return false;
            }

            $city_id = $this->input->post('city_id', true);
            $areas = fetch_details('areas', ['city_id' => $city_id]);
            if (empty($areas)) {
                $this->response['error'] = true;
                $this->response['message'] = "No Areas found for this City.";
                print_r(json_encode($this->response));
                return false;
            }
            $this->response['error'] = false;
            $this->response['data'] = $areas;
            print_r(json_encode($this->response));
            return false;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }
    public function get_zipcode()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('area_id', 'Area Id', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                print_r(json_encode($this->response));
                return false;
            }

            $area_id = $this->input->post('area_id', true);
            $areas = fetch_details('areas', ['id' => $area_id], 'zipcode_id');
            $zipcodes = fetch_details('zipcodes', ['id' => $areas[0]['zipcode_id']], 'zipcode');
            if (empty($areas)) {
                $this->response['error'] = true;
                $this->response['message'] = "No Zipcodes found for this area.";
                print_r(json_encode($this->response));
                return false;
            }
            $this->response['error'] = false;
            $this->response['data'] = $zipcodes;
            print_r(json_encode($this->response));
            return false;
        } else {
            $this->response['error'] = true;
            $this->response['message'] = 'Unauthorized access is not allowed';
            print_r(json_encode($this->response));
            return false;
        }
    }

    public function favorites()
    {
        if ($this->data['is_logged_in']) {
            $this->data['main_page'] = 'favorites';
            $this->data['title'] = 'Dashboard | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Dashboard, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Dashboard | ' . $this->data['web_settings']['meta_description'];
            $this->data['products'] = get_favorites($this->data['user']->id);
            $this->data['settings'] = get_settings('system_settings', true);
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function manage_favorites()
    {
        if ($this->data['is_logged_in']) {
            $this->form_validation->set_rules('product_id', 'Product Id', 'trim|numeric|required|xss_clean');
            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                $this->response['data'] = array();
            } else {
                $data = [
                    'user_id' => $this->data['user']->id,
                    'product_id' => $this->input->post('product_id', true),
                ];
                if (is_exist($data, 'favorites')) {
                    $this->db->delete('favorites', $data);
                    $this->response['error']   = false;
                    $this->response['message'] = "Product removed from favorite !";
                    print_r(json_encode($this->response));
                    return false;
                }
                $data = escape_array($data);
                $this->db->insert('favorites', $data);
                $this->response['error'] = false;
                $this->response['message'] = 'Product Added to favorite';
                print_r(json_encode($this->response));
                return false;
            }
        } else {
            $this->response['error'] = true;
            $this->response['message'] = "Login First to Add Products in Favorite List.";
            print_r(json_encode($this->response));
            return false;
        }
    }

    public function get_transactions()
    {
        if ($this->ion_auth->logged_in()) {
            return $this->Transaction_model->get_transactions_list($this->data['user']->id);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function get_wallet_transactions()
    {
        if ($this->ion_auth->logged_in()) {
            return $this->Transaction_model->get_transactions_list($this->data['user']->id);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function store_details() {
        
        if ($this->ion_auth->logged_in()) {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['main_page'] = 'store-details';
            $this->data['title'] = 'Store details | ' . $this->data['web_settings']['site_title'];
            $this->data['keywords'] = 'Store details, ' . $this->data['web_settings']['meta_keywords'];
            $this->data['description'] = 'Store details | ' . $this->data['web_settings']['meta_description'];
            $this->data['login_type'] = $this->session->userdata('login_type');
            $this->data['status'] = $this->session->userdata('status');
            $this->data['user_data'] = fetch_details("users", "id='".$this->session->userdata('user_id')."'");
            $this->data['store_details'] = fetch_details("seller_data", "user_id='".$this->session->userdata('user_id')."'");
            $this->data['category_list'] = fetch_details("categories", "status='1'");
            $this->load->view('front-end/' . THEME . '/template', $this->data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function update_store_details()
    {
        $identity_column = $this->config->item('identity', 'ion_auth');
        $identity = $this->session->userdata('identity');
        $user = $this->ion_auth->user()->row();
        $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('logo', 'Store Logo', 'trim|xss_clean');
        $this->form_validation->set_rules('national_identity_card', 'National Identity Card', 'trim|xss_clean');
        $this->form_validation->set_rules('tax_name', 'Tax Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tax_number', 'Tax Number', 'trim|required|xss_clean');
        

        // $tables = $this->config->item('tables', 'ion_auth');
        if (!$this->form_validation->run()) {
            if (validation_errors()) {
                $this->response['error'] = true;
                $this->response['message'] = validation_errors();
                echo json_encode($this->response);
                return false;
                exit();
            }
        } else {
            if (!file_exists(FCPATH . SELLER_DOCUMENTS_PATH)) {
                mkdir(FCPATH . SELLER_DOCUMENTS_PATH, 0777);
            }
            
            //process store logo
            $temp_array_logo = $store_logo_doc = array();
            $logo_files = $_FILES;
            $store_logo_error = "";
            $config = [
                'upload_path' =>  FCPATH . SELLER_DOCUMENTS_PATH,
                'allowed_types' => 'jpg|png|jpeg|gif',
                'max_size' => 8000,
            ];
            if (isset($logo_files['logo']) && !empty($logo_files['logo']['name']) && isset($logo_files['logo']['name'])) {
                $other_img = $this->upload;
                $other_img->initialize($config);
                
                $old_logo = explode('/', $this->input->post('old_store_logo', true));
                delete_images(SELLER_DOCUMENTS_PATH, $old_logo[2]);

                if (!empty($logo_files['logo']['name'])) {
                    $_FILES['temp_image']['name'] = $logo_files['logo']['name'];
                    $_FILES['temp_image']['type'] = $logo_files['logo']['type'];
                    $_FILES['temp_image']['tmp_name'] = $logo_files['logo']['tmp_name'];
                    $_FILES['temp_image']['error'] = $logo_files['logo']['error'];
                    $_FILES['temp_image']['size'] = $logo_files['logo']['size'];
                    if (!$other_img->do_upload('temp_image')) {
                        $store_logo_error = 'Images :' . $store_logo_error . ' ' . $other_img->display_errors();
                    } else {
                        $temp_array_logo = $other_img->data();
                        resize_review_images($temp_array_logo, FCPATH . SELLER_DOCUMENTS_PATH);
                        $store_logo_doc  = SELLER_DOCUMENTS_PATH . $temp_array_logo['file_name'];
                    }
                } else {
                    $_FILES['temp_image']['name'] = $logo_files['logo']['name'];
                    $_FILES['temp_image']['type'] = $logo_files['store_logo']['type'];
                    $_FILES['temp_image']['tmp_name'] = $logo_files['store_logo']['tmp_name'];
                    $_FILES['temp_image']['error'] = $logo_files['store_logo']['error'];
                    $_FILES['temp_image']['size'] = $logo_files['store_logo']['size'];
                    if (!$other_img->do_upload('temp_image')) {
                        $store_logo_error = $other_img->display_errors();
                    }
                }
            }

            //process national_identity_card
            $temp_array_id_card = $id_card_doc = array();
            $id_card_files = $_FILES;
            $id_card_error = "";
            $config = [
                'upload_path' =>  FCPATH . SELLER_DOCUMENTS_PATH,
                'allowed_types' => 'jpg|png|jpeg|gif',
                'max_size' => 8000,
            ];
            if (isset($id_card_files['national_identity_card']) &&  !empty($id_card_files['national_identity_card']['name']) && isset($id_card_files['national_identity_card']['name'])) {
                $other_img = $this->upload;
                $other_img->initialize($config);

                if (isset($_POST['edit_seller']) && !empty($_POST['edit_seller']) && isset($_POST['old_national_identity_card']) && !empty($_POST['old_national_identity_card'])) {
                    $old_national_identity_card = explode('/', $this->input->post('old_national_identity_card', true));
                    delete_images(SELLER_DOCUMENTS_PATH, $old_national_identity_card[2]);
                }
                if (!empty($id_card_files['national_identity_card']['name'])) {
                    $_FILES['temp_image']['name'] = $id_card_files['national_identity_card']['name'];
                    $_FILES['temp_image']['type'] = $id_card_files['national_identity_card']['type'];
                    $_FILES['temp_image']['tmp_name'] = $id_card_files['national_identity_card']['tmp_name'];
                    $_FILES['temp_image']['error'] = $id_card_files['national_identity_card']['error'];
                    $_FILES['temp_image']['size'] = $id_card_files['national_identity_card']['size'];
                    if (!$other_img->do_upload('temp_image')) {
                        $id_card_error = 'Images :' . $id_card_error . ' ' . $other_img->display_errors();
                    } else {
                        $temp_array_id_card = $other_img->data();
                        resize_review_images($temp_array_id_card, FCPATH . SELLER_DOCUMENTS_PATH);
                        $id_card_doc  = SELLER_DOCUMENTS_PATH . $temp_array_id_card['file_name'];
                    }
                } else {
                    $_FILES['temp_image']['name'] = $id_card_files['national_identity_card']['name'];
                    $_FILES['temp_image']['type'] = $id_card_files['national_identity_card']['type'];
                    $_FILES['temp_image']['tmp_name'] = $id_card_files['national_identity_card']['tmp_name'];
                    $_FILES['temp_image']['error'] = $id_card_files['national_identity_card']['error'];
                    $_FILES['temp_image']['size'] = $id_card_files['national_identity_card']['size'];
                    if (!$other_img->do_upload('temp_image')) {
                        $id_card_error = $other_img->display_errors();
                    }
                }
            }
            $sellerDetails = [
                'category_ids' => (!empty($this->input->post('category'))) ? implode(",", $this->input->post('category')) : "",
                'store_name' => $this->input->post('store_name'),
                'store_description' => $this->input->post('store_description'),
                'logo' => (!empty($store_logo_doc)) ? $store_logo_doc : $this->input->post('old_store_logo', true),
                'store_url' => $this->input->post('store_url'),
                'bank_name' => $this->input->post('bank_name'),
                'bank_code' => $this->input->post('bank_code'),
                'account_name' => $this->input->post('account_name'),
                'account_number' => $this->input->post('account_number'),
                'national_identity_card' => (!empty($id_card_doc)) ? $id_card_doc : $this->input->post('old_national_identity_card', true),
                'pan_number' => $this->input->post('pan_number'),
                'tax_name' => $this->input->post('tax_name'),
                'tax_number' => $this->input->post('tax_number'),
            ];
            update_details($sellerDetails, array('user_id'=>$this->session->userdata('user_id')), 'seller_data');
            delete_details(['seller_id' => $this->session->userdata('user_id')], 'seller_commission');
            foreach($this->input->post('category') as $cat) {
                $commission_data[] = array(
                    "seller_id" => $this->session->userdata('user_id'),
                    "category_id" => $cat,
                    "commission" => 0,
                );
            }
            $this->db->insert_batch('seller_commission', $commission_data);
            $this->response['error'] = false;
            $this->response['message'] = 'Seller details Update Succesfully';
            $this->response['store_logo'] = (!empty($store_logo_doc)) ? $store_logo_doc : $this->input->post('old_store_logo', true);
            $this->response['national_identity_card'] = (!empty($id_card_doc)) ? $id_card_doc : $this->input->post('old_national_identity_card', true);
            echo json_encode($this->response);
            return false;
        }
    }
    
    public function my_products()
    {
        $this->data['main_page'] = 'my-products';
        $this->data['title'] = 'Store details | ' . $this->data['web_settings']['site_title'];
        $this->data['keywords'] = 'Store details, ' . $this->data['web_settings']['meta_keywords'];
        $this->data['description'] = 'Store details | ' . $this->data['web_settings']['meta_description'];
        $this->data['login_type'] = $this->session->userdata('login_type');
        $this->data['status'] = $this->session->userdata('status');
        $this->data['products'] = fetch_details("products", "category_id='".$this->session->userdata('user_id')."'");
        $this->load->view('front-end/' . THEME . '/template', $this->data);
    }
}
