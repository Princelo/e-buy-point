<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('login', $this->session);
        $this->load->database();
        $this->load->model('Report_model', 'Report_model');
    }

    public function sub_member_action()
    {
        check_access_right('user', $this->session);
        $data = $this->Report_model->getActionBySubMember();
        $view_data = [];
        $view_data['list'] = $data;
        $this->load->view('layout/default_header');
        $this->load->view('report/sub_member_action', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function local_consume_log()
    {
        check_access_right('user', $this->session);
        $data = $this->Report_model->getLocalConsumeLog();
        $view_data = [];
        $view_data['list'] = $data;
        $this->load->view('layout/default_header');
        $this->load->view('report/local_consume_log', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function member_action()
    {
        check_access_right('admin', $this->session);
        $data = $this->Report_model->getActionByMember();
        $view_data = [];
        $view_data['list'] = $data;
        $this->load->view('layout/admin_header');
        $this->load->view('report/member_action', $view_data);
        $this->load->view('layout/admin_footer');
    }

    public function seller()
    {
        check_access_right('seller', $this->session);
        $this->load->helper('url');
        $this->load->helper('form');
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $this->load->model('Biz_model', 'Biz_model');
        $biz_list = $this->Biz_model->getBizs(' and s.p_seller_id = '.$this->session->userdata('seller_id'));
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['biz_list'] = $biz_list;
        $this->load->view('layout/seller_header');
        $this->load->view('report/seller', $view_data);
        $this->load->view('layout/seller_footer');
    }

    public function biz()
    {
        check_access_right('user', $this->session);
        $this->load->helper('url');
        $this->load->helper('form');
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $this->load->model('Member_model', 'Member_model');
        $member_list = $this->Member_model->getMembers(' and p_biz_id = '.$this->session->userdata('biz_id'), '',
            ' order by id desc ', ' id, user_name ');
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $view_data['member_list'] = $member_list;
        $this->load->view('layout/default_header');
        $this->load->view('report/biz', $view_data);
        $this->load->view('layout/default_footer');
    }


}
