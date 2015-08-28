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

    public function admin()
    {
        check_access_right('admin', $this->session);
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
        $this->load->view('layout/admin_header');
        $this->load->view('report/admin', $view_data);
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

    public function biz_consumption_simple()
    {
        check_access_right('admin', $this->session);
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $datetime = new \DateTime(date('Y-m-1'));
        $start = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end = $datetime->getTimestamp();
        $where = " and l.biz_id = {$id} ";
        $where .= " and unix_timestamp(l.create_time) between {$start} and {$end} ";
        $this->load->model('Consumption_model', 'Consumption_model');
        $list = $this->Consumption_model->getConsumptions($where);
        $view_data = [];
        $view_data['list'] = $list;
        $this->load->view('layout/simple_header');
        $this->load->view('report/biz_consumption_simple', $view_data);
        $this->load->view('layout/simple_footer');
    }

    public function biz_sub_consumption_simple()
    {
        check_access_right('admin', $this->session);
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $datetime = new \DateTime(date('Y-m-1'));
        $start = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end = $datetime->getTimestamp();
        $where = " and u.p_biz_id = {$id} ";
        $where .= " and unix_timestamp(l.create_time) between {$start} and {$end} ";
        $this->load->model('Consumption_model', 'Consumption_model');
        $list = $this->Consumption_model->getSubConsumptions($where);
        $view_data = [];
        $view_data['list'] = $list;
        $this->load->view('layout/simple_header');
        $this->load->view('report/biz_sub_consumption_simple', $view_data);
        $this->load->view('layout/simple_footer');
    }

    public function member_consumption_simple()
    {
        check_access_right('admin', $this->session);
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $datetime = new \DateTime(date('Y-m-1'));
        $start = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end = $datetime->getTimestamp();
        $where = " and u.id = {$id} ";
        $where .= " and unix_timestamp(l.create_time) between {$start} and {$end} ";
        $this->load->model('Consumption_model', 'Consumption_model');
        $list = $this->Consumption_model->getSubConsumptions($where);
        $view_data = [];
        $view_data['list'] = $list;
        $this->load->view('layout/simple_header');
        $this->load->view('report/member_consumption_simple', $view_data);
        $this->load->view('layout/simple_footer');
    }

    public function biz_self_report_simple()
    {
        check_access_right('user', $this->session);
        $type = $this->input->post('type');
        $start_year = filter_var($this->input->post('start_year'), FILTER_VALIDATE_INT);
        $end_year = filter_var($this->input->post('end_year'), FILTER_VALIDATE_INT);
        $star_month = filter_var($this->input->post('start_month'), FILTER_VALIDATE_INT);
        $end_month = filter_var($this->input->post('end_month'), FILTER_VALIDATE_INT);
        $start_date = new \DateTime();
        $start_date->setDate($start_year, $star_month, 1);
        $start_time = $start_date->getTimestamp();
        $end_date = new \DateTime();
        $end_date->setDate($end_year, $end_month, 1);
        $end_date->modify('next month');
        $end_time = $end_date->getTimestamp();
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $this->load->view('layout/simple_header');
        switch(strval($type)) {
            case 'consumption_report':
                $where = " and s.id = ".$this->session->userdata('biz_id')
                    ." and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time;
                $this->load->Model('Consumption_model', 'Consumption_model');
                $view_data['list'] = $this->Consumption_model->getConsumptions($where);
                $this->load->view('report/biz_self_report_simple_consumption', $view_data);
                break;
            case 'income_report':
                $where = " and u.p_biz_id = ".$this->session->userdata('biz_id')
                    ." and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time;
                $view_data['list'] = $this->Report_model->getBizIncomes($where);
                $this->load->view('report/biz_self_report_simple_income', $view_data);
                break;
            case 'settle_report':
                $where = " and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time
                    ." and s.id = ".$this->session->userdata('biz_id');
                $this->load->Model('Settle_model', 'Settle_model');
                $view_data['list'] = $this->Settle_model->getSettleLogs($where);
                $this->load->view('report/settle_view_simple', $view_data);
                break;
        }
        $this->load->view('layout/simple_footer');
    }

    public function report_simple()
    {
        check_access_right('admin', $this->session);
        $type = $this->input->post('type');
        $start_year = filter_var($this->input->post('start_year'), FILTER_VALIDATE_INT);
        $end_year = filter_var($this->input->post('end_year'), FILTER_VALIDATE_INT);
        $start_month = filter_var($this->input->post('start_month'), FILTER_VALIDATE_INT);
        $end_month = filter_var($this->input->post('end_month'), FILTER_VALIDATE_INT);
        $start_date = new \DateTime();
        $start_date->setDate($start_year, $start_month, 1);
        $start_time = $start_date->getTimestamp();
        $end_date = new \DateTime();
        $end_date->setDate($end_year, $end_month, 1);
        $end_date->modify('next month');
        $end_time = $end_date->getTimestamp();
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $this->load->view('layout/simple_header');
        switch(strval($type)) {
            case 'consumption_report':
                $where =
                    " and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time;
                $this->load->Model('Consumption_model', 'Consumption_model');
                $view_data['list'] = $this->Consumption_model->getConsumptions($where);
                $this->load->view('report/consumption_simple', $view_data);
                break;
            case 'income_report':
                $where = " and u.p_biz_id = ".$this->session->userdata('biz_id')
                    ." and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time;
                $view_data['list'] = $this->Report_model->getBizIncomes($where);
                $this->load->view('report/biz_self_report_simple_income', $view_data);
                break;
        }
        $this->load->view('layout/simple_footer');
    }

    public function admin_report($type = '')
    {
        check_access_right('admin', $this->session);
        $datetime = new \DateTime(date('Y-m-1'));
        $start_time = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end_time = $datetime->getTimestamp();
        $this->load->view('layout/admin_header');
        switch(strval($type)) {
            case "consumption":
                $where =
                    " and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time;
                $this->load->Model('Consumption_model', 'Consumption_model');
                $view_data['list'] = $this->Consumption_model->getConsumptions($where);
                $this->load->view('report/admin_report_consumption', $view_data);
                break;
        }
        $this->load->view('layout/admin_footer');
    }

    public function annual_settle_biz()
    {
        check_access_right('user', $this->session);
        $this->load->view('layout/default_header');
        $this->load->Model('Settle_model', 'Settle_model');
        $view_data['list'] = $this->Settle_model->getSettleLogs(' and s.id = '.$this->session->userdata('biz_id'));
        $this->load->view('report/annual_settle_biz', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function seller_report($type = '')
    {
        check_access_right('seller', $this->session);
        $datetime = new \DateTime(date('Y-m-1'));
        $start_time = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end_time = $datetime->getTimestamp();
        $this->load->view('layout/seller_header');
        switch(strval($type)) {
            case "consumption":
                $where =
                    " and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time
                    ." and l.type = 0 ";
                $this->load->Model('Consumption_model', 'Consumption_model');
                $view_data['list'] = $this->Consumption_model->getConsumptions($where);
                $this->load->view('report/seller_report_consumption', $view_data);
                break;
        }
        $this->load->view('layout/seller_footer');
    }

    public function annual_settle_seller()
    {
        check_access_right('seller', $this->session);
        $this->load->view('layout/seller_header');
        $this->load->Model('Settle_model', 'Settle_model');
        $view_data['list'] = $this->Settle_model->getSettleLogsSeller(' and s.id = '.$this->session->userdata('seller_id'));
        $this->load->view('report/annual_settle_seller', $view_data);
        $this->load->view('layout/seller_footer');
    }

    public function seller_self_report_simple()
    {
        check_access_right('seller', $this->session);
        $type = $this->input->post('type');
        $start_year = filter_var($this->input->post('start_year'), FILTER_VALIDATE_INT);
        $end_year = filter_var($this->input->post('end_year'), FILTER_VALIDATE_INT);
        $star_month = filter_var($this->input->post('start_month'), FILTER_VALIDATE_INT);
        $end_month = filter_var($this->input->post('end_month'), FILTER_VALIDATE_INT);
        $start_date = new \DateTime();
        $start_date->setDate($start_year, $star_month, 1);
        $start_time = $start_date->getTimestamp();
        $end_date = new \DateTime();
        $end_date->setDate($end_year, $end_month, 1);
        $end_date->modify('next month');
        $end_time = $end_date->getTimestamp();
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $this->load->view('layout/simple_header');
        switch(strval($type)) {
            case 'income_report':
                $where = " and ps.p_seller_id = ".$this->session->userdata('seller_id')
                        ." and l.type = 0 "
                    ." and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time;
                $this->load->Model('Consumption_model', 'Consumption_model');
                $view_data['list'] = $this->Consumption_model->getConsumptions($where);
                $this->load->view('report/biz_self_report_simple_consumption', $view_data);
                break;
            case 'settle_report':
                $where = " and unix_timestamp(l.create_time) between ".$start_time." and ".$end_time
                    ." and s.id = ".$this->session->userdata('seller_id');
                $this->load->Model('Settle_model', 'Settle_model');
                $view_data['list'] = $this->Settle_model->getSettleLogsSeller($where);
                $this->load->view('report/settle_view_simple', $view_data);
                break;
        }
        $this->load->view('layout/simple_footer');
    }

}
