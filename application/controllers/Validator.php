<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validator extends CI_Controller {

    /*public function index()
    {
        $this->load->helper('url');
        $consumption_form_url = site_url(['consumption', 'input']);
        $view_data = [];
        $view_data['consumption_form_url'] = $consumption_form_url;
        $this->load->view('layout/default_header');
        $this->load->view('consumption/index', $view_data);
        $this->load->view('layout/default_footer');
    }*/

    public function check_consumer_name()
    {
        check_access_right('user', $this->session);
        $this->load->database();
        $query = $this->db->query("select id from ".DB_PREFIX."user where user_name = ? ", [$this->input->get('consumer_name')]);
        if($query->num_rows() > 0)
            $this->output->set_header('HTTP/1.1 200 OK');
        else
            $this->output->set_status_header('400');
    }

    public function check_consumer_mobile()
    {
        check_access_right('user', $this->session);
        $this->load->database();
        $query = $this->db->query("select id from ".DB_PREFIX."user where mobile = ? limit 1", [$this->input->get('mobile')]);
        if($query->num_rows() > 0)
            $this->output->set_header('HTTP/1.1 200 OK');
        else
            $this->output->set_status_header('400');
    }

    public function check_member_unique_username()
    {
        check_access_right('user', $this->session);
        $this->load->database();
        $query = $this->db->query("select id from ".DB_PREFIX."user where user_name = ? limit 1", [$this->input->get('user_name')]);
        if($query->num_rows() > 0)
            $this->output->set_status_header('400');
        else
            $this->output->set_header('HTTP/1.1 200 OK');
    }

    public function check_member_unique_email()
    {
        check_access_right('user', $this->session);
        $this->load->database();
        $query = $this->db->query("select id from ".DB_PREFIX."user where email = ? limit 1", [$this->input->get('email')]);
        if($query->num_rows() > 0)
            $this->output->set_status_header('400');
        else
            $this->output->set_header('HTTP/1.1 200 OK');
    }

    public function check_member_unique_mobile()
    {
        check_access_right('user', $this->session);
        $this->load->database();
        $query = $this->db->query("select id from ".DB_PREFIX."user where mobile = ? limit 1", [$this->input->get('mobile')]);
        if($query->num_rows() > 0)
            $this->output->set_status_header('400');
        else
            $this->output->set_header('HTTP/1.1 200 OK');
    }

}
