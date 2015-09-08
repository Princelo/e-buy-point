<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biz_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addSubBiz($data)
    {
        //$bdate = explode('-', $data['bdate']);
        $bdate = [0, 0, 0];
        $this->load->helper('string');
        $name = $data['name'];
        $name_arr = str_split($name, 3);
        $name_match = '';
        foreach($name_arr as $v)
            $name_match .= 'ux'.utf8_to_unicode($v);
        $cate = $this->db->query("select * from ".DB_PREFIX."deal_cate where id = ?", [$data['biz_type']])
            ->result()[0]->name;
        $cate_arr = str_split($name, 3);
        $cate_match = '';
        foreach($cate_arr as $v)
            $cate_match .= 'ux'.utf8_to_unicode($v);

        $sql_insert_supplier = "
            insert into ".DB_PREFIX."supplier
            (name, preview, content, sort, is_effect, city_id, name_match, name_match_row)
            values (?, '', '', 0, 1, 0, ?, ?);
        ";
        $sql_insert_supplier_binds = [
            $data['name'], $name_match, $data['name']
        ];
        $sql_insert_location = "
            insert into ".DB_PREFIX."supplier_location
            (name, address, tel, contact, supplier_id, name_match, name_match_row, p_seller_id, consumption_ratio,
            route, xpoint, ypoint, open_time, brief, is_main, api_address, city_id, deal_cate_match, deal_cate_match_row,
            locate_match, locate_match_row, deal_cate_id, preview, is_verify, tags, tags_match, tags_match_row, avg_point,
            good_dp_count, bad_dp_count, common_dp_count, total_point, dp_count, image_count, ref_avg_price, good_rate,
            common_rate, sms_content, index_img, tuan_count, event_count, youhui_count, daijin_count, seo_title,
            seo_keyword, seo_description, is_effect, biz_license, biz_other_license, new_dp_count, new_dp_count_time,
            shop_count, mobile_brief, sort, dp_group_point, tuan_youhui_cache, is_recommend)
            values
            (?, ?, ?, ?, last_insert_id(), ?, ?, ?, ?,
            '', '', '', '', '', 1, '', 1, ?, ?,
            '', '', ?, '', 0, '', '', '', '0.0000',
            0, 0, 0, 0, 0, 0, '0.0000', '0.0000', '0.0000', '', '', 0, 0, 0, 0, '',
            '', '', 0, '', '', 0, 0, 0, '', 0, '', '', 0);
            ";
        $sql_insert_location_binds = [
            $name, $data['address'], $data['tel'], $data['address'], $name_match, $name,
            $this->session->userdata('seller_id'), $data['consumption_ratio'], $cate_match, $cate, $data['biz_type']
        ];
        $sql_insert_account = "
            insert into ".DB_PREFIX."supplier_account ( account_name, account_password, supplier_id, is_effect,is_delete
            ,description, login_ip, login_time, update_time, allow_delivery, mobile, email)
            values(?, ?, (select supplier_id from ".DB_PREFIX."supplier_location where id = last_insert_id()), 1, 0,'',
            '', 0, 0, 1, ?, ?);
            ";
        $sql_insert_account_binds = [
            $data['user_name'], md5($data['user_pwd']), $data['mobile'], $data['email']
        ];
        $sql_insert_link = "
            insert into ". DB_PREFIX ."supplier_account_location_link (account_id, location_id)
            values (last_insert_id(),
                    (select id from ".DB_PREFIX."supplier_location where name = ? order by id desc limit 1)
                    )";
        $this->db->trans_begin();
        $this->db->query($sql_insert_supplier, $sql_insert_supplier_binds);
        $this->db->query($sql_insert_location, $sql_insert_location_binds);
        $this->db->query($sql_insert_account, $sql_insert_account_binds);
        $this->db->query($sql_insert_link, [$data['name']]);
        $result = $this->db->trans_status();
        if($result === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function getBizs($where = '')
    {
        $sql = "
            select
                s.id,
                a.account_name account,
                a.mobile mobile,
                a.email email,
                s.name,
                s.tel,
                s.contact,
                s.address,
                s.consumption_ratio ratio,
                s.return_profit,
                s.deal_cate_match_row
            from
                ".DB_PREFIX."supplier_account a, ".DB_PREFIX."supplier_account_location_link l, ".DB_PREFIX."supplier_location s
            where
                1 = 1
                and a.id = l.account_id
                and s.id = l.location_id
                {$where}
            ;
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function updateBizInfo($data)
    {
        /*$sql = "";
        $sql .= "update ".DB_PREFIX."supplier_location set address = ?,
            tel = ?, contact = ?;";
        $this->db->query($sql, [
            $data['address'],
            $data['tel'],
            $data['contact']
        ]);
        if($this->db->affected_rows() > 0)
            return true;
        else
            return false;
        */
    }

}