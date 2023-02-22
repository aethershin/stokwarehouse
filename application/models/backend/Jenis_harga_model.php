<?php
class Jenis_harga_model extends CI_Model{
	
	
	var $tablejenisharga = 'tbl_jenis_harga';
	var $column_search_jenisharga = array('id_jenis_harga','nama_jenis_harga','jenis_harga'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		

		$this->db->from($this->tablejenisharga);
		$i = 0;
		foreach ($this->column_search_jenisharga as $item) 
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

				if(count($this->column_search_jenisharga) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_jenis_harga.kategori_jenis' , 'left' );
		$this->db->order_by('id_jenis_harga', 'desc');
		
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
		$this->db->from($this->tablejenisharga);
		return $this->db->count_all_results();
	}
	
	function get_new_kode_jharga(){
        
        $query = $this->db->query("SELECT max(kode_jharga) as maxKode FROM tbl_jenis_harga");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
                            
    }
    public function get_by_id($kode_jharga)
	{
		$this->db->from($this->tablejenisharga);
		$this->db->where('kode_jharga',$kode_jharga);
		$query = $this->db->get();
		return $query->row();
	}
	public function single_entry($check_id_edit)
    {
        $this->db->select('*');
        $this->db->from('tbl_jenis_harga');
        $this->db->where('kode_jharga', $check_id_edit);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
	function insert($arraysql){
		$insert = $this->db->insert($this->tablejenisharga, $arraysql);
		if($insert){
			return true;
		}
	}
   	public function update($where, $arraysql)
	{
		$this->db->update($this->tablejenisharga, $arraysql, $where);
		return $this->db->affected_rows();
	}
	public function delete_entry($check_id_edit)
    {
        return $this->db->delete('tbl_jenis_harga', array('kode_jharga' => $check_id_edit));
    }
	
	function get_all_produksi(){
		$this->db->select('tbl_stock_produksi.*');
		$this->db->from('tbl_stock_produksi');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
}