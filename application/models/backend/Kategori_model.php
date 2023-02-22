<?php
class Kategori_model extends CI_Model{
	
	
	var $tablekategori = 'tbl_kategori';
	var $column_search_kategori = array('id_kategori','nama_kategori'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		

		$this->db->from($this->tablekategori);
		$i = 0;
		foreach ($this->column_search_kategori as $item) 
		{
			if($_POST['search']['value']) 
			{
				if($i===0) 
				{	
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_kategori) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		
		$this->db->order_by('id_kategori', 'desc');
		
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->tablekategori);
		return $this->db->count_all_results();
	}
	

    public function get_by_id($id_kategori)
	{
		$this->db->from($this->tablekategori);
		$this->db->where('id_kategori',$id_kategori);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_kategori($arraysql){
		$insert = $this->db->insert($this->tablekategori, $arraysql);
		if($insert){
			return true;
		}
	}
   	public function update($where, $arraysql)
	{
		$this->db->update($this->tablekategori, $arraysql, $where);
		return $this->db->affected_rows();
	}
	public function delete_entry($id)
    {
        return $this->db->delete('tbl_kategori', array('id_kategori' => $id));
    }
	
	
	
}