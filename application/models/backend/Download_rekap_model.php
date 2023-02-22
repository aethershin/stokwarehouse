<?php
class Download_rekap_model extends CI_Model{
	
	
	var $tablesatuan = 'tbl_satuan';
	var $column_search_satuan = array('id_satuan','nama_satuan'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_all_excel_rekap_setoran($dari,$sampai){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select("tbl_rekap_cash.*,nama");
		$this->db->from('tbl_rekap_cash');
		$this->db->join('tbl_list_transaksi', 'tbl_list_transaksi.kode_transaksi=tbl_rekap_cash.nota_cash','left');
		$this->db->join('tbl_konsumen', 'tbl_konsumen.id_konsumen=tbl_list_transaksi.id_konsumen_transaksi','left');
		$this->db->where('date(tbl_rekap_cash.tgl_cash) >=',$dari);
		$this->db->where('date(tbl_rekap_cash.tgl_cash) <=',$sampai);
		$this->db->order_by('id_cash', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	function get_all_excel_rekap_nota($dari,$sampai){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select("tbl_list_transaksi.*,nama");
		$this->db->from('tbl_list_transaksi');
		$this->db->join('tbl_konsumen', 'tbl_konsumen.id_konsumen=tbl_list_transaksi.id_konsumen_transaksi','left');
		$this->db->where('date(tbl_list_transaksi.tgl_transaksi) >=',$dari);
		$this->db->where('date(tbl_list_transaksi.tgl_transaksi) <=',$sampai);
		$this->db->order_by('id_transaksi', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_excel_rekap_pengeluaran($dari,$sampai){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select("tbl_pengeluaran.*,user_name");
		$this->db->from('tbl_pengeluaran');
		$this->db->join('tbl_user', 'tbl_user.user_id=tbl_pengeluaran.id_user_pengeluaran','left');
		$this->db->where('date(tbl_pengeluaran.tgl_pengeluaran) >=',$dari);
		$this->db->where('date(tbl_pengeluaran.tgl_pengeluaran) <=',$sampai);
		$this->db->order_by('id_pengeluaran', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_excel_rekap_tim_produksi($dari,$sampai){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select("tbl_produksi_selesai.*,user_name,nama_stock,nama_satuan,SUM(jumlah_rusak) AS jums_rusak");
		$this->db->from('tbl_produksi_selesai');
		$this->db->join('tbl_stock_produksi', 'tbl_stock_produksi.id_stock=tbl_produksi_selesai.produksi_selesai_jenis','left');
		$this->db->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_stock_produksi.satuan_stock','left');
		$this->db->join('tbl_rusak', 'tbl_rusak.kode_produksi_rusak=tbl_produksi_selesai.kode_produksi_selesai','left');
		$this->db->join('tbl_user', 'tbl_user.user_id=tbl_produksi_selesai.produksi_selesai_user_id','left');
		$this->db->where('date(tbl_produksi_selesai.produksi_selesai_tgl) >=',$dari);
		$this->db->where('date(tbl_produksi_selesai.produksi_selesai_tgl) <=',$sampai);
		$this->db->group_by('tbl_produksi_selesai.kode_produksi_selesai');
		$this->db->order_by('kode_produksi_selesai', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_excel_rekap_tambah_stok($dari,$sampai){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select("tbl_add_stock.*,user_name,nama_stock,suplier,nama_satuan");
		$this->db->from('tbl_add_stock');
		$this->db->join('tbl_user', 'tbl_user.user_id=tbl_add_stock.add_stock_stock_user_id','left');
		$this->db->join('tbl_stock', 'tbl_stock.id_stock=tbl_add_stock.bahan_baku_id','left');
		$this->db->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_stock.satuan_stock','left');
		$this->db->join('tbl_selesai_add_stock', 'tbl_selesai_add_stock.kode_add_stock_selesai=tbl_add_stock.kode_add_stock','left');
		$this->db->where('date(tbl_add_stock.tgl_buat) >=',$dari);
		$this->db->where('date(tbl_add_stock.tgl_buat) <=',$sampai);
		$this->db->order_by('add_stock_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_excel_rekap_stok_bahan_warehouse(){
		
		$this->db->select("tbl_stock.*,nama_satuan");
		$this->db->from('tbl_stock');
		$this->db->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_stock.satuan_stock','left');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_excel_rekap_stok_produk_ready_sale(){
		
		$this->db->select("tbl_stock_produksi.*,nama_satuan");
		$this->db->from('tbl_stock_produksi');
		$this->db->join('tbl_satuan', 'tbl_satuan.id_satuan=tbl_stock_produksi.satuan_stock','left');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
	
}