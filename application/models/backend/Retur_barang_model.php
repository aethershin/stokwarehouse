<?php
class Retur_barang_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	
	var $tablelist_retur_barang = 'tbl_list_retur_barang';
	var $tablelog = 'tbl_log';
	var $column_search_tablelist_retur_barang = array('bahan_baku_id'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->tablelist_retur_barang);
		$i = 0;
		foreach ($this->column_search_tablelist_retur_barang as $item) 
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

				if(count($this->column_search_tablelist_retur_barang) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$id = $this->session->userdata('id');
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_list_retur_barang.retur_bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->order_by('retur_id', 'desc');
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_filtered()
	{
		$id = $this->session->userdata('id');
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$id = $this->session->userdata('id');
		$this->db->from($this->tablelist_retur_barang);
		return $this->db->count_all_results();
	}
	function get_all_karyawan(){
		$this->db->select('tbl_user.*');
		$this->db->from('tbl_user');
		$this->db->order_by('user_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
    function insert_log_stock($data2){
		$insert = $this->db->insert($this->tablelog, $data2);
		if($insert){
			return true;
		}
	}

	function get_all_bbaku(){
		$this->db->select('tbl_stock.*');
		$this->db->from('tbl_stock');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_produksi(){
		$this->db->select('tbl_stock_produksi.*,nama_satuan');
		$this->db->from('tbl_stock_produksi');
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_ksuratjalan(){
		$this->db->select('tbl_surat_jalan.*');
		$this->db->from('tbl_surat_jalan');
		$this->db->order_by('surat_jalan_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}

    
	function insert_stock($data2){
		$insert = $this->db->insert($this->tablelist_retur_barang, $data2);

		if($insert){
			return true;
		}
	}
	
	
    public function update_entry_stocks($bahan_baku, $ajax_data_stocks)
    {
        return $this->db->update('tbl_stock_produksi', $ajax_data_stocks, array('kode_stock' => $bahan_baku));
        
       
    }
	public function single_entry($ls_surat_jalan_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_list_retur_barang');
        $this->db->where('retur_id', $ls_surat_jalan_id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    
  
    function get_stocks($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,id_stock,stock FROM tbl_stock_produksi WHERE kode_stock='$bahan_baku'");
    	return $result;
    }
 
    function get_stocks_produksi($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,id_stock,stock FROM tbl_stock_produksi WHERE kode_stock='$bahan_baku'");
    	return $result;
    }
   
   
    public function delete_entry($ls_surat_jalan_id)
    {
   
        return $this->db->delete('tbl_list_retur_barang', array('retur_id' => $ls_surat_jalan_id));
    }
   
   
  

}

	
