<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
    }
    // redirect if needed, otherwise display the user list
    function index()
    {
        if (!$this->session->userdata('is_login')) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {
            redirect('welcome/index');
        }
    }
    // log the user in
    function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', '登录名', 'required');
        $this->form_validation->set_rules('user_pwd', '密码', 'required');
        if ($this->form_validation->run() == true) {
            if ($this->check_login($this->input->post('user_name'), $this->input->post('user_pwd'))) {
                redirect('welcome/index', 'refresh');
            } else {
                $this->session->set_flashdata('flash_data', [ 'type' => 'error', 'message' => '登录名或密码错误' ]);
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
                'cookie_name' => $this->security->get_csrf_cookie_name(),
            );
            $view_data = [];
            $view_data['csrf'] = $csrf;
            $this->load->view('auth/login', $view_data);
        }
    }
    // log the user out
    function logout()
    {
        $this->session->unset_userdata('is_login');
        $this->session->unset_userdata('biz_id');
        $this->session->unset_userdata('is_admin');
        redirect('auth/login', 'refresh');
    }
    // change password
    function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        $user = $this->ion_auth->user()->row();
        if ($this->form_validation->run() == false)
        {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id'   => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name'    => 'new',
                'id'      => 'new',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name'    => 'new_confirm',
                'id'      => 'new_confirm',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
            );
            // render
            $this->_render_page('auth/change_password', $this->data);
        }
        else
        {
            $identity = $this->session->userdata('identity');
            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    function check_login($user, $password)
    {
        $sql = "
            select id from fanwe_supplier_location where name = (
                select merchant_name from fanwe_user where is_merchant = 1 and user_pwd = ? and user_name = ?
                ) and name is not null limit 1";
        $binds = [ md5($password), $user ];
        $query = $this->db->query($sql, $binds);
        if($query->num_rows() > 0) {
            $this->session->set_userdata('is_login', 1);
            $this->session->set_userdata('biz_id', $query->result()[0]->id);
            return true;
        } else
            return false;
    }
}