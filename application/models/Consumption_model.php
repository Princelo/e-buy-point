<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumption_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addConsumptionLog($data)
    {
        $query = $this->db->query('select consumption_ratio from '.DB_PREFIX.'supplier_location where id = ?', [$this->session->userdata('biz_id')]);
        $ratio = $query->result()[0]->consumption_ratio;
        $delta = bcmul(bcmul($data['volume'], $ratio, 4), '0.2');

        $sql_insert = "
                insert into " . DB_PREFIX . "biz_consume_log (biz_id, title, remark, consumer_name, consumer_id, volume, ratio)
                values (
                    ?, ?, ?, ?, ( select id from ".DB_PREFIX."user where user_name = ? ), ?, ?
                );
                ";
        $sql_insert_binds = [$this->session->userdata('biz_id'), $data['title'], $data['remark'], $data['consumer_name'],
            $data['consumer_name'], $data['volume'], $ratio];
        $sql_update_biz = "
                    update " . DB_PREFIX . "supplier_location set return_profit = return_profit
                        + ?
                    where id = (
                        select case when p_biz_id is null then 1 else p_biz_id end from " . DB_PREFIX . "user where user_name = ?
                    );
                    ";
        $sql_update_user = "
                    update " . DB_PREFIX . "user set score = score
                        + ?
                        where user_name = ?;
        ";
        $sql_update_binds = [
            $delta, $data['consumer_name'],
        ];
        $this->db->trans_start();
        $this->db->query($sql_insert, $sql_insert_binds);
        $this->db->query($sql_update_biz, $sql_update_binds);
        $this->db->query($sql_update_user, $sql_update_binds);
        $this->db->trans_complete();
        $result = $this->db->trans_status();
        if($result === true)
            return true;
        else
            return false;
    }

}