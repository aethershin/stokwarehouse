<?php
class Login_user_model extends CI_Model{
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
    public function getUserInfo($id)
    {
        $q = $this->db->get_where('tbl_user', array('user_id' => $id), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return false;
        }
    }

    public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('tbl_user', array('user_email' => $email, 'user_status' => '1'), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        }
    }

    public function insertToken($user_id)
    {
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');

        $string = array(
            'token' => $token,
            'user_id' => $user_id,
            'created' => $date
        );
        $query = $this->db->insert_string('tokens', $string);
        $this->db->query($query);
        return $token . $user_id;
    }

    public function isTokenValid($token)
    {
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);

        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn,
            'tokens.user_id' => $uid
        ), 1);

        if ($this->db->affected_rows() > 0) {
            $row = $q->row();

            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);

            if ($createdTS != $todayTS) {
                return false;
            }

            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
        } else {
            return false;
        }
    }

    

    function change_password($user_id,$new_pass){
        $this->db->set('user_password', $new_pass);
        $this->db->where('user_id', $user_id);
        $this->db->update('tbl_user');
    }
    
    function delete_token($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->delete('tokens');
    }

} 