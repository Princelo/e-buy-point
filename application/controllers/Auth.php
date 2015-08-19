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
        $this->load->library('form_validation');
        if (!$this->_check_password()) {
            $this->session->set_flashdata('flash_data', [ 'type' => 'error', 'message' => '原密码错误' ]);
            redirect('setting/change_password');
        }
        $this->form_validation->set_rules('user_pwd', '原密码', 'required|trim');
        $this->form_validation->set_rules('new_pwd', '新密码', 'required|trim');
        $this->form_validation->set_rules('new_pwd_confirm', '确认新密码', 'required|matches[new_pwd]');
        if ($this->form_validation->run() == true) {
            $sql = "update ".DB_PREFIX."user u set user_pwd = ? where
                is_merchant = 1 and merchant_name =
                    (
                    select name from ".DB_PREFIX."supplier where id =
                        (select supplier_id from ".DB_PREFIX."supplier_location where id = ?)
                    )
            ";
            $this->db->query($sql, [
                md5($this->input->post('new_pwd')),
                $this->session->userdata('biz_id')
            ]);
            if($this->db->affected_rows() > 0)
                $this->session->set_flashdata('flash_data', [ 'type' => 'success', 'message' => '修改密码成功' ]);
            else
                $this->session->set_flashdata('flash_data', [ 'type' => 'error', 'message' => '修改密码失败，请资询平台管理员' ]);
            redirect('setting/change_password');
        } else {
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
    }

    function check_login($user, $password)
    {
        $sql = "
            select id from ".DB_PREFIX."supplier_location where name = (
                select merchant_name from ".DB_PREFIX."user where is_merchant = 1 and user_pwd = ? and user_name = ?
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

    public function _check_password()
    {
        $sql = "select u.id from ".DB_PREFIX."user u, ".DB_PREFIX."supplier_location s
            where u.user_pwd = ? and s.id = ? and u.is_merchant = 1 and u.merchant_name = s.name
            and s.name is not null
            limit 1";
        $binds = [md5($this->input->post('user_pwd'), $this->session->userdata('biz_id'))];
        $query = $this->db->query($sql, $binds);
        if($query->num_rows() > 0) {
            return true;
        } else
            return false;
    }
}