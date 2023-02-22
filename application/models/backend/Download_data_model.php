<?php
class Download_data_model extends CI_Model{
	
	
	var $tablesatuan = 'tbl_satuan';
	var $column_search_satuan = array('id_satuan','nama_satuan'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		

		$this->db->from($this->tablesatuan);
		$i = 0;
		foreach ($this->column_search_satuan as $item) 
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

				if(count($this->column_search_satuan) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		
		$this->db->order_by('id_satuan', 'desc');
		
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
		$this->db->from($this->tablesatuan);
		return $this->db->count_all_results();
	}
	

    public function get_by_id($id_satuan)
	{
		$this->db->from($this->tablesatuan);
		$this->db->where('id_satuan',$id_satuan);
		$query = $this->db->get();
		return $query->row();
	}

	
    function laporan_statistics(){
        date_default_timezone_set('Asia/Jakarta');
        $bulan =date('m');
        
        $this->db->select("tbl_rekap_cash.*,SUM(IF(DATE_FORMAT(tgl_cash,'%d'), total_cash, 0)) AS totals,DATE_FORMAT(tgl_cash,'%d') AS tgl");
        $this->db->from('tbl_rekap_cash');
       
        $this->db->where ( 'month(tgl_cash)', $bulan);
        $this->db->group_by('date(tgl_cash)');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    function laporan_statistics_bulanan(){
        date_default_timezone_set('Asia/Jakarta');
        $bulan =date('Y');
        
        $this->db->select("tbl_rekap_cash.*,SUM(IF(DATE_FORMAT(tgl_cash,'%m'), total_cash, 0)) AS totals,DATE_FORMAT(tgl_cash,'%M') AS tgl");
        $this->db->from('tbl_rekap_cash');
       
        $this->db->where ( 'year(tgl_cash)', $bulan);
        $this->db->group_by('month(tgl_cash)');
        $this->db->limit(12);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    function laporan_statistics_nota(){
        date_default_timezone_set('Asia/Jakarta');
        $bulan =date('m');
        
        $this->db->select("tbl_list_transaksi.*,SUM(IF(DATE_FORMAT(tgl_ubah,'%d'), total_belanja, 0)) AS totals,SUM(IF(DATE_FORMAT(tgl_ubah,'%d'), jumlah_pembelian, 0)) AS jumlah,DATE_FORMAT(tgl_ubah,'%d') AS tgl");
        $this->db->from('tbl_list_transaksi');
        
        $this->db->where ( 'month(tbl_list_transaksi.tgl_ubah)', $bulan);
        $this->db->group_by('date(tbl_list_transaksi.tgl_ubah)');
        $this->db->limit(31);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    function laporan_statistics_bulanan_nota(){
        date_default_timezone_set('Asia/Jakarta');
        $bulan =date('Y');
        
        $this->db->select("tbl_list_transaksi.*,SUM(IF(DATE_FORMAT(tgl_ubah,'%m'), total_belanja, 0)) AS totals,SUM(IF(DATE_FORMAT(tgl_ubah,'%m'), jumlah_pembelian, 0)) AS jumlah,DATE_FORMAT(tgl_ubah,'%M') AS tgl");
        $this->db->from('tbl_list_transaksi');
        
        $this->db->where ( 'year(tbl_list_transaksi.tgl_ubah)', $bulan);
        $this->db->group_by('month(tbl_list_transaksi.tgl_ubah)');
        $this->db->limit(12);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    // PENGELUARAN
    function pengeluaran_statistics(){
        date_default_timezone_set('Asia/Jakarta');
        $bulan =date('m');
        
        $this->db->select("tbl_pengeluaran.*,SUM(IF(DATE_FORMAT(tgl_pengeluaran,'%d'), biaya_pengeluaran, 0)) AS totals,DATE_FORMAT(tgl_pengeluaran,'%d') AS tgl");
        $this->db->from('tbl_pengeluaran');
       
        $this->db->where ( 'month(tgl_pengeluaran)', $bulan);
        $this->db->group_by('date(tgl_pengeluaran)');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    function pengeluaran_bulanan_statistics(){
        date_default_timezone_set('Asia/Jakarta');
        $bulan =date('Y');
        
        $this->db->select("tbl_pengeluaran.*,SUM(IF(DATE_FORMAT(tgl_pengeluaran,'%m'), biaya_pengeluaran, 0)) AS totals,DATE_FORMAT(tgl_pengeluaran,'%M') AS tgl");
        $this->db->from('tbl_pengeluaran');
       
        $this->db->where ( 'year(tgl_pengeluaran)', $bulan);
        $this->db->group_by('month(tgl_pengeluaran)');
        $this->db->limit(12);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    // PENGELUARAN
	function stock_statistics(){
        $query = $this->db->query("SELECT nama_stock AS stk,SUM(stock) AS jumlah FROM tbl_stock  GROUP BY nama_stock");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    function stock_produksi_statistics(){
        $query = $this->db->query("SELECT nama_stock AS stk,SUM(stock) AS jumlah FROM tbl_stock_produksi GROUP BY nama_stock");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
 
   
    function riwayat_produksi_statistics(){
		date_default_timezone_set('Asia/Jakarta');
		$bulan =date('m');
		
		$this->db->select("tbl_produksi_selesai.*,SUM(IF(DATE_FORMAT(produksi_selesai_tgl,'%m'), produksi_selesai_biaya, 0)) AS totals,SUM(IF(DATE_FORMAT(produksi_selesai_tgl,'%m'), produksi_selesai_jumlah, 0)) AS jumlah,DATE_FORMAT(produksi_selesai_tgl,'%d') AS tgl");
		$this->db->from('tbl_produksi_selesai');
        $this->db->join('tbl_stock_produksi', 'tbl_stock_produksi.id_stock=tbl_produksi_selesai.produksi_selesai_jenis','left');
		$this->db->where ( 'month(tbl_produksi_selesai.produksi_selesai_tgl)', $bulan);
		$this->db->group_by('date(tbl_produksi_selesai.produksi_selesai_tgl)');
		$query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }

    function riwayat_tambah_stok_statistics(){
		date_default_timezone_set('Asia/Jakarta');
		$bulan =date('m');
		
		$this->db->select("tbl_add_stock.*,SUM(IF(DATE_FORMAT(tgl_buat,'%m'), biaya_dikeluarkan, 0)) AS totals,SUM(IF(DATE_FORMAT(tgl_buat,'%m'), jumlah_add_stock, 0)) AS jumlah,DATE_FORMAT(tgl_buat,'%d') AS tgl");
		$this->db->from('tbl_add_stock');
        $this->db->join('tbl_stock', 'tbl_stock.id_stock=tbl_add_stock.bahan_baku_id','left');
		$this->db->where ( 'month(tbl_add_stock.tgl_buat)', $bulan);
		$this->db->group_by('date(tbl_add_stock.tgl_buat)');
		$query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    
   
   	function transaksi_count_harian() {
            $query = $this->db->query("SELECT SUM(total_cash) AS transaksi FROM tbl_rekap_cash WHERE DAY(tgl_cash)=DAY(NOW())");
            return $query;
    }
    function transaksi_count_bulanan() {
            $query = $this->db->query("SELECT SUM(total_cash) AS transaksi FROM tbl_rekap_cash WHERE MONTH(tgl_cash)=MONTH(NOW())");
            return $query;
    }
    function transaksi_count() {
            $query = $this->db->query("SELECT SUM(jumlah_pembelian) AS jumlah FROM tbl_list_transaksi WHERE DAY(tgl_transaksi)=DAY(NOW())");
            return $query;
    }
    function transaksi_count2() {
            $query = $this->db->query("SELECT SUM(total_belanja) AS transaksi FROM tbl_list_transaksi WHERE DAY(tgl_transaksi)=DAY(NOW())");
            return $query;
    }
    function transaksi_count3() {
            $query = $this->db->query("SELECT SUM(jumlah_pembelian) AS jumlah FROM tbl_list_transaksi WHERE MONTH(tgl_transaksi)=MONTH(NOW())");
            return $query;
    }
    function transaksi_count4() {
            $query = $this->db->query("SELECT SUM(total_belanja) AS transaksi FROM tbl_list_transaksi WHERE MONTH(tgl_transaksi)=MONTH(NOW())");
            return $query;
    }
    function pengeluaran_count_harian() {
            $query = $this->db->query("SELECT SUM(biaya_pengeluaran) AS transaksi FROM tbl_pengeluaran WHERE DAY(tgl_pengeluaran)=DAY(NOW())");
            return $query;
    }
    function pengeluaran_count_bulanan() {
            $query = $this->db->query("SELECT SUM(biaya_pengeluaran) AS transaksi FROM tbl_pengeluaran WHERE MONTH(tgl_pengeluaran)=MONTH(NOW())");
            return $query;
    }
    function stock_count() {
            $query = $this->db->query("SELECT SUM(stock) AS stock_today FROM tbl_stock");
            return $query;
    }
    function nilai_saham_count() {
            $query = $this->db->query("SELECT SUM(nilai_saham) AS nilai_saham_count FROM tbl_stock");
            return $query;
    }
    function stock_produksi_count() {
            $query = $this->db->query("SELECT SUM(stock) AS stock_produksi_today FROM tbl_stock_produksi");
            return $query;
    }
    function stock_produksi_riwayat_count() {
            $query = $this->db->query("SELECT SUM(produksi_selesai_jumlah) AS stock_produksi_riwayat FROM tbl_produksi_selesai");
            return $query;
    }
    function stock_produksi_riwayat_biaya() {
            $query = $this->db->query("SELECT SUM(produksi_selesai_biaya) AS stock_produksi_biaya FROM tbl_produksi_selesai");
            return $query;
    }
    function jumlah_riwayat_tambah_stock() {
            $query = $this->db->query("SELECT SUM(jumlah_add_stock) AS jumlahs FROM tbl_add_stock");
            return $query;
    }
    function biaya_riwayat_tambah_stock() {
            $query = $this->db->query("SELECT SUM(biaya_dikeluarkan) AS biayas FROM tbl_add_stock");
            return $query;
    }
    
	
	
	
}