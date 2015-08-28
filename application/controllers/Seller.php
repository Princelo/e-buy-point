<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        check_access_right('seller', $this->session);
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

    public function add()
    {
        check_access_right('admin', $this->session);
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'email',
                'label' => '电子邮箱',
                'rules' => 'required|callback__check_email|trim',
                'errors' => [
                    'required' => '电子邮箱不能为空',
                    'callback__check_email' => '电子邮箱已被占用'
                ]
            ),
            array(
                'field' => 'user_name',
                'label' => '业务员用户名',
                'rules' => 'required|callback__check_user_name|trim',
                'errors' => [
                    'required' => '业务员用户名不能为空',
                    'callback__check_user_name' => '业务员用户名已存在'
                ]
            ),
            array(
                'field' => 'name',
                'label' => '业务员姓名',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '业务员姓名不能为空',
                ]
            ),
            array(
                'field' => 'citizen_id',
                'label' => '业务员身份证号码',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '业务员身份证号码不能为空',
                ]
            ),
            array(
                'field' => 'mobile',
                'label' => '手机号码',
                'rules' => 'required|callback__is_mobile|callback__check_mobile_no|trim',
                'errors' => array(
                    'required' => '%s 必填',
                    'callback__is_mobile' => '%s 无效',
                    'callback__mobile_no' => '%s 已被占用',
                ),
            ),
            /*array(
                'field' => 'verify_code',
                'label' => '手机验证码',
                'rules' => 'required|callback__check_vcode|trim',
                'errors' => [
                    'required' => '%s 必填',
                    'callback__check_vcode' => '%s 无效',
                ],
            ),*/
            array(
                'field' => 'user_pwd',
                'label' => '密码',
                'rules' => 'required|matches[user_pwd_confirm]|trim',
            ),
            array(
                'field' => 'user_pwd_confirm',
                'label' => '确认密码',
                'rules' => 'required|trim',
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $query = $this->db->query("
            select u.id,
                   u.user_name,
                   u.mobile,
                   u.email,
                   u.return_profit,
                   (select count(1) from ".DB_PREFIX."seller where id = u.id) as count
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
        } else {
            $this->load->model('Seller_model', 'Seller_model');
            $result = $this->Seller_model->addSeller($this->input->post());
            if($result === true)
                $this->session->set_flashdata('flash_data', [ 'message' => '添加业务员成功', 'type' => 'success' ]);
            else
                $this->session->set_flashdata('flash_data', [ 'message' => '添加业务员出现问题，请资讯平台管理员', 'type' => 'error' ]);
            redirect('admin/seller_index');
        }

    }

    public function _check_user_name()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."seller where user_name = ? limit 1", [$this->input->post('user_name')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _check_email()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."seller where email = ? limit 1", [$this->input->post('email')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _check_mobile_no()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."seller where mobile = ? limit 1", [$this->input->post('mobile')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _is_mobile()
    {
        return (bool) preg_match('/^1[0-9]{10}$/', $this->input->post('mobile'));
    }

}
