<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumption extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_access_right('user', $this->session);
    }
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $consumption_form_url = site_url(['consumption', 'input']);
        $consumer_validate_url = site_url(['validator', 'check_consumer_name']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['consumption_form_url'] = $consumption_form_url;
        $view_data['consumer_validate_url'] = $consumer_validate_url;
        $view_data['csrf'] = $csrf;
        $view_data['csrf_cookie_name'] = $csrf_cookie_name;
        $this->load->view('layout/default_header');
        $this->load->view('consumption/index', $view_data);
        $this->load->view('layout/default_footer');
    }

    public function input()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'consumer_name',
                'label' => '消费者会员名',
                'rules' => 'required|callback__check_consumer_name',
                'errors' => [
                                'required' => '消费者会员名不能为空',
                                'callback__check_consumer_name' => '找不到消费者会员'
                            ]
            ),
            array(
                'field' => 'volume',
                'label' => '消费金额',
                'rules' => 'required|callback__is_money',
                'errors' => array(
                    'required' => '%s必填',
                    'callback__is_money' => '%s无效',
                ),
            ),
            array(
                'field' => 'title',
                'label' => '消费名称',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s 必填',
                ],
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->load->helper('url');
            $consumption_form_url = site_url(['consumption', 'input']);
            $consumer_validate_url = site_url(['validator', 'check_consumer_name']);
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $csrf_cookie_name = $this->security->get_csrf_cookie_name();
            $view_data = [];
            $view_data['consumption_form_url'] = $consumption_form_url;
            $view_data['consumer_validate_url'] = $consumer_validate_url;
            $view_data['csrf'] = $csrf;
            $view_data['csrf_cookie_name'] = $csrf_cookie_name;
            $this->load->view('layout/default_header');
            $this->load->view($this->input->post('render_url'), $view_data);
            $this->load->view('layout/default_footer');
        } else {
            $this->load->model('consumption_model', 'Consumption_model');
            $this->Consumption_model->addConsumptionLog($this->input->post());
            $this->session->set_flashdata('flash_data', [ 'message' => '消费纪录录入成功', 'type' => 'success' ]);
            redirect($this->input->post('render_url'));
        }
    }

    public function _check_consumer_name()
    {
        $this->load->database();
        $this->db->select('id');
        $query = $this->db->get_where('user', ['user_name' => $this->input->post('consumer_name')]);
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function _is_money()
    {
        return (bool) preg_match('/(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/', $this->input->post('volume'));
    }
}
