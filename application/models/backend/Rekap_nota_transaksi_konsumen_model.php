<?php
class Rekap_nota_transaksi_konsumen_model extends CI_Model{
	
	var $tabletransaksi = 'tbl_transaksi';
	var $tablecicil = 'tbl_cicil';
	var $column_search_transaksi = array('kode_transaksi_list'); 
	var $column_search_cicil = array('kode_transaksi_cicil');

	var $tablelisttransaksi = 'tbl_list_transaksi';
	var $tableaddstock = 'tbl_add_stock';
	var $column_search_addstock = array('bahan_baku_id'); 
	var $column_search_listtransaksi = array('id_transaksi','kode_transaksi','id_konsumen_transaksi','jumlah_dibayar','jenis_transaksi','total_belanja','dapatkan_hutang','id_user_transaksi','catatan','tgl_transaksi'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		//add custom filter here
		if($this->input->post('kode_transaksi'))
		{
			$this->db->like('kode_transaksi', $this->input->post('kode_transaksi'));
		}
		if($this->input->post('id_konsumen_transaksi'))
		{
			$this->db->like('id_konsumen_transaksi', $this->input->post('id_konsumen_transaksi'));
		}
		if($this->input->post('jenis_transaksi'))
		{
			$this->db->like('jenis_transaksi', $this->input->post('jenis_transaksi'));
		}

		$this->db->from($this->tablelisttransaksi);
		$i = 0;
		foreach ($this->column_search_listtransaksi as $item) 
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

				if(count($this->column_search_listtransaksi) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}

	function get_datatables(){
	
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_list_transaksi.id_user_transaksi' , 'left' );
		$this->db->join ( 'tbl_konsumen', 'tbl_konsumen.id_konsumen = tbl_list_transaksi.id_konsumen_transaksi' , 'left' );
		$this->db->order_by('id_transaksi', 'desc');
		
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
		$this->db->from($this->tablelisttransaksi);
		return $this->db->count_all_results();
	}
	function count_all_biaya(){
        $query = $this->db->query("SELECT SUM(jumlah_dibayar) AS biaya FROM tbl_list_transaksi");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
	
    public function get_by_id($id_transaksi)
	{
		$this->db->from($this->tablelisttransaksi);
		$this->db->where('id_transaksi',$id_transaksi);
		$query = $this->db->get();
		return $query->row();
	}

	
    function get_detail_tambah_stok($id_transaksi){
    	$result = $this->db->query("SELECT tbl_list_transaksi.*,kode_transaksi,id_konsumen_transaksi,jumlah_dibayar,jenis_transaksi,total_belanja,dapatkan_hutang,id_user_transaksi,catatan,tgl_transaksi,user_name FROM tbl_list_transaksi 
			LEFT JOIN tbl_user ON tbl_user.user_id = tbl_list_transaksi.id_user_transaksi
			WHERE tbl_list_transaksi.id_transaksi='$id_transaksi'");
    	return $result;
    }
    function get_detail_konsumen($id_konsumen_transaksi){
    	$result = $this->db->query("SELECT tbl_konsumen.*,nama,alamat,no_hp FROM tbl_konsumen WHERE id_konsumen='$id_konsumen_transaksi'");
    	return $result;
    }
    function get_detail_cicilan($kode_add_stock_selesai){
    	$result = $this->db->query("SELECT tbl_cicil.*,jumlah_telah_dibayar FROM tbl_cicil WHERE kode_transaksi_cicil='$kode_add_stock_selesai'");
    	return $result;
    }
    function get_tambah_stock($kode_add_stock_selesai) {
		
		$this->db->select('tbl_transaksi.*, kode_transaksi_list,konsumen_transaksi_id,bahan_baku_id,jumlah_transaksi,harga_jual_transaksi,harga_modal_transaksi,check_proses_transaksi,transaksi_user_id,tgl_buat_transaksi,nama_stock,nama_satuan');
		$this->db->from ( 'tbl_transaksi' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_transaksi.transaksi_user_id' , 'left' );
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_transaksi.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->where('kode_transaksi_list', $kode_add_stock_selesai);
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return NULL;
	}

	////////////////////////////////////////////////// EDIT
    function get_detail_nota($id){
		$this->db->select("tbl_list_transaksi.*, nama,catatan,cicilan,telah_dibayar,jumlah_telah_dibayar,tgl_update_bayar,user_name");
		$this->db->from('tbl_list_transaksi');
		$this->db->join('tbl_konsumen', 'tbl_konsumen.id_konsumen=tbl_list_transaksi.id_konsumen_transaksi','left');
		$this->db->join('tbl_cicil', 'tbl_cicil.kode_transaksi_cicil=tbl_list_transaksi.kode_transaksi','left');
		$this->db->join('tbl_user', 'tbl_user.user_id=tbl_list_transaksi.id_user_transaksi','left');
		$this->db->join('tbl_transaksi', 'tbl_transaksi.kode_transaksi_list=tbl_list_transaksi.kode_transaksi','left');
		$this->db->where ( 'tbl_list_transaksi.kode_transaksi', $id);
		$this->db->order_by('id_transaksi', 'DESC');
		$query = $this->db->get();
		return $query;
	}

    //  
	function get_kode_rekap($id){
		$query = $this->db->query("SELECT tbl_list_transaksi.* FROM tbl_list_transaksi 
			WHERE kode_transaksi='$id' AND jenis_transaksi NOT IN ('Cash') GROUP BY kode_transaksi LIMIT 1");
		return $query;
	}
	
	
	public function add_cash($NewID,$id_cicil_cancel,$ket_cash,$jumlah_dibayar)
    {	
    	$hsl=$this->db->query("INSERT INTO tbl_rekap_cash(id_cicil_cancel,nota_cash,ket_cash,total_cash) VALUES ('$id_cicil_cancel','$NewID','$ket_cash','$jumlah_dibayar')");
    	return $hsl;
    }
    public function delete_cash($id_cicil_cancel,$id_notas)
    {
        return $this->db->delete('tbl_rekap_cash', array('id_cicil_cancel' => $id_cicil_cancel,'nota_cash' => $id_notas));
    }
    
	private function _get_datatables_query_edit()
	{
		$this->db->from($this->tablecicil);
		$i = 0;
		foreach ($this->column_search_cicil as $item) 
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

				if(count($this->column_search_cicil) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables_cicil($id){
		$id_users = $this->session->userdata('id');
		
		$this->db->where('kode_transaksi_cicil', $id);
		
		$this->db->order_by('id', 'desc');
		$this->_get_datatables_query_edit();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered_edit($id)
	{
		$id_users = $this->session->userdata('id');
		$this->_get_datatables_query_edit();
		$this->db->where('kode_transaksi_cicil', $id);
		
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_edit($id)
	{
		$id_users = $this->session->userdata('id');
		$this->db->from($this->tablecicil);
		$this->db->where('kode_transaksi_cicil', $id);
		
		return $this->db->count_all_results();
	}
	public function single_entry_cicilan($id_notas)
    {
        $this->db->select('*');
        $this->db->from('tbl_cicil');
        $this->db->where('kode_transaksi_cicil', $id_notas);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    function get_list_transaksi($id_notas){
    	$result = $this->db->query("SELECT tbl_list_transaksi.*,dapatkan_hutang,jenis_transaksi,jumlah_dibayar,total_belanja FROM tbl_list_transaksi WHERE kode_transaksi='$id_notas'");
    	return $result;
    }
    function get_konsumen($id_konsumen_cicil){
    	$result = $this->db->query("SELECT tbl_konsumen.*,nama FROM tbl_konsumen WHERE id_konsumen='$id_konsumen_cicil'");
    	return $result;
    }
    public function paid_entry($id_notas,$id_konsumen_cicil,$cicilan,$hasil_telah_bayar,$hasil_jumlah,$rubah_list_dapatkan_hutang,$rubah_list_jenis_transaksi)
    {
    	$id_users = $this->session->userdata('id');
    	$hsl = $this->db->query("UPDATE tbl_cicil SET telah_dibayar='$hasil_telah_bayar',jumlah_telah_dibayar='$hasil_jumlah',id_user_cicil='$id_users',tgl_update_bayar=NOW() where kode_transaksi_cicil='$id_notas'");
        $hsl = $this->db->query("UPDATE tbl_list_transaksi SET dapatkan_hutang='$rubah_list_dapatkan_hutang',jenis_transaksi='$rubah_list_jenis_transaksi',jumlah_dibayar=jumlah_dibayar+'$cicilan',id_user_transaksi='$id_users',tgl_ubah=NOW() where kode_transaksi='$id_notas'");
        $hsl = $this->db->query("UPDATE tbl_konsumen SET hutang=hutang-'$cicilan',tgl_ubah_konsumen=NOW() where id_konsumen='$id_konsumen_cicil'");
        return $hsl;
    }
    public function unpaid_entry($id_notas,$id_konsumen_cicil,$cicilan,$hasil_telah_bayar,$hasil_jumlah,$rubah_list_dapatkan_hutang,$rubah_list_jenis_transaksi)
    {
    	$id_users = $this->session->userdata('id');
    	$hsl = $this->db->query("UPDATE tbl_cicil SET telah_dibayar='$hasil_telah_bayar',jumlah_telah_dibayar='$hasil_jumlah',id_user_cicil='$id_users',tgl_update_bayar=NOW() where kode_transaksi_cicil='$id_notas'");
        $hsl = $this->db->query("UPDATE tbl_list_transaksi SET dapatkan_hutang='$rubah_list_dapatkan_hutang',jenis_transaksi='$rubah_list_jenis_transaksi',jumlah_dibayar=jumlah_dibayar-'$cicilan',id_user_transaksi='$id_users' where kode_transaksi='$id_notas'");
        $hsl = $this->db->query("UPDATE tbl_konsumen SET hutang=hutang+'$cicilan',tgl_ubah_konsumen=NOW() where id_konsumen='$id_konsumen_cicil'");
        return $hsl;
    }
	////////////////////////////////////////////////// EDIT
	

	
    public function single_entry_transaksi_list($id_notas)
    {
        $this->db->select('*');
        $this->db->from('tbl_list_transaksi');
        $this->db->where('kode_transaksi', $id_notas);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
   
   

    //DETAIL
    function get_kode_detail($id){
		$query = $this->db->query("SELECT tbl_list_transaksi.* FROM tbl_list_transaksi 
			WHERE kode_transaksi='$id' GROUP BY kode_transaksi LIMIT 1");
		return $query;
	}
	private function _get_datatables_query_detail()
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
    function get_datatables_detail($id){
		
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_transaksi.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->where('kode_transaksi_list', $id);
		$this->db->order_by('transaksi_id', 'desc');
		$this->_get_datatables_query_detail();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_filtered_detail($id)
	{
	
		$this->_get_datatables_query_detail();
		$this->db->where('kode_transaksi_list', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detail($id)
	{
		
		$this->db->from($this->tabletransaksi);
		$this->db->where('kode_transaksi_list', $id);
		return $this->db->count_all_results();
	}
	public function pembatalan_nota($id_notas)
    {
    	$hsl = $this->db->delete('tbl_list_transaksi', array('kode_transaksi' => $id_notas));
    	$hsl = $this->db->delete('tbl_cicil', array('kode_transaksi_cicil' => $id_notas));
    	$hsl = $this->db->delete('tbl_rekap_cash', array('nota_cash' => $id_notas));
        return $hsl;
    }
    function get_hutang_konsumen($id_konsumen_transaksi){
    	$result = $this->db->query("SELECT tbl_konsumen.*,id_konsumen,hutang FROM tbl_konsumen WHERE id_konsumen='$id_konsumen_transaksi'");
    	return $result;
    }
    public function update_hutang_konsumen($id_konsumen_transaksi, $ajax_data_konsumen)
    {
        return $this->db->update('tbl_konsumen', $ajax_data_konsumen, array('id_konsumen' => $id_konsumen_transaksi));
    }
    public function delete_entry($transaksi_id,$jmlh,$kembalikan_nilai_saham,$bahan_baku,$konsumen)
    {
    	$hsl = $this->db->query("UPDATE tbl_stock_produksi SET stock=stock+'$jmlh',nilai_saham=nilai_saham+'$kembalikan_nilai_saham',harga_beli=harga_beli+'$kembalikan_nilai_saham',tgl_ubah=NOW() where kode_stock='$bahan_baku'");
        $hsl = $this->db->delete('tbl_transaksi', array('transaksi_id' => $transaksi_id));
        
        return $hsl;
    }

   
	
}