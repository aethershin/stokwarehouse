<?php
class Rekap_produksi_barang_model extends CI_Model{
	
	
	var $tablerekapproduksi = 'tbl_produksi_selesai';
	var $tableproduksistock = 'tbl_produksi_stock';
	var $tablerusak = 'tbl_rusak';
	var $column_search_produksi_stock = array('bahan_baku_id'); 
	var $column_search_produksi_rusak = array('bahan_baku_id_rusak'); 
	var $column_search_rekapproduksi = array('produksi_selesai_id','kode_produksi_selesai','produksi_selesai_jenis','produksi_selesai_jumlah','produksi_selesai_biaya','produksi_selesai_tgl','produksi_selesai_user_id'); 
	

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
		if($this->input->post('kode_produksi_selesai'))
		{
			$this->db->like('kode_produksi_selesai', $this->input->post('kode_produksi_selesai'));
		}
		if($this->input->post('produksi_selesai_user_id'))
		{
			$this->db->like('produksi_selesai_user_id', $this->input->post('produksi_selesai_user_id'));
		}

		$this->db->from($this->tablerekapproduksi);
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
		//$this->db->select('tbl_stock_produksi.*, kode_produksi_selesai,produksi_selesai_jumlah,produksi_selesai_biaya,produksi_selesai_tgl,user_name,nama_stock,satuan_stock,nama_satuan');
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.id_stock = tbl_produksi_selesai.produksi_selesai_jenis' , 'left' );

		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_produksi_selesai.produksi_selesai_user_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
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
		$this->db->from($this->tablerekapproduksi);
		return $this->db->count_all_results();
	}
	function count_all_biaya(){
        $query = $this->db->query("SELECT SUM(produksi_selesai_jumlah) AS biaya FROM tbl_produksi_selesai");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
	function get_all_produksi(){
		$this->db->select('tbl_stock_produksi.*');
		$this->db->from('tbl_stock_produksi');
		$this->db->order_by('id_stock', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_karyawan(){
	    $dev = 'Zikry';
	    $kasir = 3;
		$this->db->select('tbl_user.*');
		$this->db->from('tbl_user');
		$this->db->where_not_in ( 'user_name', $dev);
		$this->db->where_not_in ( 'user_level', $kasir);
		$this->db->order_by('user_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}





    public function get_by_id($produksi_selesai_id)
	{
		$this->db->from($this->tablerekapproduksi);
		$this->db->where('produksi_selesai_id',$produksi_selesai_id);
		$query = $this->db->get();
		return $query->row();
	}
	function get_detail_tambah_stok2($produksi_selesai_id){
    	$result = $this->db->query("SELECT tbl_produksi_selesai.*,kode_produksi_selesai,produksi_selesai_jenis,produksi_selesai_jumlah,produksi_selesai_biaya,produksi_selesai_catatan,produksi_selesai_tgl,produksi_selesai_user_id FROM tbl_produksi_selesai WHERE produksi_selesai_id='$produksi_selesai_id'");
    	return $result;
    }
    function get_detail_tambah_stok($produksi_selesai_id){
    	$result = $this->db->query("SELECT tbl_produksi_selesai.*,kode_produksi_selesai,produksi_selesai_jenis,produksi_selesai_jumlah,produksi_selesai_biaya,produksi_selesai_catatan,produksi_selesai_tgl,produksi_selesai_user_id,nama_stock,nama_satuan
    		FROM tbl_produksi_selesai 
			LEFT JOIN tbl_stock_produksi ON tbl_stock_produksi.id_stock = tbl_produksi_selesai.produksi_selesai_jenis
			LEFT JOIN tbl_satuan ON tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock
			WHERE tbl_produksi_selesai.produksi_selesai_id='$produksi_selesai_id'");
    	return $result;
    }
    function get_tambah_stock($kode_produksi_selesai) {
		
		$this->db->select('tbl_produksi_stock.*, bahan_baku_id,jumlah,biaya_dikeluarkan,nama_stock,user_name,nama_satuan');
		$this->db->from ( 'tbl_produksi_stock' );
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_produksi_stock.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_produksi_stock.produksi_stock_user_id' , 'left' );
		$this->db->where('kode_produksi', $kode_produksi_selesai);
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return NULL;
	}
	function count_brusak($kode_produksi_selesai) {
            $result = $this->db->query("SELECT SUM(jumlah_rusak) AS brusak FROM tbl_rusak WHERE kode_produksi_rusak='$kode_produksi_selesai'");
            return $result;
    }

	// EDIT ///////////////
	private function _get_datatables_query_edit()
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
	function get_datatables_edit($id){
	
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_produksi_stock.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->where('kode_produksi', $id);
		$this->db->order_by('produksi_id', 'desc');
		$this->_get_datatables_query_edit();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered_edit($id)
	{
		$this->_get_datatables_query_edit();
		$this->db->where('kode_produksi', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_edit($id)
	{
		$this->db->from($this->tableproduksistock);
		$this->db->where('kode_produksi', $id);
		return $this->db->count_all_results();
	}
	function get_kode_rekap($id){
		$query = $this->db->query("SELECT tbl_produksi_selesai.* FROM tbl_produksi_selesai 
			WHERE kode_produksi_selesai='$id' GROUP BY kode_produksi_selesai LIMIT 1");
		return $query;
	}
	
    function get_detail_nota($id){
    	$result = $this->db->query("SELECT tbl_produksi_selesai.*,produksi_selesai_catatan,nama_stock,user_name,nama_satuan FROM tbl_produksi_selesai 
			LEFT JOIN tbl_stock_produksi ON tbl_stock_produksi.id_stock = tbl_produksi_selesai.produksi_selesai_jenis
			LEFT JOIN tbl_satuan ON tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock
			LEFT JOIN tbl_user ON tbl_user.user_id = tbl_produksi_selesai.produksi_selesai_user_id
			WHERE tbl_produksi_selesai.kode_produksi_selesai='$id'");
    	return $result;
    }
    function insert_log_stock($data2){
		$insert = $this->db->insert($this->tablelog, $data2);
		if($insert){
			return true;
		}
	}
	function validasi_bahan($bahan_baku,$kode_produksi){
		$hsl=$this->db->query("SELECT * FROM tbl_produksi_stock WHERE bahan_baku_id='$bahan_baku' AND kode_produksi='$kode_produksi'");
		return $hsl;
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
    public function single_entry_rekap_stock($id_nota)
    {
        $this->db->select('*');
        $this->db->from('tbl_produksi_selesai');
        $this->db->where('kode_produksi_selesai', $id_nota);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
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
    function get_stocks_produksi($bahan_baku){
    	$result = $this->db->query("SELECT tbl_stock_produksi.*,id_stock,stock FROM tbl_stock_produksi WHERE id_stock='$bahan_baku'");
    	return $result;
    }
    public function plus_entry_produksi($id_nota, $ajax_data_stocks)
    {
        return $this->db->update('tbl_produksi_selesai', $ajax_data_stocks, array('kode_produksi_selesai' => $id_nota));
    }
    public function plus_entry_produksi2($bahan_baku,$stock_jumlah_produksi,$hargabeli_total_bayar,$nilai_saham_totalbiaya)
    {	
    	$hsl = $this->db->query("UPDATE tbl_stock_produksi SET stock='$stock_jumlah_produksi',harga_beli='$hargabeli_total_bayar',nilai_saham='$nilai_saham_totalbiaya',tgl_ubah=NOW(),user_id_stock='$id_users' where id_stock='$bahan_baku'");
    	
    	return $hsl;
    }
    public function single_entry_produksi_selesai($kode_produksi_selesai)
    {
        $this->db->select('*');
        $this->db->from('tbl_produksi_selesai');
        $this->db->where('kode_produksi_selesai', $kode_produksi_selesai);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }	
    public function update_stock_produksi($bahan_baku, $ajax_data_stocks)
    {
        return $this->db->update('tbl_stock_produksi', $ajax_data_stocks, array('id_stock' => $bahan_baku));
    }
	public function pembatalan_nota($kode_produksi_selesai)
    {
    	$hsl = $this->db->delete('tbl_produksi_selesai', array('kode_produksi_selesai' => $kode_produksi_selesai));
        return $hsl;
    }

    // RUSAK
    private function _get_datatables_query_rusak()
	{
		$this->db->from($this->tablerusak);
		$i = 0;
		foreach ($this->column_search_produksi_rusak as $item) 
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

				if(count($this->column_search_produksi_rusak) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
    function get_datatables_rusak($id){
	
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_rusak.bahan_baku_id_rusak' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->where('kode_produksi_rusak', $id);
		$this->db->order_by('produksi_id_rusak', 'desc');
		$this->_get_datatables_query_rusak();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered_rusak($id)
	{
		$this->_get_datatables_query_rusak();
		$this->db->where('kode_produksi_rusak', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rusak($id)
	{

		$this->db->from($this->tablerusak);
		$this->db->where('kode_produksi_rusak', $id);
		return $this->db->count_all_results();
	}
	function insert_bahan_baku_rusak($data2){
		$insert = $this->db->insert($this->tablerusak, $data2);
		if($insert){
			return true;
		}
	}
	function validasi_bahan_rusak($bahan_baku,$kode_produksi){
		$hsl=$this->db->query("SELECT * FROM tbl_rusak WHERE bahan_baku_id_rusak='$bahan_baku' AND kode_produksi_rusak='$kode_produksi'");
		return $hsl;
	}

	public function single_entry_rusak($produksi_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_rusak');
        $this->db->where('produksi_id_rusak', $produksi_id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    public function minus_entry_rusak($produksi_id,$bahan_baku,$hasil_penambahan_stock,$hasil_penambahan_saham)
    {
        $hsl = $this->db->query("UPDATE tbl_stock SET stock='$hasil_penambahan_stock',nilai_saham=nilai_saham+'$hasil_penambahan_saham',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_rusak SET jumlah_rusak=jumlah_rusak-1,biaya_dikeluarkan_rusak=biaya_dikeluarkan_rusak-'$hasil_penambahan_saham' where produksi_id_rusak='$produksi_id'");
        return $hsl;
    }
    public function plus_entry_rusak($produksi_id,$bahan_baku,$hasil_pengurangan_stock,$hasil_pengurangan_saham)
    {
        $hsl = $this->db->query("UPDATE tbl_stock SET stock='$hasil_pengurangan_stock',nilai_saham=nilai_saham-'$hasil_pengurangan_saham',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->query("UPDATE tbl_rusak SET jumlah_rusak=jumlah_rusak+1,biaya_dikeluarkan_rusak=biaya_dikeluarkan_rusak+'$hasil_pengurangan_saham' where produksi_id_rusak='$produksi_id'");
        return $hsl;
    }
    public function delete_rusak($produksi_id,$bahan_baku,$hasil_penambahan_stock,$hasil_penambahan_saham)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock SET stock='$hasil_penambahan_stock',nilai_saham=nilai_saham+'$hasil_penambahan_saham',tgl_ubah=NOW() where id_stock='$bahan_baku'");
        $hsl = $this->db->delete('tbl_rusak', array('produksi_id_rusak' => $produksi_id));
        return $hsl;
    }
    function get_bahan_rusak($kode_produksi_selesai) {
		
		$this->db->select('tbl_rusak.*, bahan_baku_id_rusak,jumlah_rusak,biaya_dikeluarkan_rusak,nama_stock,user_name,nama_satuan');
		$this->db->from ( 'tbl_rusak' );
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_rusak.bahan_baku_id_rusak' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_rusak.produksi_stock_user_id_rusak' , 'left' );
		$this->db->where('kode_produksi_rusak', $kode_produksi_selesai);
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return NULL;
	}

	// DETAIL
	private function _get_datatables_query_detail()
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
	function get_datatables_detail($id){
	
		$this->db->join ( 'tbl_stock', 'tbl_stock.id_stock = tbl_produksi_stock.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->where('kode_produksi', $id);
		$this->db->order_by('produksi_id', 'desc');
		$this->_get_datatables_query_detail();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered_detail($id)
	{
		$this->_get_datatables_query_detail();
		$this->db->where('kode_produksi', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detail($id)
	{

		$this->db->from($this->tableproduksistock);
		$this->db->where('kode_produksi', $id);
		return $this->db->count_all_results();
	}
	function get_detail_rusak($id){
		$this->db->select("tbl_rusak.*,nama_stock,nama_satuan");
		$this->db->from('tbl_rusak');
		$this->db->join('tbl_stock', 'tbl_stock.id_stock=tbl_rusak.bahan_baku_id_rusak','left');
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->where ( 'kode_produksi_rusak', $id);
		$this->db->order_by('produksi_id_rusak', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
}