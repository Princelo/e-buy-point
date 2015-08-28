<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('seller', $this->session);
    }

    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $this->load->model('Report_model', 'Report_model');
        $view_data['action_logs'] = $this->Report_model->getLastActionForSeller(10);
        $this->load->view('layout/seller_header');
        $this->load->view('seller/index', $view_data);
        $this->load->view('layout/seller_footer');
    }

    public function store_index()
    {
        $this->load->database();
        $query = $this->db->query("
            SELECT    s.id,
                      s.name,
                      s.address,
                      s.tel,
                      s.contact,
                      s.consumption_ratio,
                      s.return_profit,
                      Count(u.id)    sub_count,
                      a.account_name account
            FROM      fanwe_supplier_location s
            LEFT JOIN fanwe_user u
            ON        u.p_biz_id = s.id
            JOIN      fanwe_supplier_account a
            JOIN      fanwe_supplier os
            JOIN      fanwe_supplier_account_location_link ll
            where     1 = 1
            AND       a.supplier_id = os.id
            AND       ll.location_id = s.id
            AND       ll.account_id = a.id
            AND       s.supplier_id = os.id
            GROUP BY  s.id,
                      s.name,
                      s.address,
                      s.tel,
                      s.contact,
                      s.consumption_ratio,
                      s.return_profit
        ");
        $view_data = [];
        $view_data['store_list'] = $query->result();
        $this->load->view('layout/admin_header');
        $this->load->view('admin/store_index', $view_data);
        $this->load->view('layout/admin_footer');
    }

    public function member_index()
    {
        $this->load->database();
        $query = $this->db->query("
            select u.id,
                   u.user_name,
                   u.mobile,
                   u.email,
                   u.score,
                   u.p_biz_id,
                   l.name
            from fanwe_user u
            left join fanwe_supplier_location l
            on l.id = u.p_biz_id
        ");
        $view_data = [];
        $view_data['member_list'] = $query->result();
        $this->load->view('layout/admin_header');
        $this->load->view('admin/member_index', $view_data);
        $this->load->view('layout/admin_footer');
    }
}
