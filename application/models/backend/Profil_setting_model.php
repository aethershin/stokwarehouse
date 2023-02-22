<?php
class Profil_setting_model extends CI_Model{
	
	
	function get_detail_profil($id){
		
		$this->db->select('tbl_user.*');
		$this->db->from('tbl_user');
		$this->db->where('user_id',$id);
		$query = $this->db->get();
		return $query;
	}
	function get_detail_profil_peserta($id){
		
		$this->db->select('tbl_user.*');
		$this->db->from('tbl_user');
		$this->db->where('user_id',$id);
		$query = $this->db->get();
		return $query;
	}
	function get_user_by_id($user_id){
		$query = $this->db->get_where('tbl_user', array('user_id' => $user_id));
		return $query;
	}
	public function update_entry($id, $data)
    {
        return $this->db->update('tbl_user', $data, array('user_id' => $id));
    }
	
	
    public function single_entry($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }

	
	
}