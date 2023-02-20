<?php
class Surat_jalan_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	
	var $tablelist_surat_jalan = 'tbl_list_surat_jalan';
	var $tablelog = 'tbl_log';
	var $column_search_tablelist_surat_jalan = array('bahan_baku_id'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->tablelist_surat_jalan);
		$i = 0;
		foreach ($this->column_search_tablelist_surat_jalan as $item) 
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

				if(count($this->column_search_tablelist_surat_jalan) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$id = $this->session->userdata('id');
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_list_surat_jalan.bahan_baku_id' , 'left' );
		$this->db->where('check_proses_ls_surat_jalan', 0);
		$this->db->where('ls_surat_jalan_user_id', $id);
		$this->db->order_by('ls_surat_jalan_id', 'desc');
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
		$this->db->where('check_proses_ls_surat_jalan', 0);
		$this->db->where('ls_surat_jalan_user_id', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$id = $this->session->userdata('id');
		$this->db->from($this->tablelist_surat_jalan);
		$this->db->where('check_proses_ls_surat_jalan', 0);
		$this->db->where('ls_surat_jalan_user_id', $id);
		return $this->db->count_all_results();
	}
	function get_all_karyawan(){
		
		$this->db->select('tbl_user.*');
		$this->db->from('tbl_user');
		
		$this->db->order_by('user_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_new_kode_add_surat_jalan(){
        
        $query = $this->db->query("SELECT max(kode_surat_jalan) as maxKode FROM tbl_surat_jalan");

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
        $query = $this->db->query("SELECT COUNT(*) produksi FROM tbl_list_surat_jalan WHERE check_proses_ls_surat_jalan=0 AND ls_surat_jalan_user_id='$id'");
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
		$this->db->select('tbl_stock_produksi.*,nama_satuan');
		$this->db->from('tbl_stock_produksi');
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}

    
	function insert_stock($data2){
		$insert = $this->db->insert($this->tablelist_surat_jalan, $data2);

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
        $this->db->from('tbl_list_surat_jalan');
        $this->db->where('ls_surat_jalan_id', $ls_surat_jalan_id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    
  
    function get_stocks($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,kode_stock,stock FROM tbl_stock_produksi WHERE kode_stock='$bahan_baku'");
    	return $result;
    }
 
    function get_stocks_produksi($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,kode_stock,stock FROM tbl_stock_produksi WHERE kode_stock='$bahan_baku'");
    	return $result;
    }
   
    public function delete_entry($ls_surat_jalan_id)
    {
        return $this->db->delete('tbl_list_surat_jalan', array('ls_surat_jalan_id' => $ls_surat_jalan_id));
    }
    public function minus_entry($ls_surat_jalan_id)
    {
    	
        $hsl = $this->db->query("UPDATE tbl_list_surat_jalan SET jumlah_ls_surat_jalan=jumlah_ls_surat_jalan-1 WHERE ls_surat_jalan_id='$ls_surat_jalan_id'");
       
        return $hsl;
    }
    public function plus_entry($ls_surat_jalan_id)
    {
    	
        $hsl = $this->db->query("UPDATE tbl_list_surat_jalan SET jumlah_ls_surat_jalan=jumlah_ls_surat_jalan+1 WHERE ls_surat_jalan_id='$ls_surat_jalan_id'");
       
        return $hsl;
    }
    
    public function plus_entry_surat_jalan($NewID,$totaljumlah,$catatan,$id_users,$diserahkan,$penerima,$diketahui)
    {	
    	$hsl=$this->db->query("INSERT INTO tbl_surat_jalan(kode_surat_jalan,jumlah_surat_jalan,id_user_surat_jalan,diserahkan_sj,penerima_sj,diketahui_sj,catatan_surat_jalan) VALUES ('$NewID','$totaljumlah','$id_users','$diserahkan','$penerima','$diketahui','$catatan')");
    	$hsl = $this->db->query("UPDATE tbl_list_surat_jalan SET check_proses_ls_surat_jalan=1 WHERE ls_surat_jalan_user_id='$id_users'");
    	return $hsl;
    }
  
  	function validasi_bahan($bahan_baku){
  		$user_id = $this->session->userdata('id');
		$hsl=$this->db->query("SELECT * FROM tbl_list_surat_jalan WHERE bahan_baku_id='$bahan_baku' AND check_proses_ls_surat_jalan=0 AND ls_surat_jalan_user_id='$user_id'");
		return $hsl;
	}


}

	
