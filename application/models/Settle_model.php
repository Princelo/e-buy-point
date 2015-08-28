<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settle_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getSettleLogs($where)
    {
        $sql = "
            select l.volume, l.id, l.create_time, s.name
            from ".DB_PREFIX."settle_biz_log l, ".DB_PREFIX."supplier_location s
            where s.id = l.biz_id
            {$where}
            order by l.id desc
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getSettleLogsSeller($where)
    {
        $sql = "
            select l.volume, l.id, l.create_time, s.user_name
            from ".DB_PREFIX."settle_seller_log l, ".DB_PREFIX."seller s
            where s.id = l.seller_id
            {$where}
            order by l.id desc
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}