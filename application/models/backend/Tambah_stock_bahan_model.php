<?php
class Tambah_stock_bahan_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	
	var $tableaddstock = 'tbl_add_stock';
	var $tablelog = 'tbl_log';
	var $column_search_addstock = array('bahan_baku_id'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->tableaddstock);
		$i = 0;
		foreach ($this->column_search_addstock as $item) 
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

				if(count($this->column_search_addstock) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$id = $this->session->userdata('id');
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_add_stock.bahan_baku_id' , 'left' );
		$this->db->where('check_proses', 0);
		$this->db->where('add_stock_stock_user_id', $id);
		$this->db->order_by('add_stock_id', 'desc');
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
		$this->db->where('check_proses', 0);
		$this->db->where('add_stock_stock_user_id', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$id = $this->session->userdata('id');
		$this->db->from($this->tableaddstock);
		$this->db->where('check_proses', 0);
		$this->db->where('add_stock_stock_user_id', $id);
		return $this->db->count_all_results();
	}
	
	function get_new_kode_add_stock(){
        
        $query = $this->db->query("SELECT max(kode_add_stock_selesai) as maxKode FROM tbl_selesai_add_stock");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
                            
    }
    function insert_log_stock($data2){
		$insert = $this->db->insert($this->tablelog, $data2);
		if($insert){
			return true;
		}
	}
    function count_produksi_belum_selesai(){
    	$id = $this->session->userdata('id');
        $query = $this->db->query("SELECT COUNT(*) produksi FROM tbl_add_stock WHERE check_proses=0 AND add_stock_stock_user_id='$id'");
        return $query;
    }
	function get_all_bbaku(){
		$this->db->select('tbl_stock.*');
		$this->db->from('tbl_stock');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_produksi(){
		$this->db->select('tbl_stock_produksi.*');
		$this->db->from('tbl_stock_produksi');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
    
	function insert_stock($data2){
		$insert = $this->db->insert($this->tableaddstock, $data2);
		if($insert){
			return true;
		}
	}
	
	function get_kode_rekap($id){
		$query = $this->db->query("SELECT tbl_selesai_add_stock.* FROM tbl_selesai_add_stock 
			WHERE kode_add_stock_selesai='$id' GROUP BY kode_add_stock_selesai LIMIT 1");
		return $query;
	}
    public function update_entry_stocks($bahan_baku, $ajax_data_stocks)
    {
        return $this->db->update('tbl_stock', $ajax_data_stocks, array('id_stock' => $bahan_baku));
    }
	public function single_entry($add_stock_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_add_stock');
        $this->db->where('add_stock_id', $add_stock_id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    function get_stocks($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock.*,id_stock,stock FROM tbl_stock WHERE id_stock='$bahan_baku'");
    	return $result;
    }
    function get_stocks_produksi($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,id_stock,stock FROM tbl_stock_produksi WHERE id_stock='$bahan_baku'");
    	return $result;
    }
    
    public function delete_entry($add_stock_id,$jmlh,$nilai_saham,$bahan_baku)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock SET stock=stock-'$jmlh',nilai_saham=nilai_saham-'$nilai_saham',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->delete('tbl_add_stock', array('add_stock_id' => $add_stock_id));
        return $hsl;
    }
    public function minus_entry($add_stock_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock SET stock=stock-1,nilai_saham=nilai_saham-'$harga_beli',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_add_stock SET jumlah_add_stock=jumlah_add_stock-1,biaya_dikeluarkan=biaya_dikeluarkan-'$harga_beli' where add_stock_id='$add_stock_id'");
        return $hsl;
    }
    public function plus_entry($add_stock_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock SET stock=stock+1,nilai_saham=nilai_saham+'$harga_beli',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_add_stock SET jumlah_add_stock=jumlah_add_stock+1,biaya_dikeluarkan=biaya_dikeluarkan+'$harga_beli' where add_stock_id='$add_stock_id'");
        return $hsl;
    }
    public function plus_entry_produksi($NewID,$totaljumlah,$catatan,$suplier,$id_users,$totalbiaya)
    {	
    	$hsl=$this->db->query("INSERT INTO tbl_selesai_add_stock(kode_add_stock_selesai,add_stock_jumlah,add_stock_selesai_biaya,add_stock_catatan,suplier,add_stock_selesai_user_id) VALUES ('$NewID','$totaljumlah','$totalbiaya','$catatan','$suplier','$id_users')");
    	$hsl = $this->db->query("UPDATE tbl_add_stock SET check_proses=1");
    	return $hsl;
    }	
  	function validasi_bahan($bahan_baku){
		$hsl=$this->db->query("SELECT * FROM tbl_add_stock WHERE bahan_baku_id='$bahan_baku' AND check_proses=0");
		return $hsl;
	}


}

	
