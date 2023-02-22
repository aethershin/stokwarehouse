<?php
class Detail_website_model extends CI_Model{
	
	
	function get_detail_website(){
		
		$this->db->select('detail_website.*');
		$this->db->from('detail_website');
		
		$this->db->order_by('detail_website_id ', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
	
	public function update_entry($id, $data)
    {
        return $this->db->update('detail_website', $data, array('detail_website_id' => $id));
    }
	
	
    public function single_entry($id)
    {
        $this->db->select('*');
        $this->db->from('detail_website');
        $this->db->where('detail_website_id', $id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    

	
	
}