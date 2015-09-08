<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('user', $this->session);
        $this->load->database();
    }
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $consumption_form_url = site_url(['member', 'add']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['member_form_url'] = $consumption_form_url;
        $view_data['member_username_validate_url'] = site_url('validator/check_member_unique_username');
        $view_data['member_email_validate_url'] = site_url('validator/check_member_unique_email');
        $view_data['member_mobile_validate_url'] = site_url('validator/check_member_unique_mobile');
        $view_data['sms_url'] = site_url('sms/sent_sms_for_register_sub_member');
        $this->load->view('layout/default_header');
        $this->load->view('member/index', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function add()
    {
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
                'label' => '会员帐号',
                'rules' => 'required|callback__check_user_name|trim',
                'errors' => [
                    'required' => '会员帐号不能为空',
                    'callback__check_user_name' => '会员帐号已存在'
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
            array(
                'field' => 'verify_code',
                'label' => '手机验证码',
                'rules' => 'required|callback__check_vcode|trim',
                'errors' => [
                    'required' => '%s 必填',
                    'callback__check_vcode' => '%s 无效',
                ],
            ),
            array(
                'field' => 'gender',
                'label' => '性別',
                'rules' => 'trim|required|integer|greater_than[-1]|less_than[2]',
            ),
            array(
                'field' => 'bdate',
                'label' => '出生日期',
                'rules' => 'required|callback__check_date|trim',
                'errors' => [
                    'required' => '%s 必填',
                    'callback__check_date' => '%s 无效',
                ],
            ),
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
            $consumption_form_url = site_url(['member', 'add']);
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $csrf_cookie_name = $this->security->get_csrf_cookie_name();
            $view_data = [];
            $view_data['csrf'] = $csrf;
            $view_data['csrf_cookie_name'] = $csrf_cookie_name;
            $view_data['member_form_url'] = $consumption_form_url;
            $view_data['member_username_validate_url'] = site_url('validator/check_member_unique_username');
            $view_data['member_email_validate_url'] = site_url('validator/check_member_unique_email');
            $view_data['member_mobile_validate_url'] = site_url('validator/check_member_unique_mobile');
            $view_data['sms_url'] = site_url('sms/sent_sms_for_register_sub_member');
            $this->load->view('layout/default_header');
            $this->load->view('member/index', $view_data);
            $this->load->view('layout/default_footer');
        } else {
            $this->load->model('member_model', 'Member_model');
            $result = $this->Member_model->addSubMember($this->input->post());
            if($result === true)
                $this->session->set_flashdata('flash_data', [ 'message' => '添加会员成功', 'type' => 'success' ]);
            else
                $this->session->set_flashdata('flash_data', [ 'message' => '添加会员出现问题，请资讯平台管理员', 'type' => 'error' ]);
            redirect('member/index');
        }
    }
    public function sub_member_list()
    {
        $query = $this->db->query("select user_name, create_time, byear,bday,bmonth, sex, mobile, email, score
            from ".DB_PREFIX
            ."user where p_biz_id = ?", [$this->session->userdata('biz_id')]);
        $view_data = [];
        $view_data['list'] = $query->result();
        $this->load->view('layout/default_header');
        $this->load->view('member/sub_member_list', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function _check_user_name()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."user where user_name = ? limit 1", [$this->input->post('user_name')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _check_email()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."user where email = ? limit 1", [$this->input->post('email')]);
        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function _check_mobile_no()
    {
        $this->db->select('id');
        $query = $this->db->query("select id from ".DB_PREFIX."user where mobile = ? limit 1", [$this->input->post('mobile')]);
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
        else {
            showErr('手机验证码错误！', site_url('member/index'));
            return false;
        }
    }
}
