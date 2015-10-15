<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addSubMember($data)
    {
        $sql = "";
        $sql .= "
            insert into ".DB_PREFIX."user (user_name, user_pwd, create_time, update_time, group_id, is_effect, is_delete,
                email, mobile, score, money, pid, login_time, referral_count, integrate_id, verify_create_time, referer,
                login_pay_time, focus_count, focused_count, province_id, city_id, sex, is_merchant, is_daren, step, byear,
                bmonth, bday, locate_time, xpoint, ypoint, topic_count, fav_count, faved_count, dp_count, insite_count,
                outsite_count, level_id, point, is_syn_sina, is_syn_tencent, p_biz_id, login_ip, verify, code, password_verify,
                sina_id, renren_id, kaixin_id, sohu_id, lottery_mobile, lottery_verify, tencent_id, my_intro, merchant_name,
                daren_title, sina_app_key, sina_app_secret, tencent_app_key, tencent_app_secret, sina_token, t_access_token,
                t_openkey, t_openid, qq_id)
                values (?, ?, ?, ?, 1, 1, 0, ?, ?, 0, '0.0000', 0, 0, 0, 0, 0, 'point', 0,
                0, 0, 0, 0, ?, 0, 0, 1, ?, ?, ?, 0, '0.000000', '0.000000', 0, 0, 0, 0, 0, 0, 2, 0, 0,
                0, ?, '127.0.0.1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        ";
        $date_arr = explode('-', $data['bdate']);
        $binds = [
            $data['user_name'],
            md5($data['user_pwd']),
            $_SERVER['REQUEST_TIME'],
            $_SERVER['REQUEST_TIME'],
            $data['email'],
            $data['mobile'],
            $data['gender'],
            $date_arr[0],
            $date_arr[1],
            $date_arr[2],
            $this->session->userdata('biz_id'),
        ];
        $query = $this->db->query($sql, $binds);
        if($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function updateMemberInfo($data, $biz_id)
    {
        $sql = "";
        $sql .= "update ".DB_PREFIX."supplier_location set address = ?,
            tel = ?, contact = ? where id = ?;";
        $this->db->query($sql, [
            $data['address'],
            $data['tel'],
            $data['contact'],
            $biz_id
        ]);
        if($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function getMembers($where = '', $limit = '', $order = '', $field = ' id, user_name, email, mobile, score, p_biz_id ')
    {
        $sql = "";
        $sql .= "
            select {$field} from ".DB_PREFIX."user where 1 = 1 {$where} {$order} {$limit};
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }


}