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
        $consumer_validate_url = site_url(['validator', 'check_consumer_mobile']);
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $csrf_cookie_name = $this->security->get_csrf_cookie_name();
        $view_data = [];
        $view_data['sms_url'] = site_url('sms/sent_sms_for_consumption');
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
            /*array(
                'field' => 'consumer_name',
                'label' => '消费者会员名',
                'rules' => 'required|callback__check_consumer_name',
                'errors' => [
                                'required' => '消费者会员名不能为空',
                                'callback__check_consumer_name' => '找不到消费者会员'
                            ]
            ),*/
            array(
                'field' => 'mobile',
                'label' => '消费会员手机号码',
                'rules' => 'required|callback__check_consumer_mobile',
                'errors' => [
                    'required' => '消费会员手机号码不能为空',
                    'callback__check_consumer_name' => '找不到消费会员手机号吗'
                ]
            ),
            /*array(
                'field' => 'verify_code',
                'label' => '手机验证码',
                'rules' => 'required|callback__check_vcode|trim',
                'errors' => [
                    'required' => '%s 必填',
                    'callback__check_vcode' => '%s 无效',
                ],
            ),*/
            /*array(
                'field' => 'volume',
                'label' => '消费金额',
                'rules' => 'required|callback__is_money',
                'errors' => array(
                    'required' => '%s必填',
                    'callback__is_money' => '%s无效',
                ),
            ),*/
            [
                'field' => 'exchange_type',
                'label' => '交易媒介',
                'rules' => 'required|trim|is_natural|less_than[2]',
            ],
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
        if($this->input->post('exchange_type') === '1')
            $this->form_validation->set_rules('score', '消费积分', 'required|trim|is_natural_no_zero|callback__is_score_enough');
        else
            $this->form_validation->set_rules('volume', '消费金额', 'required|trim|callback__is_money');
        if ($this->form_validation->run() == FALSE) {
            $this->load->helper('url');
            $consumption_form_url = site_url(['consumption', 'input']);
            $consumer_validate_url = site_url(['validator', 'check_consumer_mobile']);
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $csrf_cookie_name = $this->security->get_csrf_cookie_name();
            $view_data = [];
            $view_data['sms_url'] = site_url('sms/sent_sms_for_consumption');
            $view_data['consumption_form_url'] = $consumption_form_url;
            $view_data['consumer_validate_url'] = $consumer_validate_url;
            $view_data['csrf'] = $csrf;
            $view_data['csrf_cookie_name'] = $csrf_cookie_name;
            $this->load->view('layout/default_header');
            $this->load->view($this->input->post('render_url'), $view_data);
            $this->load->view('layout/default_footer');
        } else {
            $this->load->model('consumption_model', 'Consumption_model');
            if($this->input->post('exchange_type') === '1'){
                $result = $this->Consumption_model->addScoreConsumptionLog($this->input->post());
                $arr = [
                    "title" => 'M网',
                    "volume" => $this->input->post('score')."分",
                    "store" => $this->session->userdata('display_name'),
                    "total" => $this->db->query("
                        select score from ".DB_PREFIX."user where mobile = '".$this->input->post('mobile') ."' limit 1
                        ")->result()[0]->score."分",
                ];
            } else {
                $result = $this->Consumption_model->addConsumptionLog($this->input->post());
                $arr = [
                    "title" => 'M网',
                    "volume" => $this->input->post('volume')."元",
                    "reward" => $this->input->post('volume')."分",
                    "store" => $this->session->userdata('display_name'),
                    "total" => $this->db->query("
                        select score from ".DB_PREFIX."user where mobile = '".$this->input->post('mobile') ."' limit 1
                        ")->result()[0]->score."分",
                ];
            }
            $this->load->helper('sms');
            if($result === true) {
                $this->session->set_flashdata('flash_data', [ 'message' => '消费纪录录入成功', 'type' => 'success' ]);
                if($this->input->post('exchange_type') === '1')
                    sms_quick_send(2, $this->input->post('mobile'), $arr);
                else
                    sms_quick_send(3, $this->input->post('mobile'), $arr);
            }
            if($result === false)
                $this->session->set_flashdata('flash_data', [ 'message' => '消费纪录录入失败，请资讯平台管理员', 'type' => 'error' ]);
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

    public function _check_consumer_mobile()
    {
        $this->load->database();
        $this->db->select('id');
        $query = $this->db->get_where('user', ['mobile' => $this->input->post('mobile')]);
        if($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function _is_money()
    {
        return (bool) preg_match('/(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/', $this->input->post('volume'));
    }

    public function _check_vcode()
    {
        $this->db->query("delete from ".DB_PREFIX."sms_verification where create_time < ? ", [date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'] - 3600)]);
        $query = $this->db->query("select id from ".DB_PREFIX."sms_verification where code = ? and mobile = ? order by create_time desc limit 1",
            [$this->input->post('verify_code'), $this->input->post('mobile')]);
        if($query->num_rows() > 0)
            return true;
        else {
            return false;
        }
    }

    public function _is_score_enough()
    {
        $is_enough = (bool) intval($this->db->query("select score from ".DB_PREFIX."user where mobile = ? limit 1",
            [$this->input->post('mobile')])->result()[0]->score) >= intval($this->input->post('score'));
        if(!$is_enough) {
            $this->session->set_flashdata('flash_data', [ 'message' => '该会员积分不足，消费录入失败', 'type' => 'error' ]);
            return false;
        } else {
            return $is_enough;
        }
    }
}
