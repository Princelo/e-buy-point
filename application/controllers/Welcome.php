<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
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
        $this->load->model('Report_model', 'Report_model');
        $view_data['action_logs'] = $this->Report_model->getLastActionBySubMember(10);
        $query = $this->db->query("select name, address, tel, contact from ".DB_PREFIX."supplier_location where id = ? limit 1",
            [$this->session->userdata('biz_id')]);
        $auth_data = $query->result()[0];
        $view_data['auth_data'] = $auth_data;
		$this->load->view('layout/default_header');
		$this->load->view('welcome/index', $view_data);
		$this->load->view('layout/default_footer');
	}
}
