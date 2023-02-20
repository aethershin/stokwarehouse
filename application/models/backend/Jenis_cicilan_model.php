<?php
class Jenis_cicilan_model extends CI_Model{
	
	
	var $tablejeniscicilan = 'tbl_jenis_cicilan';
	var $column_search_jeniscicilan = array('id_jenis_cicilan','nama_cicilan'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		

		$this->db->from($this->tablejeniscicilan);
		$i = 0;
		foreach ($this->column_search_jeniscicilan as $item) 
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

				if(count($this->column_search_jeniscicilan) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		
		$this->db->order_by('id_jenis_cicilan', 'desc');
		
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
		$this->db->from($this->tablejeniscicilan);
		return $this->db->count_all_results();
	}
	

    public function get_by_id($id_jenis_cicilan)
	{
		$this->db->from($this->tablejeniscicilan);
		$this->db->where('id_jenis_cicilan',$id_jenis_cicilan);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_jcicilan($arraysql){
		$insert = $this->db->insert($this->tablejeniscicilan, $arraysql);
		if($insert){
			return true;
		}
	}
   	public function update($where, $arraysql)
	{
		$this->db->update($this->tablejeniscicilan, $arraysql, $where);
		return $this->db->affected_rows();
	}
	public function delete_entry($id)
    {
        return $this->db->delete('tbl_jenis_cicilan', array('id_jenis_cicilan' => $id));
    }
	
	
	
}