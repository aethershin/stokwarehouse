<?php
class Transaksi_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	
	var $tabletransaksi = 'tbl_transaksi';
	var $tablelog = 'tbl_log';
	var $column_search_transaksi = array('bahan_baku_id'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->tabletransaksi);
		$i = 0;
		foreach ($this->column_search_transaksi as $item) 
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

				if(count($this->column_search_transaksi) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$id = $this->session->userdata('id');
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_transaksi.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->where('check_proses_transaksi', 0);
		$this->db->where('transaksi_user_id', $id);
		$this->db->order_by('transaksi_id', 'desc');
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
		$this->db->where('check_proses_transaksi', 0);
		$this->db->where('transaksi_user_id', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$id = $this->session->userdata('id');
		$this->db->from($this->tabletransaksi);
		$this->db->where('check_proses_transaksi', 0);
		$this->db->where('transaksi_user_id', $id);
		return $this->db->count_all_results();
	}
	
	function get_new_kode_add_transaksi(){
        
        $query = $this->db->query("SELECT max(kode_transaksi) as maxKode FROM tbl_list_transaksi");

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
        $query = $this->db->query("SELECT COUNT(*) produksi FROM tbl_transaksi WHERE check_proses_transaksi=0 AND transaksi_user_id='$id'");
        return $query;
    }
	function get_all_bbaku(){
		$this->db->select('tbl_stock.*');
		$this->db->from('tbl_stock');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_jcicilan(){
		$this->db->select('tbl_jenis_cicilan.*');
		$this->db->from('tbl_jenis_cicilan');
		$this->db->order_by('id_jenis_cicilan ', 'DESC');
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
	function get_all_konsumen(){
		$this->db->select('tbl_konsumen.*');
		$this->db->from('tbl_konsumen');
		$this->db->order_by('id_konsumen', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_jharga(){
		$this->db->select('tbl_jenis_harga.*,nama_jenis_harga,jenis_harga');
		$this->db->from('tbl_jenis_harga');
		$this->db->order_by('id_jenis_harga', 'DESC');
		$query = $this->db->get();
		return $query;
	}
    
	function insert_stock($data2){
		$insert = $this->db->insert($this->tabletransaksi, $data2);

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
        return $this->db->update('tbl_stock_produksi', $ajax_data_stocks, array('kode_stock' => $bahan_baku));
        
       
    }
	public function single_entry($transaksi_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_transaksi');
        $this->db->where('transaksi_id', $transaksi_id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    
    function get_konsumen_nama($konsumen){
    	$result = $this->db->query("SELECT tbl_konsumen.*,id_konsumen,nama FROM tbl_konsumen WHERE id_konsumen='$konsumen'");
    	return $result;
    }
    function get_stocks($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,id_stock,stock FROM tbl_stock_produksi WHERE kode_stock='$bahan_baku'");
    	return $result;
    }
    function get_jcicilan($tenors){
    	$result = $this->db->query("SELECT tbl_jenis_cicilan.*,id_jenis_cicilan,nama_cicilan,tenor,jumlah_tenor FROM tbl_jenis_cicilan WHERE id_jenis_cicilan='$tenors'");
    	return $result;
    }
    function get_jharga($jharga_id){
    	$result = $this->db->query("SELECT tbl_jenis_harga.*,id_jenis_harga,jenis_harga,kode_jharga FROM tbl_jenis_harga WHERE kode_jharga='$jharga_id'");
    	return $result;
    }
    function get_stocks_produksi($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,id_stock,stock FROM tbl_stock_produksi WHERE kode_stock='$bahan_baku'");
    	return $result;
    }
    public function delete_entry($transaksi_id,$jmlh,$kembalikan_nilai_saham,$bahan_baku,$konsumen)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock_produksi SET stock=stock+'$jmlh',nilai_saham=nilai_saham+'$kembalikan_nilai_saham',harga_beli=harga_beli+'$kembalikan_nilai_saham',tgl_ubah=NOW() where kode_stock='$bahan_baku'");
        $hsl = $this->db->delete('tbl_transaksi', array('transaksi_id' => $transaksi_id));
        
        return $hsl;
    }
    public function minus_entry($transaksi_id,$bahan_baku,$biaya_dikeluarkan,$harga_modal,$harga_jual_konsumen,$konsumen)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock_produksi SET stock=stock+1,nilai_saham=nilai_saham+'$harga_modal',harga_beli=harga_beli+'$harga_modal',tgl_ubah=NOW() where kode_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_transaksi SET jumlah_transaksi=jumlah_transaksi-1,harga_jual_transaksi=harga_jual_transaksi-'$harga_jual_konsumen' where transaksi_id='$transaksi_id'");
        
        return $hsl;
    }
    public function plus_entry($transaksi_id,$bahan_baku,$biaya_dikeluarkan,$harga_modal,$harga_jual_konsumen,$konsumen)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock_produksi SET stock=stock-1,nilai_saham=nilai_saham-'$harga_modal',harga_beli=harga_beli-'$harga_modal',tgl_ubah=NOW() where kode_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_transaksi SET jumlah_transaksi=jumlah_transaksi+1,harga_jual_transaksi=harga_jual_transaksi+'$harga_jual_konsumen' where transaksi_id='$transaksi_id'");
       
        return $hsl;
    }
    public function plus_entry_transaksi($NewID,$totaljumlah,$catatan,$id_users,$totalbiaya,$konsumen,$jumlah_dibayar,$nama_cicilan,$jumlah_cicilan,$ketjtransaksi,$dapatkan_hutang,$jumlah_tenor)
    {	
    	$hsl=$this->db->query("INSERT INTO tbl_list_transaksi(kode_transaksi,id_konsumen_transaksi,jumlah_pembelian,jumlah_dibayar,jenis_transaksi,total_belanja,dapatkan_hutang,tenorbulan,tenorcicil,id_user_transaksi,catatan) VALUES ('$NewID','$konsumen','$totaljumlah','$jumlah_dibayar','$ketjtransaksi','$totalbiaya','$dapatkan_hutang','$nama_cicilan','$jumlah_cicilan','$id_users','$catatan')");
    	$hsl = $this->db->query("UPDATE tbl_transaksi SET check_proses_transaksi=1 WHERE transaksi_user_id='$id_users'");
    	$hsl = $this->db->query("UPDATE tbl_konsumen SET hutang=hutang+'$dapatkan_hutang' WHERE id_konsumen='$konsumen'");
    	
    		
    	
    	
    	return $hsl;
    }
    public function add_cash($NewID,$ket_cash,$jumlah_dibayar)
    {	
    	$hsl=$this->db->query("INSERT INTO tbl_rekap_cash(nota_cash,ket_cash,total_cash) VALUES ('$NewID','$ket_cash','$jumlah_dibayar')");
    	return $hsl;
    }
    public function add_cicilan($NewID,$konsumen,$nama_cicilan,$tenor,$jumlah_tenor,$jumlah_cicilan,$id_users)
    {	
    	
    	$hsl=$this->db->query("INSERT INTO tbl_cicil(kode_transaksi_cicil,id_konsumen_cicil,cicilan,jumlah_cicilan,jenis_cicilan,ket_cicilan,id_user_cicil) VALUES ('$NewID','$konsumen','$jumlah_cicilan','$jumlah_tenor','$tenor','$nama_cicilan','$id_users')");
    	return $hsl;
    }	
  	function validasi_bahan($bahan_baku){
  		$user_id = $this->session->userdata('id');
		$hsl=$this->db->query("SELECT * FROM tbl_transaksi WHERE bahan_baku_id='$bahan_baku' AND check_proses_transaksi=0 AND transaksi_user_id='$user_id'");
		return $hsl;
	}


}

	
