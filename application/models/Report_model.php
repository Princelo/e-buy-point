<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLastActionBySubMember($limit = 10)
    {
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title, l.remark, l.consumer_name, l.consumer_id, l.volume, l.ratio
                ,s.name, u.user_name, l.score, l.type
            from ".DB_PREFIX."biz_consume_log l,".DB_PREFIX."user u,".DB_PREFIX."supplier_location s
            where u.p_biz_id = ?
            and s.id = u.p_biz_id
            and l.consumer_id = u.id
            order by l.id desc limit ?
        ";
        $binds = [
            $this->session->userdata('biz_id'),
            $limit
        ];
        $query = $this->db->query($sql, $binds);
        return $query->result();
    }

    public function getLastActionByMember($limit = 10)
    {
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title, l.remark, l.consumer_name, l.consumer_id, l.volume, l.ratio
                ,s.name, u.user_name, l.score, l.type
            from ".DB_PREFIX."biz_consume_log l,".DB_PREFIX."user u,".DB_PREFIX."supplier_location s
            where 1 = 1
            and s.id = u.p_biz_id
            and l.consumer_id = u.id order by l.id desc limit ?
        ";
        $binds = [
            $limit
        ];
        $query = $this->db->query($sql, $binds);
        return $query->result();
    }

    public function getActionBySubMember()
    {
        $datetime = new \DateTime(date('Y-m-1'));
        $start = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end = $datetime->getTimestamp();
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title, l.remark, l.consumer_name, l.consumer_id, l.volume, l.ratio
                ,s.name, u.user_name, l.score, l.type
            from ".DB_PREFIX."biz_consume_log l,".DB_PREFIX."user u,".DB_PREFIX."supplier_location s
            where u.p_biz_id = ?
            and s.id = l.biz_id
            and l.consumer_id = u.id
            and unix_timestamp(l.create_time) between ? and ?
            order by l.id desc
        ";
        $binds = [
            $this->session->userdata('biz_id'),
            $start, $end,
        ];
        $query = $this->db->query($sql, $binds);
        return $query->result();
    }

    public function getActionByMember()
    {
        $datetime = new \DateTime(date('Y-m-1'));
        $start = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end = $datetime->getTimestamp();
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title, l.remark, l.consumer_name, l.consumer_id, l.volume, l.ratio, l.type
                ,s.name, u.user_name, ps.name pname
            from ".DB_PREFIX."biz_consume_log l,".DB_PREFIX."user u,".DB_PREFIX."supplier_location s
            ,".DB_PREFIX."supplier_location ps
            where 1 = 1
            and ps.id = u.p_biz_id
            and s.id = l.biz_id
            and l.consumer_id = u.id
            and unix_timestamp(l.create_time) between ? and ?
            order by l.id desc
        ";
        $query = $this->db->query($sql, [$start, $end]);
        return $query->result();
    }

    public function getLocalConsumeLog()
    {
        $datetime = new \DateTime(date('Y-m-1'));
        $start = $datetime->getTimestamp();
        $datetime->modify('next month');
        $end = $datetime->getTimestamp();
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title, l.remark, l.consumer_name, l.consumer_id, l.volume, l.ratio
                ,s.name, u.user_name, l.score, l.type
            from ".DB_PREFIX."biz_consume_log l,".DB_PREFIX."user u,".DB_PREFIX."supplier_location s
            where l.biz_id = ?
            and l.biz_id = s.id
            and l.consumer_id = u.id
            and unix_timestamp(l.create_time) between ? and ?
            order by l.id desc
        ";
        $binds = [
            $this->session->userdata('biz_id'),
            $start, $end,
        ];
        $query = $this->db->query($sql, $binds);
        return $query->result();
    }

    public function getBizIncomes($where = '')
    {
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title, l.remark, l.consumer_name, l.consumer_id, l.volume, l.ratio
                ,s.name, u.user_name, l.score, l.type
            from ".DB_PREFIX."biz_consume_log l,".DB_PREFIX."user u,".DB_PREFIX."supplier_location s
            where 1 = 1
            and s.id = u.p_biz_id
            and l.consumer_id = u.id
            {$where}
            order by l.id desc
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}