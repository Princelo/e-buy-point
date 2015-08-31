<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

    public function sent_sms_for_register_sub_member()
    {
        check_access_right('user', $this->session);
        if (!$this->input->post('mobile'))
        {
            exit('{"state":"error","message":"no mobile no."}');
        }
        if ($this->session->userdata('last_sent_sub_member') != "" &&
            ( time() - intval($this->session->userdata('last_sent_sub_member')) < 50 ) ) {
            exit('{"state":"error", "message":"time limited"}');
        }
        $this->load->helper('sms');
        $this->load->helper('string');
        $this->load->database();
        $code = random_string('numeric', 6);
        $this->db->query('delete from '.DB_PREFIX."sms_verification where unix_timestamp(create_time) < ".(time() - 3600));
        $query = $this->db->query(
            "insert into ".DB_PREFIX."sms_verification (code, mobile) value (?, ?)",
            [
                $code,
                $this->input->post('mobile'),
            ]
        );
        if ($query === true) {
            $param_arr = [
                'title' => 'M平台',
                'code'  => $code,
                'time'  => '60',
            ];
            $result = sms_send(1, $this->input->post('mobile'), $param_arr);
            if ($result === true) {
                $this->session->set_userdata('last_sent_sub_member', time());
                exit('{"state":"success", "message": "success"}');
            } else {
                exit('{"state":"error", "message": "error code: '.$result.', code: '.$code.'"}');
            }
        } else {
            exit('{"state":"error", "message":"db error"}');
        }
    }

    public function sent_sms_for_register_sub_biz()
    {
        check_access_right('seller', $this->session);
        if (!$this->input->post('mobile'))
        {
            exit('{"state":"error","message":"no mobile no."}');
        }
        if ($this->session->userdata('last_sent_sub_biz') != "" &&
            ( time() - intval($this->session->userdata('last_sent_sub_biz')) < 50 ) ) {
            exit('{"state":"error", "message":"time limited"}');
        }
        $this->load->helper('sms');
        $this->load->helper('string');
        $this->load->database();
        $code = random_string('numeric', 6);
        $this->db->query('delete from '.DB_PREFIX."sms_verification where unix_timestamp(create_time) < ".(time() - 3600));
        $query = $this->db->query(
            "insert into ".DB_PREFIX."sms_verification (code, mobile) value (?, ?)",
            [
                $code,
                $this->input->post('mobile'),
            ]
        );
        if ($query === true) {
            $param_arr = [
                'title' => 'M平台',
                'code'  => $code,
                'time'  => '60',
            ];
            $result = sms_send(1, $this->input->post('mobile'), $param_arr);
            if ($result === true) {
                $this->session->set_userdata('last_sent_sub_biz', time());
                exit('{"state":"success", "message": "success"}');
            } else {
                exit('{"state":"error", "message": "error code: '.$result.', code: '.$code.'"}');
            }
        } else {
            exit('{"state":"error", "message":"db error"}');
        }
    }

    public function sent_sms_for_consumption()
    {
        check_access_right('user', $this->session);
        if (!$this->input->post('mobile'))
        {
            exit('{"state":"error","message":"no mobile no."}');
        }
        if ($this->session->userdata('last_sent_sub_member') != "" &&
            ( time() - intval($this->session->userdata('last_sent_sub_member')) < 50 ) ) {
            exit('{"state":"error", "message":"time limited"}');
        }
        $this->load->helper('sms');
        $this->load->helper('string');
        $this->load->database();
        $code = random_string('numeric', 6);
        $this->db->query('delete from '.DB_PREFIX."sms_verification where unix_timestamp(create_time) < ".(time() - 3600));
        $query = $this->db->query(
            "insert into ".DB_PREFIX."sms_verification (code, mobile) value (?, ?)",
            [
                $code,
                $this->input->post('mobile'),
            ]
        );
        if ($query === true) {
            $param_arr = [
                'title' => 'M平台',
                'code'  => $code,
                'time'  => '60',
            ];
            $result = sms_send(1, $this->input->post('mobile'), $param_arr);
            if ($result === true) {
                $this->session->set_userdata('last_sent_sub_member', time());
                exit('{"state":"success", "message": "success"}');
            } else {
                exit('{"state":"error", "message": "error code: '.$result.', code: '.$code.'"}');
            }
        } else {
            exit('{"state":"error", "message":"db error"}');
        }
    }
}
