<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biz extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('seller', $this->session);
        $this->load->database();
    }
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $consumption_form_url = site_url(['biz', 'add']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['form_url'] = $consumption_form_url;
        $view_data['username_validate_url'] = site_url('validator/check_biz_unique_username');
        $view_data['email_validate_url'] = site_url('validator/check_biz_unique_email');
        $view_data['mobile_validate_url'] = site_url('validator/check_biz_unique_mobile');
        $view_data['bizname_validate_url'] = site_url('validator/check_biz_unique_name');
        $view_data['sms_url'] = site_url('sms/sent_sms_for_register_sub_biz');
        $this->load->view('layout/seller_header');
        $this->load->view('biz/index', $view_data);
        $this->load->view('layout/seller_footer');
    }

    public function add()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'name',
                'label' => '商家名称',
                'rules' => 'required|callback__check_name|trim',
                'errors' => [
                    'required' => '%s 不能为空',
                    'callback__check_email' => '%s 已被占用'
                ]
            ),
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
                'field' => 'consumption_ratio',
                'label' => '返点率',
                'rules' => 'required|is_natural|trim|greater_than[4]|less_than[101]',
                'errors' => [
                    'required' => '返点率不能为空',
                ]
            ),
            array(
                'field' => 'user_name',
                'label' => '管理员用户名',
                'rules' => 'required|callback__check_user_name|trim',
                'errors' => [
                    'required' => '管理员用户名不能为空',
                    'callback__check_user_name' => '管理员用户名已存在'
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
            $this->load->helper('url');
            $this->load->helper('form');
            $consumption_form_url = site_url(['biz', 'add']);
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $csrf_cookie_name = $this->security->get_csrf_cookie_name();
            $view_data = [];
            $view_data['csrf'] = $csrf;
            $view_data['csrf_cookie_name'] = $csrf_cookie_name;
            $view_data['form_url'] = $consumption_form_url;
            $view_data['username_validate_url'] = site_url('validator/check_biz_unique_username');
            $view_data['email_validate_url'] = site_url('validator/check_biz_unique_email');
            $view_data['mobile_validate_url'] = site_url('validator/check_biz_unique_mobile');
            $view_data['bizname_validate_url'] = site_url('validator/check_biz_unique_name');
            $view_data['sms_url'] = site_url('sms/sent_sms_for_register_sub_biz');
            $this->load->view('layout/seller_header');
            $this->load->view('biz/index', $view_data);
            $this->load->view('layout/seller_footer');
        } else {
            $this->load->model('Biz_model', 'Biz_model');
            $result = $this->Biz_model->addSubBiz($this->input->post());
            if($result === true)
                $this->session->set_flashdata('flash_data', [ 'message' => '添加商家成功', 'type' => 'success' ]);
            else
                $this->session->set_flashdata('flash_data', [ 'message' => '添加商家出现问题，请资讯平台管理员', 'type' => 'error' ]);
            redirect('biz/index');
        }
    }
    public function sub_biz_list()
    {
        $where = " and s.p_seller_id = ".$this->session->userdata('seller_id');
        $this->load->model('Biz_model', 'Biz_model');
        $list = $this->Biz_model->getBizs($where);
        $view_data = [];
        $view_data['list'] = $list;
        $this->load->view('layout/seller_header');
        $this->load->view('biz/sub_biz_list', $view_data);
        $this->load->view('layout/seller_footer');
    }

    public function _check_name()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."supplier_location where name = ? limit 1", [$this->input->post('name')]);
        if($query->num_rows() > 0)
            return false;
        else {
            $query = $this->db->query("select id from ".DB_PREFIX."supplier where name = ? limit 1", [$this->input->post('name')]);
            if($query->num_rows() > 0)
                return false;
            else
                return true;
        }
    }

    public function _check_user_name()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."supplier_account where account_name = ? limit 1", [$this->input->post('user_name')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _check_email()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."supplier_account where email = ? limit 1", [$this->input->post('email')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _check_mobile_no()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."supplier_account where mobile = ? limit 1", [$this->input->post('mobile')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _is_mobile()
    {
        return (bool) preg_match('/^1[0-9]{10}$/', $this->input->post('mobile'));
    }

    public function _check_date()
    {
        $arr = explode('-', $this->input->post('bdate'));
        if (count($arr) != 3)
            return false;
        return checkdate($arr[1], $arr[2], $arr[0]);
    }

    public function _check_vcode()
    {
        $this->db->query("delete from ".DB_PREFIX."sms_verification where create_time < ? ", [date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'] - 3600)]);
        $query = $this->db->query("select id from ".DB_PREFIX."sms_verification where code = ? and mobile = ? order by create_time desc limit 1",
            [$this->input->post('verify_code'), $this->input->post('mobile')]);
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }
}
