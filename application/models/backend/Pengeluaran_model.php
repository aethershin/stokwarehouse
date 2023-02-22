<?php
class Pengeluaran_model extends CI_Model{
	
	
	var $tablepengeluaran = 'tbl_pengeluaran';
	var $column_search_pengeluaran = array('id_pengeluaran','id_user_pengeluaran'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		//add custom filter here
		if($this->input->post('id_user_pengeluaran'))
		{
			$this->db->like('id_user_pengeluaran', $this->input->post('id_user_pengeluaran'));
		}

		$this->db->from($this->tablepengeluaran);
		$i = 0;
		foreach ($this->column_search_pengeluaran as $item) 
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

				if(count($this->column_search_pengeluaran) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_pengeluaran.id_user_pengeluaran' , 'left' );
		$this->db->order_by('id_pengeluaran', 'desc');
		
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
		$this->db->from($this->tablepengeluaran);
		return $this->db->count_all_results();
	}
	function get_all_karyawan(){
		$dev = 'Zikry';
		$this->db->select('tbl_user.*');
		$this->db->from('tbl_user');
		$this->db->where_not_in ( 'user_name', $dev);
		$this->db->order_by('user_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	public function single_entry($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_pengeluaran');
        $this->db->where('id_pengeluaran', $id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    public function get_by_id($id_pengeluaran)
	{
		$this->db->from($this->tablepengeluaran);
		$this->db->where('id_pengeluaran',$id_pengeluaran);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_pengeluaran($arraysql){
		$insert = $this->db->insert($this->tablepengeluaran, $arraysql);
		if($insert){
			return true;
		}
	}
   	public function update_entry($pengeluaranid, $ajax_data)
    {
        return $this->db->update('tbl_pengeluaran', $ajax_data, array('id_pengeluaran' => $pengeluaranid));
    }
	public function delete_entry($id)
    {
        return $this->db->delete('tbl_pengeluaran', array('id_pengeluaran' => $id));
    }
	
	function get_all_bukti(){
	
		$this->db->select('tbl_pengeluaran.*');
		$this->db->from('tbl_pengeluaran');
		$query = $this->db->get();
		return $query;
	}
	
}