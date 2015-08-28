<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addSeller($data)
    {
        $sql = "";
        $sql .= "insert into ".DB_PREFIX."seller (user_name, user_pwd, mobile, email, citizen_id, name)
        values
        (?, ?, ?, ?, ?, ?);";
        $this->db->query($sql
            , [
               $data['user_name'],
                $data['user_pwd'],
                $data['mobile'],
                $data['email'],
                $data['citizen_id'],
                $data['name'],
            ]);
        return $this->db->affected_rows() > 0;
    }



}