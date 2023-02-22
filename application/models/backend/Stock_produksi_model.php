<?php
class Stock_produksi_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	
	var $tablestock_produksi = 'tbl_stock_produksi';
	var $tablelog = 'tbl_log';
	var $column_search_stock = array('nama_stock','kategori_stock','stock','stock_minimal'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		//add custom filter here
		if($this->input->post('nama_stock2'))
		{
			$this->db->like('nama_stock', $this->input->post('nama_stock2'));
		}
		if($this->input->post('kategori_stock2'))
		{
			$this->db->where('kategori_stock', $this->input->post('kategori_stock2'));
		}

		
		

		
		$this->db->from($this->tablestock_produksi);
		$i = 0;
		foreach ($this->column_search_stock as $item) 
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

				if(count($this->column_search_stock) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$this->db->join ( 'tbl_kategori', 'tbl_kategori.id_kategori = tbl_stock_produksi.kategori_stock' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_stock_produksi.user_id_stock' , 'left' );
		$this->db->order_by('id_stock', 'desc');
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
		$this->db->from($this->tablestock_produksi);
		return $this->db->count_all_results();
	}
	function count_all_biaya(){
        $query = $this->db->query("SELECT SUM(nilai_saham) AS biaya FROM tbl_stock_produksi");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    
	function get_all_kategori(){
		$this->db->select('tbl_kategori.*');
		$this->db->from('tbl_kategori');
		
		$this->db->order_by('id_kategori', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_satuan(){
		$this->db->select('tbl_satuan.*');
		$this->db->from('tbl_satuan');
		$this->db->order_by('id_satuan', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_new_kode_stock(){
        
        $query = $this->db->query("SELECT max(kode_stock) as maxKode FROM tbl_stock_produksi");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
                            
    }
    public function get_by_id($kode_stock)
	{
		$this->db->from($this->tablestock_produksi);
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_stock_produksi.user_id_stock' , 'left' );
		$this->db->where('kode_stock',$kode_stock);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_stock($data){
		$insert = $this->db->insert($this->tablestock_produksi, $data);
		if($insert){
			return true;
		}
	}
	function insert_log_stock($data2){
		$insert = $this->db->insert($this->tablelog, $data2);
		if($insert){
			return true;
		}
	}
	public function update_entry($id, $data)
    {
        return $this->db->update('tbl_stock_produksi', $data, array('kode_stock' => $id));
    }
	public function single_entry($id_stock)
    {
        $this->db->select('*');
        $this->db->from('tbl_stock_produksi');
        $this->db->where('id_stock', $id_stock);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    public function delete_entry($id_stock)
    {
        return $this->db->delete('tbl_stock_produksi', array('id_stock' => $id_stock));
    }
    
  

	

}

	
