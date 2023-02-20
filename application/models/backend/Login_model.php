<?php
class Login_model extends CI_Model{
    private $tbl_user_cgtv_122021 = 'tbl_user';
    function __construct() {
        parent::__construct();
    }
    
    function validasi_username($username_cgtv_122021)
    {
        
        $this->db->from($this->tbl_user_cgtv_122021);
        $this->db->where('user_email',$username_cgtv_122021);
        $this->db->limit(1);
        $result = $this->db->get();
        return $result;
    }
   
    function validasi_password($username_cgtv_122021,$password_cgtv_122021)
    {
        $this->db->from($this->tbl_user_cgtv_122021);
        $this->db->where('user_email',$username_cgtv_122021);
        $this->db->where('user_password',MD5($password_cgtv_122021));
        $this->db->limit(1);
        $result = $this->db->get();
        return $result;
    }
    function validasi_aktif($username_cgtv_122021,$password_cgtv_122021)
    {
        $this->db->from($this->tbl_user_cgtv_122021);
        $this->db->where('user_email',$username_cgtv_122021);
        $this->db->where('user_password',MD5($password_cgtv_122021));
        $this->db->where('user_status',1);
        $this->db->limit(1);
        $result = $this->db->get();
        return $result;
    }


} 