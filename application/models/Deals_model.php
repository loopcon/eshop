<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Deals_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language', 'function_helper']);
    }

    public function get_deals($id = NULL, $limit = '', $offset = '', $sort = 'id', $order = 'ASC')
    {
        $where = ['d.is_deleted' => 0];

        $this->db->select('d.*');
        $this->db->where($where);

        if (!empty($limit) || !empty($offset)) {
            $this->db->offset($offset);
            $this->db->limit($limit);
        }

        $this->db->order_by($sort, $order);

        $query = $this->db->get('deals d');
        $deals = $query->result();
        $count_res = $this->db->count_all_results('deals d');
        // $i = 0;
        // foreach ($deals as $d) {
        //     $deals[$i]->text = output_escaping($d->name);
        //     $deals[$i]->name = output_escaping($deals[$i]->name);
        //     $deals[$i]->image = get_image_url($deals[$i]->image, 'thumb', 'sm');
        //     $i++;
        // }
        if (isset($deals[0])) {
            $deals[0]->total = $count_res;
        }
        return  json_decode(json_encode($deals), 1);
    }

    public function delete_deal($id)
    {
        $this->db->trans_start();
        $id = escape_array($id);
        $this->db->set('is_deleted', 1)->where('id', $id)->update('deals');
        $this->db->trans_complete();
        $response = TRUE;
        return $response;
    }

    public function get_deals_list()
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'ASC';
        $multipleWhere = '';
        $where = ['is_deleted' => 0];

        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            if ($_GET['sort'] == 'id') {
                $sort = "id";
            } else {
                $sort = $_GET['sort'];
            }
        if (isset($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $multipleWhere = ['`id`' => $search, '`name`' => $search];
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }

        $deal_count = $count_res->where($where)->get('deals')->result_array();
        foreach ($deal_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select(' * ');
        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $deal_search_res = $search_res->order_by($sort, "asc")->limit($limit, $offset)->get('deals')->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($deal_search_res as $row) {
            if (!$this->ion_auth->is_seller()) {
                $operate = '<a href="' . base_url('admin/deals/create_deal' . '?edit_id=' . $row['id']) . '" class=" btn btn-success btn-xs mr-1 mb-1" title="Edit" data-id="' . $row['id'] . '" data-url="admin/deals/create_deal"><i class="fa fa-pen"></i></a>';
                $operate .= '<a class="delete-deal btn btn-danger btn-xs mr-1 mb-1" title="Delete" href="javascript:void(0)" data-id="' . $row['id'] . '" ><i class="fa fa-trash"></i></a>';
            }
            /* if ($row['status'] == '1') {
                $tempRow['status'] = '<a class="badge badge-success text-white" >Active</a>';
                if (!$this->ion_auth->is_seller()) {
                    $operate .= '<a class="btn btn-warning btn-xs update_active_status mr-1 mb-1" data-table="banners" title="Deactivate" href="javascript:void(0)" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fa fa-eye-slash"></i></a>';
                }
            } else {
                $tempRow['status'] = '<a class="badge badge-danger text-white" >Inactive</a>';
                if (!$this->ion_auth->is_seller()) {
                    $operate .= '<a class="btn btn-primary btn-xs update_active_status mr-1 mb-1" data-table="banners" href="javascript:void(0)" title="Active" data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" ><i class="fa fa-eye"></i></a>';
                }
            } */

            $tempRow['id'] = $row['id'];
            $tempRow['name'] = output_escaping($row['title']);

            /* if (empty($row['image']) || file_exists(FCPATH  . $row['image']) == FALSE) {
                $row['image'] = base_url() . NO_IMAGE;
                $row['image_main'] = base_url() . NO_IMAGE;
            } else {
                $row['image_main'] = base_url($row['image']);
                $row['image'] = get_image_url($row['image'], 'thumb', 'sm');
            }
            $tempRow['image'] = "<a href='" . $row['image_main'] . "' data-toggle='lightbox' data-gallery='gallery'> <img src='" . $row['image'] . "' class='h-25' ></a>"; */

            if (!$this->ion_auth->is_seller()) {
                $tempRow['operate'] = $operate;
            }
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    public function add_deal($data)
    {
        $data = escape_array($data);

        $hours = $data['deal_input_time'];
        $deal_data = [
            'title' => $data['deal_input_title'],
            'product_ids' => $data['deal_input_product_ids'],
            'start_date' => date('Y-m-d h:i:s'),
            'end_date' => date('Y-m-d h:i:s', strtotime('+'.$hours.' hours')),
            'time_hours' => $hours,
            'offer' => $data['deal_input_offer'],
        ];

        if (isset($data['edit_deal'])) {
            $this->db->set($deal_data)->where('id', $data['edit_deal'])->update('deals');
        } else {
            $this->db->insert('deals', $deal_data);
        }
    }

    public function get_product_list($sort = 'p.name', $order = 'ASC')
    {
        $where = ['p.status' => 1];

        $this->db->select('p.*');
        $this->db->where($where);

        $this->db->order_by($sort, $order);

        $query = $this->db->get('products p');
        $deals = $query->result();
        return  $deals;
    }
}
