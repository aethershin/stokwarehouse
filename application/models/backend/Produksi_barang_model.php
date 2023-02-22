<?php
class Produksi_barang_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	var $tablestocks = 'tbl_stock';
	var $tableproduksistock = 'tbl_produksi_stock';
	var $tablelog = 'tbl_log';
	var $column_search_produksi_stock = array('bahan_baku_id'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->tableproduksistock);
		$i = 0;
		foreach ($this->column_search_produksi_stock as $item) 
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

				if(count($this->column_search_produksi_stock) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$id = $this->session->userdata('id');
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_produksi_stock.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->where('check_proses', 0);
		$this->db->where('produksi_stock_user_id', $id);
		$this->db->order_by('produksi_id', 'desc');
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
		$this->db->where('produksi_stock_user_id', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$id = $this->session->userdata('id');
		$this->db->from($this->tableproduksistock);
		$this->db->where('check_proses', 0);
		$this->db->where('produksi_stock_user_id', $id);
		return $this->db->count_all_results();
	}
	
	function get_new_kode_produksi(){
        
        $query = $this->db->query("SELECT max(kode_produksi_selesai) as maxKode FROM tbl_produksi_selesai");

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
        $query = $this->db->query("SELECT COUNT(*) produksi FROM tbl_produksi_stock WHERE check_proses=0 AND produksi_stock_user_id='$id'");
        return $query;
    }
	function get_all_bbaku(){
		$this->db->select('tbl_stock.*,nama_satuan');
		$this->db->from('tbl_stock');
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
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
	function get_all_produksi_edit($id_stock){
		$this->db->select('tbl_stock_produksi.*,nama_satuan');
		$this->db->from('tbl_stock_produksi');
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->where('id_stock', $id_stock);
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
    
	function insert_stock($data2){
		$insert = $this->db->insert($this->tableproduksistock, $data2);
		if($insert){
			return true;
		}
	}
	
	
    public function update_entry_stocks($bahan_baku, $ajax_data_stocks)
    {
        return $this->db->update('tbl_stock', $ajax_data_stocks, array('id_stock' => $bahan_baku));
    }
	public function single_entry($produksi_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_produksi_stock');
        $this->db->where('produksi_id', $produksi_id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    function get_stocks($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock.*,id_stock,stock,nama_stock FROM tbl_stock WHERE id_stock='$bahan_baku'");
    	return $result;
    }
    function get_stocks_produksi($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,id_stock,stock FROM tbl_stock_produksi WHERE id_stock='$bahan_baku'");
    	return $result;
    }
    public function delete_entry($produksi_id,$hasil_penambahan_stock,$hasil_penambahan_saham,$bahan_baku)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock SET stock='$hasil_penambahan_stock',nilai_saham=nilai_saham+'$hasil_penambahan_saham',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->delete('tbl_produksi_stock', array('produksi_id' => $produksi_id));
        return $hsl;
    }
    public function minus_entry($produksi_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli,$hasil_penambahan_stock,$hasil_penambahan_saham)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock SET stock='$hasil_penambahan_stock',nilai_saham=nilai_saham+'$hasil_penambahan_saham',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_produksi_stock SET jumlah=jumlah-1,biaya_dikeluarkan=biaya_dikeluarkan-'$hasil_penambahan_saham' where produksi_id='$produksi_id'");
        return $hsl;
    }
    public function plus_entry($produksi_id,$bahan_baku,$stokkekurangan,$biaya_dikeluarkan,$harga_beli,$hasil_penambahan_stock,$hasil_penambahan_saham)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock SET stock='$hasil_penambahan_stock',nilai_saham=nilai_saham-'$hasil_penambahan_saham',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_produksi_stock SET jumlah=jumlah+1,biaya_dikeluarkan=biaya_dikeluarkan+'$hasil_penambahan_saham' where produksi_id='$produksi_id'");
        return $hsl;
    }
    public function plus_entry_produksi($NewID,$bahan_baku,$catatan_produksi,$id_users,$stock_jumlah_produksi,$hargabeli_total_bayar,$nilai_saham_totalbiaya,$jumlah_produksi,$totalbiaya)
    {	
    	$hsl = $this->db->query("UPDATE tbl_stock_produksi SET stock='$stock_jumlah_produksi',harga_beli='$hargabeli_total_bayar',nilai_saham='$nilai_saham_totalbiaya',tgl_ubah=NOW(),user_id_stock='$id_users' where id_stock='$bahan_baku'");
    	$hsl=$this->db->query("INSERT INTO tbl_produksi_selesai(kode_produksi_selesai,produksi_selesai_jenis,produksi_selesai_jumlah,produksi_selesai_biaya,produksi_selesai_catatan,produksi_selesai_user_id) VALUES ('$NewID','$bahan_baku','$jumlah_produksi','$totalbiaya','$catatan_produksi','$id_users')");
    	$hsl = $this->db->query("UPDATE tbl_produksi_stock SET check_proses=1");
    	return $hsl;
    }	
  	function validasi_bahan($bahan_baku){
		$hsl=$this->db->query("SELECT * FROM tbl_produksi_stock WHERE bahan_baku_id='$bahan_baku' AND check_proses=0");
		return $hsl;
	}


}

	
