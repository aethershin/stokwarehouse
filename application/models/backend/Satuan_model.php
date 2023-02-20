<?php
class Satuan_model extends CI_Model{
	
	
	var $tablesatuan = 'tbl_satuan';
	var $column_search_satuan = array('id_satuan','nama_satuan'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		

		$this->db->from($this->tablesatuan);
		$i = 0;
		foreach ($this->column_search_satuan as $item) 
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

				if(count($this->column_search_satuan) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		
		$this->db->order_by('id_satuan', 'desc');
		
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
		$this->db->from($this->tablesatuan);
		return $this->db->count_all_results();
	}
	

    public function get_by_id($id_satuan)
	{
		$this->db->from($this->tablesatuan);
		$this->db->where('id_satuan',$id_satuan);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_satuan($arraysql){
		$insert = $this->db->insert($this->tablesatuan, $arraysql);
		if($insert){
			return true;
		}
	}
   	public function update($where, $arraysql)
	{
		$this->db->update($this->tablesatuan, $arraysql, $where);
		return $this->db->affected_rows();
	}
	public function delete_entry($id)
    {
        return $this->db->delete('tbl_satuan', array('id_satuan' => $id));
    }
	
	
	
}