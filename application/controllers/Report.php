<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('user', $this->session);
        $this->load->database();
    }

    public function sub_member_action()
    {
        $this->load->model('Report_model', 'Report_model');
        $data = $this->Report_model->getActionBySubMember();
        $view_data = [];
        $view_data['list'] = $data;
        $this->load->view('layout/default_header');
        $this->load->view('report/sub_member_action', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function local_consume_log()
    {
        $this->load->model('Report_model', 'Report_model');
        $data = $this->Report_model->getLocalConsumeLog();
        $view_data = [];
        $view_data['list'] = $data;
        $this->load->view('layout/default_header');
        $this->load->view('report/local_consume_log', $view_data);
        $this->load->view('layout/default_footer');
    }


}
