<?php
class Rekap_tambah_stok_model extends CI_Model{
	
	
	var $tableselesaiaddstock = 'tbl_selesai_add_stock';
	var $tableaddstock = 'tbl_add_stock';
	var $tablelog = 'tbl_log';
	var $column_search_addstock = array('bahan_baku_id'); 
	var $column_search_rekapproduksi = array('produksi_selesai_id','kode_add_stock_selesai','add_stock_jumlah','add_stock_selesai_biaya','add_stock_catatan','add_stock_selesai_tgl','add_stock_selesai_user_id'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		//add custom filter here
		if($this->input->post('nama_produksi'))
		{
			$this->db->like('produksi_selesai_jenis', $this->input->post('nama_produksi'));
		}

		$this->db->from($this->tableselesaiaddstock);
		$i = 0;
		foreach ($this->column_search_rekapproduksi as $item) 
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

				if(count($this->column_search_rekapproduksi) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}

	function get_datatables(){
	
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_selesai_add_stock.add_stock_selesai_user_id' , 'left' );
		$this->db->order_by('produksi_selesai_id', 'desc');
		
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
		$this->db->from($this->tableselesaiaddstock);
		return $this->db->count_all_results();
	}
	function count_all_biaya(){
        $query = $this->db->query("SELECT SUM(add_stock_selesai_biaya) AS biaya FROM tbl_selesai_add_stock");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
	
    public function get_by_id($produksi_selesai_id)
	{
		$this->db->from($this->tableselesaiaddstock);
		$this->db->where('produksi_selesai_id',$produksi_selesai_id);
		$query = $this->db->get();
		return $query->row();
	}
	function get_detail_tambah_stok($produksi_selesai_id){
    	$result = $this->db->query("SELECT tbl_selesai_add_stock.*,kode_add_stock_selesai,add_stock_jumlah,add_stock_selesai_biaya,add_stock_catatan,add_stock_selesai_tgl,add_stock_selesai_user_id FROM tbl_selesai_add_stock WHERE produksi_selesai_id='$produksi_selesai_id'");
    	return $result;
    }
    function get_tambah_stock($kode_add_stock_selesai) {
		
		$this->db->select('tbl_add_stock.*, bahan_baku_id,jumlah_add_stock,biaya_dikeluarkan,nama_stock,user_name');
		$this->db->from ( 'tbl_add_stock' );
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_add_stock.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_add_stock.add_stock_stock_user_id' , 'left' );
		$this->db->where('kode_add_stock', $kode_add_stock_selesai);
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return NULL;
	}

	// EDIT ///////////////
	private function _get_datatables_query_edit()
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
	function get_datatables_edit($id){
	
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_add_stock.bahan_baku_id' , 'left' );
		$this->db->where('kode_add_stock', $id);
		$this->db->order_by('add_stock_id', 'desc');
		$this->_get_datatables_query_edit();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
    function get_detail_nota($id){
    	$result = $this->db->query("SELECT tbl_selesai_add_stock.*,add_stock_catatan,user_name
    		FROM tbl_selesai_add_stock 
			LEFT JOIN tbl_user ON tbl_user.user_id = tbl_selesai_add_stock.add_stock_selesai_user_id
			WHERE tbl_selesai_add_stock.kode_add_stock_selesai='$id'");
    	return $result;
    }
	function validasi_bahan($bahan_baku,$id){
		$hsl=$this->db->query("SELECT * FROM tbl_add_stock WHERE bahan_baku_id='$bahan_baku' AND kode_add_stock='$id'");
		return $hsl;
	}
	public function single_entry_selesai_add_stock($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_selesai_add_stock');
        $this->db->where('kode_add_stock_selesai', $id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    
    function count_total_stock_bahan(){
    	
        $query = $this->db->query("SELECT SUM(stock) AS total_stocks FROM tbl_stock");
        return $query;
    }
	public function update_entry_stocks_edit($bahan_baku, $ajax_data_stocks)
    {
        return $this->db->update('tbl_stock', $ajax_data_stocks, array('id_stock' => $bahan_baku));
    }
    function insert_stock($data2){
		$insert = $this->db->insert($this->tableaddstock, $data2);
		if($insert){
			return true;
		}
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
    public function plus_entry_produksi($id, $ajax_data_stocks)
    {
        return $this->db->update('tbl_selesai_add_stock', $ajax_data_stocks, array('kode_add_stock_selesai' => $id));
    }
    public function pembatalan_nota($id)
    {
    	$hsl = $this->db->delete('tbl_selesai_add_stock', array('kode_add_stock_selesai' => $id));
        return $hsl;
    }
	// EDIT ///////////////
	

	// DETAIL ///////////////
	private function _get_datatables_query_detail()
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
	function get_datatables_detail($id){
	
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_add_stock.bahan_baku_id' , 'left' );
		$this->db->where('kode_add_stock', $id);
		$this->db->order_by('add_stock_id', 'desc');
		$this->_get_datatables_query_detail();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered_detail($id)
	{
		$this->_get_datatables_query_detail();
		$this->db->where('kode_add_stock', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detail($id)
	{
		$this->db->from($this->tableaddstock);
		$this->db->where('kode_add_stock', $id);
		return $this->db->count_all_results();
	}
	
}