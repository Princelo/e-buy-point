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
        $delta = bcmul($data['volume'], $ratio);
        $pid = intval($this->db
                ->query("select p_biz_id from ".DB_PREFIX."user where mobile = ? limit 1", [$data['mobile']])
                ->result()[0]->p_biz_id);
        $is_self = ($pid === intval($this->session->userdata('biz_id')));

        $sql_insert = "
                insert into " . DB_PREFIX . "biz_consume_log (biz_id, title, remark, consumer_name, consumer_id, volume
                , ratio, pscore, uscore, lscore, mscore, sscore, pid, sid)
                values (
                    ?, ?, ?, (select user_name from ".DB_PREFIX."user where mobile = ?),
                     ( select id from ".DB_PREFIX."user where mobile = ? limit 1), ?, ?,
                     ?, ?, ?, ?, ?, ?,
                         (select p_seller_id from ".DB_PREFIX."supplier_location where id = ? )
                );
                ";
        if($is_self === true)
            $sql_insert_binds = [$this->session->userdata('biz_id'), $data['title'], $data['remark'], $data['mobile'],
                $data['mobile'], $data['volume'], $ratio, 0, $data['volume'], "-".$delta, bcmul($data['volume'], ($ratio - 1.5), 1),
                bcmul($data['volume'], 0.5, 0), $pid, $pid,
            ];
        else
            $sql_insert_binds = [$this->session->userdata('biz_id'), $data['title'], $data['remark'], $data['mobile'],
                $data['mobile'], $data['volume'], $ratio, $data['volume'], $data['volume'], "-".$delta, bcmul($data['volume'], ($ratio - 2.5), 1),
                bcmul($data['volume'], 0.5, 0), $pid, $pid,
            ];
        $sql_update_biz = "
                    update " . DB_PREFIX . "supplier_location set return_profit = return_profit
                        + ?
                    where id = ? limit 1;
                    ";
        $sql_update_biz_binds = [$data['volume'], $pid];
        $sql_update_user = "
                    update " . DB_PREFIX . "user set score = score
                        + ?
                        where mobile = ? limit 1;
        ";
        $sql_update_user_binds = [
            $data['volume'], $data['mobile'],
        ];
        $sql_update_seller = "
            update ".DB_PREFIX."seller set return_profit = return_profit + ? where id =
            (
                select p_seller_id from ".DB_PREFIX."supplier_location where id = ?
            )
        ";
        $sql_update_seller_binds = [
            bcmul($data['volume'], 0.5, 0), $pid,
        ];
        $sql_update_local_biz = "
            update ".DB_PREFIX."supplier_location set return_profit = return_profit - ? where id = ?
        ";
        $sql_update_local_biz_binds = [$delta, $this->session->userdata('biz_id')];
        $this->db->trans_begin();
        $this->db->query($sql_insert, $sql_insert_binds);
        if(!$is_self)
            $this->db->query($sql_update_biz, $sql_update_biz_binds);
        $this->db->query($sql_update_user, $sql_update_user_binds);
        $this->db->query($sql_update_seller, $sql_update_seller_binds);
        $this->db->query($sql_update_local_biz, $sql_update_local_biz_binds);
        $result = $this->db->trans_status();
        if($result === true){
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function addScoreConsumptionLog($data)
    {
        $sql_insert = "
            insert into ".DB_PREFIX."biz_consume_log (biz_id, title, remark, consumer_name, consumer_id, volume, ratio,
            score, type, pscore, uscore, lscore, mscore, sscore, pid, sid)
            values (
                ?, ?, ?, (select user_name from ".DB_PREFIX."user where mobile = ?),
                 ( select id from ".DB_PREFIX."user where mobile = ? limit 1), 0, 0,
                 ?, 1, 0, ?, ?, 0, 0, (select p_biz_id from ".DB_PREFIX."user where mobile = ? limit 1),
                 (select p_seller_id from ".DB_PREFIX."supplier_location where id =
                     (select p_biz_id from ".DB_PREFIX."user where mobile = ? limit 1)
                 )
            );
        ";
        $sql_insert_binds = [$this->session->userdata('biz_id'), $data['title'], $data['remark'], $data['mobile'],
            $data['mobile'], $data['score'], '-'.$data['score'], $data['score'], $data['mobile'], $data['mobile']];
        $sql_update_biz = "
                    update " . DB_PREFIX . "supplier_location set return_profit = return_profit
                        + ?
                    where id = ?
                    and (select score from ".DB_PREFIX."user where mobile = ? limit 1) >= ?;
                    ";
        $sql_update_user = "
                    update " . DB_PREFIX . "user set score = score
                        - ?
                        where mobile = ? and score >= ? limit 1;
        ";
        $this->db->trans_begin();
        $this->db->query($sql_insert, $sql_insert_binds);
        $this->db->query($sql_update_biz, [$data['score'], $this->session->userdata('biz_id'), $data['mobile'], $data['score']]);
        $this->db->query($sql_update_user, [$data['score'], $data['mobile'], $data['score']]);
        $result = $this->db->trans_status();
        if ($this->db->affected_rows() < 1) {
            $this->db->trans_rollback();
            return false;
        }
        if($result === true) {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getConsumptions($where = '', $limit = '', $order = ' order by l.id desc ')
    {
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title, l.remark, l.consumer_name, l.consumer_id, l.volume, l.ratio
                ,s.name, u.user_name, l.score, l.type, ps.name as pname,
                l.pscore, l.uscore, l.lscore, l.mscore, l.sscore,
                (select name from ".DB_PREFIX."seller where id = l.sid) as sname
            from ".DB_PREFIX."biz_consume_log l,".DB_PREFIX."user u,".DB_PREFIX."supplier_location s,".DB_PREFIX."supplier_location ps
            where 1 = 1
            and ps.id = u.p_biz_id
            and l.biz_id = s.id
            and l.consumer_id = u.id
            {$where}
            order by l.id desc
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getSubConsumptions($where = '', $limit = '', $order = ' order by l.id desc ')
    {
        $sql = "";
        $sql .= "
            select
                l.create_time time,
                l.title,
                l.remark,
                l.consumer_name,
                l.consumer_id,
                l.volume,
                l.ratio,
                s.name,
                u.user_name,
                l.score,
                l.type,
                l.sscore,
                l.*,
                (select name from ".DB_PREFIX."supplier_location where id = u.p_biz_id) as pname
            from ".DB_PREFIX."biz_consume_log l,
                 ".DB_PREFIX."user u,
                 ".DB_PREFIX."supplier_location s
            where 1 = 1
            and s.id = l.biz_id
            and l.consumer_id = u.id
            {$where}
            order by l.id desc
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

}