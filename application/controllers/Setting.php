<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('login', $this->session);
        $this->load->database();
    }
    public function index()
    {
        check_access_right('user', $this->session);
        $this->load->helper('url');
        $this->load->helper('form');
        $form_url = site_url(['setting', 'update']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $query = $this->db->query("select name, address, tel, contact from ".DB_PREFIX."supplier_location where id = ? limit 1",
            [$this->session->userdata('biz_id')]);
        $data = $query->result()[0];
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['data'] = $data;
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['form_url'] = $form_url;
        $this->load->view('layout/default_header');
        $this->load->view('setting/index', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function update()
    {
        check_access_right('user', $this->session);
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'address',
                'label' => '地址',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '地址不能为空',
                ]
            ),
            array(
                'field' => 'tel',
                'label' => '电话',
                'rules' => 'trim',
            ),
            array(
                'field' => 'contact',
                'label' => '联系人',
                'rules' => 'trim',
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $form_url = site_url(['setting', 'update']);
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $query = $this->db->query("select name, address, tel, contact from ".DB_PREFIX."supplier_location where id = ? limit 1",
                [$this->session->userdata('biz_id')]);
            $data = $query->result()[0];
            $csrf_cookie_name = $this->security->get_csrf_cookie_name();
            $view_data = [];
            $view_data['data'] = $data;
            $view_data['csrf'] = $csrf;
            $view_data['csrf_cookie_name'] = $csrf_cookie_name;
            $view_data['form_url'] = $form_url;
            $this->load->view('layout/default_header');
            $this->load->view('setting/index', $view_data);
            $this->load->view('layout/default_footer');
        } else {
            $this->load->model('member_model', 'Member_model');
            $result = $this->Member_model->updateMemberInfo($this->input->post());
            if($result === true)
                $this->session->set_flashdata('flash_data', [ 'message' => '修改信息成功', 'type' => 'success' ]);
            else
                $this->session->set_flashdata('flash_data', [ 'message' => '修改信息失败，请资讯平台管理员', 'type' => 'error' ]);
            redirect('setting/index');
        }
    }

    public function change_password()
    {
        check_access_right('user', $this->session);
        $this->load->helper('url');
        $this->load->helper('form');
        $form_url = site_url(['auth', 'change_password']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['form_url'] = $form_url;
        $this->load->view('layout/default_header');
        $this->load->view('setting/change_password', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function seller_change_password()
    {
        check_access_right('seller', $this->session);
        $this->load->helper('url');
        $this->load->helper('form');
        $form_url = site_url(['auth', 'seller_change_password']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['form_url'] = $form_url;
        $this->load->view('layout/seller_header');
        $this->load->view('setting/change_password', $view_data);
        $this->load->view('layout/seller_footer');
    }

}
