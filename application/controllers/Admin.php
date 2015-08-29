<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('admin', $this->session);
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
        $view_data['action_logs'] = $this->Report_model->getLastActionByMember(10);
        $this->load->view('layout/admin_header');
        $this->load->view('admin/index', $view_data);
        $this->load->view('layout/admin_footer');
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
                      a.account_name account,
                      (select name from ".DB_PREFIX."seller where id = s.p_seller_id) as seller_name
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

    public function seller_index()
    {
        $this->load->database();
        $query = $this->db->query("
            select u.id,
                   u.name,
                   u.user_name,
                   u.mobile,
                   u.email,
                   u.return_profit,
                   (select count(1) from ".DB_PREFIX."supplier_location where p_seller_id = u.id) as count
            from ".DB_PREFIX."seller u
        ");
        $view_data = [];
        $view_data['seller_list'] = $query->result();
        $this->load->helper('url');
        $this->load->helper('form');
        $form_url = site_url(['seller', 'add']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['form_url'] = $form_url;
        $view_data['username_validate_url'] = site_url('validator/check_seller_unique_username');
        $view_data['email_validate_url'] = site_url('validator/check_seller_unique_email');
        $view_data['mobile_validate_url'] = site_url('validator/check_seller_unique_mobile');
        $this->load->view('layout/admin_header');
        $this->load->view('admin/seller_index', $view_data);
        $this->load->view('layout/admin_footer');
    }

    public function settle_simple()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $this->load->database();
        $view_data['info'] = $this->db->query("
            select
                s.id,
                s.return_profit,
                s.name
            from
                ".DB_PREFIX."supplier_location s
            where s.id = ?
            ", [$id])->result()[0];
        $this->load->view('layout/simple_header');
        $this->load->view('admin/settle_simple', $view_data);
        $this->load->view('layout/simple_footer');
    }

    public function settle_seller_simple()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $this->load->database();
        $view_data['info'] = $this->db->query("
            select
                s.id,
                s.return_profit,
                s.user_name
            from
                ".DB_PREFIX."seller s
            where s.id = ?
            ", [$id])->result()[0];
        $this->load->view('layout/simple_header');
        $this->load->view('admin/settle_seller_simple', $view_data);
        $this->load->view('layout/simple_footer');
    }

    public function settle_biz()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $this->load->database();
        $this->db->trans_begin();
        $this->db->query("
            insert into ".DB_PREFIX."settle_biz_log (biz_id, volume)
            select id, return_profit from ".DB_PREFIX."supplier_location
            where id = ? and return_profit <> 0
        ", [$id]);
        $this->db->query("update ".DB_PREFIX."supplier_location set return_profit = 0 where id = ?
            and return_profit <> 0",[$id]);
        $result = $this->db->trans_status();
        if($result === true){
            $this->db->trans_commit();
            $this->load->view('layout/simple_header');
            showSuccess("结算成功！");
            $this->load->view('layout/simple_footer');
        } else {
            $this->db->trans_rollback();
            $this->load->view('layout/simple_header');
            showError("结算失败！");
            $this->load->view('layout/simple_footer');
        }

    }

    public function settle_seller()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $this->load->database();
        $this->db->trans_begin();
        $this->db->query("
            insert into ".DB_PREFIX."settle_seller_log (seller_id, volume)
            select id, return_profit from ".DB_PREFIX."seller
            where id = ? and return_profit <> 0
        ", [$id]);
        $this->db->query("update ".DB_PREFIX."seller set return_profit = 0 where id = ?
            and return_profit <> 0",[$id]);
        $result = $this->db->trans_status();
        if($result === true){
            $this->db->trans_commit();
            $this->load->view('layout/simple_header');
            showSuccess("结算成功！");
            $this->load->view('layout/simple_footer');
        } else {
            $this->db->trans_rollback();
            $this->load->view('layout/simple_header');
            showError("结算失败！");
            $this->load->view('layout/simple_footer');
        }

    }

    public function settle_biz_log_simple()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $this->load->database();
        $view_data['list'] = $this->db->query("
            select sl.id, sl.biz_id, sl.volume, l.name, sl.create_time
            from ".DB_PREFIX."settle_biz_log sl, ".DB_PREFIX."supplier_location l
            where sl.biz_id = l.id
            and sl.biz_id  = ?
        ", [$id])->result();
        $this->load->view('layout/simple_header');
        $this->load->view('admin/settle_biz_log_simple', $view_data);
        $this->load->view('layout/simple_footer');
    }

    public function settle_seller_log_simple()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $this->load->database();
        $view_data['list'] = $this->db->query("
            select sl.id, sl.seller_id, sl.volume, l.user_name, sl.create_time
            from ".DB_PREFIX."settle_seller_log sl, ".DB_PREFIX."seller l
            where sl.seller_id = l.id
            and sl.seller_id  = ?
        ", [$id])->result();
        $this->load->view('layout/simple_header');
        $this->load->view('admin/settle_seller_log_simple', $view_data);
        $this->load->view('layout/simple_footer');
    }
}
