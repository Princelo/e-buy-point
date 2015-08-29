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
        /*if (!$this->session->userdata('is_login')) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {
            if($this->session->userdata('is_admin') == 1)
                redirect('admin/index', 'refresh');
            else
                redirect('welcome/index', 'refresh');
        }*/
    }
    // log the user in
    function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', '登录名', 'required');
        $this->form_validation->set_rules('user_pwd', '密码', 'required');
        if ($this->form_validation->run() == true) {
            if ($this->check_login($this->input->post('user_name'), $this->input->post('user_pwd'))) {
                if($this->session->userdata('is_admin') == 1)
                    redirect('admin/index', 'refresh');
                else
                    redirect('welcome/index', 'refresh');
            } else {
                $this->session->set_flashdata('flash_data', [ 'type' => 'error', 'message' => '登录名或密码错误' ]);
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            if ($this->session->userdata('is_login') != 1) {
                // redirect them to the login page
            } else {
                if($this->session->userdata('is_admin') == 1)
                    redirect('admin/index', 'refresh');
                else if (intval($this->session->userdata('biz_id')) > 0)
                    redirect('welcome/index', 'refresh');
                else
                    redirect('seller/index', 'refresh');
            }
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

    function seller_login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', '登录名', 'required');
        $this->form_validation->set_rules('user_pwd', '密码', 'required');
        if ($this->form_validation->run() == true) {
            if ($this->seller_check_login($this->input->post('user_name'), $this->input->post('user_pwd'))) {
                redirect('seller/index', 'refresh');
            } else {
                $this->session->set_flashdata('flash_data', [ 'type' => 'error', 'message' => '登录名或密码错误' ]);
                redirect('auth/seller_login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
                'cookie_name' => $this->security->get_csrf_cookie_name(),
            );
            $view_data = [];
            $view_data['csrf'] = $csrf;
            $this->load->view('auth/seller_login', $view_data);
        }
    }

    // log the user out
    function logout()
    {
        if(intval($this->session->userdata('seller_id')) > 0)
            $redirect = 'auth/seller_login';
        else
            $redirect = 'auth/login';
        $this->session->unset_userdata('is_login');
        $this->session->unset_userdata('biz_id');
        $this->session->unset_userdata('seller_id');
        $this->session->unset_userdata('is_admin');
        redirect($redirect, 'refresh');
    }

    // log the user out
    function seller_logout()
    {
        $this->session->unset_userdata('is_login');
        $this->session->unset_userdata('biz_id');
        $this->session->unset_userdata('seller_id');
        $this->session->unset_userdata('is_admin');
        redirect('auth/seller_login', 'refresh');
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
            $sql = "
                update ".DB_PREFIX."supplier_account a set account_password = ?
                    where supplier_id = (select supplier_id from ".DB_PREFIX."supplier_location where id = ? limit 1)
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

    // change password
    function seller_change_password()
    {
        $this->load->library('form_validation');
        if (!$this->_seller_check_password()) {
            $this->session->set_flashdata('flash_data', [ 'type' => 'error', 'message' => '原密码错误' ]);
            redirect('setting/seller_change_password');
        }
        $this->form_validation->set_rules('user_pwd', '原密码', 'required|trim');
        $this->form_validation->set_rules('new_pwd', '新密码', 'required|trim');
        $this->form_validation->set_rules('new_pwd_confirm', '确认新密码', 'required|matches[new_pwd]');
        if ($this->form_validation->run() == true) {
            $sql = "
                update ".DB_PREFIX."seller s set user_pwd = ? where id = ?
            ";
            $this->db->query($sql, [
                md5($this->input->post('new_pwd')),
                $this->session->userdata('seller_id')
            ]);
            if($this->db->affected_rows() > 0)
                $this->session->set_flashdata('flash_data', [ 'type' => 'success', 'message' => '修改密码成功' ]);
            else
                $this->session->set_flashdata('flash_data', [ 'type' => 'error', 'message' => '修改密码失败，请资询平台管理员' ]);
            redirect('setting/seller_change_password');
        } else {
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

    function check_login($user, $password)
    {
        $sql = "
            select id, name from ".DB_PREFIX."supplier_location where name = (
                select merchant_name from ".DB_PREFIX."user where is_merchant = 1 and user_pwd = ? and user_name = ?
                ) and name is not null limit 1";
        $sql = "
            select l.location_id id, (select name from ".DB_PREFIX."supplier_location where id = l.location_id) as name
             from ".DB_PREFIX."supplier_account a,".DB_PREFIX."supplier_account_location_link l
              where a.account_password = ? and a.account_name = ? and a.id = l.account_id
              limit 1
        ";
        $binds = [ md5($password), $user ];
        $query = $this->db->query($sql, $binds);
        if($query->num_rows() > 0) {
            $this->session->set_userdata('is_login', 1);
            $this->session->set_userdata('biz_id', $query->result()[0]->id);
            $this->session->set_userdata('display_name', $query->result()[0]->name);
            return true;
        } else {
            $sql = "select id from ".DB_PREFIX."admin where adm_name = ? and adm_password = ? limit 1";
            $query = $this->db->query($sql, [$user, md5($password)]);
            if($query->num_rows() > 0) {
                $this->session->set_userdata('is_login', 1);
                $this->session->set_userdata('is_admin', 1);
                $this->session->set_userdata('display_name', '管理员');
                return true;
            } else {
                return false;
            }
        }
    }

    function seller_check_login($user, $password)
    {
        $sql = "select id,name from ".DB_PREFIX."seller where user_name = ? and user_pwd = ? limit 1";
        $binds = [ $user, md5($password) ];
        $query = $this->db->query($sql, $binds);
        if($query->num_rows() > 0) {
            $this->session->set_userdata('is_login', 1);
            $this->session->set_userdata('seller_id', $query->result()[0]->id);
            $this->session->set_userdata('display_name', $query->result()[0]->name);
            return true;
        } else {
            return false;
        }
    }

    public function _check_password()
    {
        $sql = "select u.id from ".DB_PREFIX."user u, ".DB_PREFIX."supplier_location s
            where u.user_pwd = ? and s.id = ? and u.is_merchant = 1 and u.merchant_name = s.name
            and s.name is not null
            limit 1";
        $sql = "select a.id from ".DB_PREFIX."supplier_account a, ".DB_PREFIX."supplier_account_location_link l
        where l.account_id = a.id and a.account_password = ? and l.location_id = ? limit 1";
        $binds = [md5($this->input->post('user_pwd')), $this->session->userdata('biz_id')];
        $query = $this->db->query($sql, $binds);
        if($query->num_rows() > 0) {
            return true;
        } else
            return false;
    }

    public function _seller_check_password()
    {
        $sql = "select s.id from ".DB_PREFIX."seller s where user_pwd = ? and id = ? limit 1 ";
        $binds = [md5($this->input->post('user_pwd')), $this->session->userdata('seller_id')];
        $query = $this->db->query($sql, $binds);
        if($query->num_rows() > 0) {
            return true;
        } else
            return false;
    }
}