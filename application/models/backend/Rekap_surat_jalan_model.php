<?php
class Rekap_surat_jalan_model extends CI_Model{
	
	
	var $tablesurat_jalan = 'tbl_surat_jalan';
	var $tablelog = 'tbl_log';
	var $tabledetailsuratjalan = 'tbl_list_surat_jalan';
	var $column_search_detail = array('bahan_baku_id'); 
	var $column_search_surat_jalan = array('kode_surat_jalan','jumlah_surat_jalan'); 
	
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		//add custom filter here
		if($this->input->post('kode_surat_jalan'))
		{
			$this->db->like('kode_surat_jalan', $this->input->post('kode_surat_jalan'));
		}

		$this->db->from($this->tablesurat_jalan);
		$i = 0;
		foreach ($this->column_search_surat_jalan as $item) 
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

				if(count($this->column_search_surat_jalan) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}

	function get_datatables(){
	
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_surat_jalan.id_user_surat_jalan' , 'left' );

		$this->db->order_by('surat_jalan_id', 'desc');
		
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
		$this->db->from($this->tablesurat_jalan);
		return $this->db->count_all_results();
	}
	function count_all_biaya(){
        $query = $this->db->query("SELECT SUM(jumlah_surat_jalan) AS biaya FROM tbl_surat_jalan");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
	
    public function get_by_id($produksi_selesai_id)
	{
		$this->db->from($this->tablesurat_jalan);
		$this->db->where('produksi_selesai_id',$produksi_selesai_id);
		$query = $this->db->get();
		return $query->row();
	}
	function get_detail_surat_jalan($surat_jalan_id){
    	$result = $this->db->query("SELECT tbl_surat_jalan.*,kode_surat_jalan,jumlah_surat_jalan,id_user_surat_jalan,diserahkan_sj,penerima_sj,diketahui_sj,catatan_surat_jalan,tgl_surat_jalan,tgl_ubah_surat_jalan FROM tbl_surat_jalan WHERE surat_jalan_id='$surat_jalan_id'");
    	return $result;
    }
    
    function get_tambah_surat_jalan($kode_surat_jalan) {
		
		$this->db->select('tbl_list_surat_jalan.*, bahan_baku_id,jumlah_ls_surat_jalan,nama_stock,user_name,nama_satuan');
		$this->db->from ( 'tbl_list_surat_jalan' );
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_list_surat_jalan.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_list_surat_jalan.ls_surat_jalan_user_id' , 'left' );
		$this->db->where('kode_ls_surat_jalan', $kode_surat_jalan);
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return NULL;
	}
	function get_tambah_retur($kode_surat_jalan) {
		
		$this->db->select('tbl_list_retur_barang.*, retur_bahan_baku_id,retur_jumlah,nama_stock,user_name,nama_satuan');
		$this->db->from ( 'tbl_list_retur_barang' );
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_list_retur_barang.retur_bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_list_retur_barang.retur_user_id' , 'left' );
		$this->db->where('retur_kode_surat_jalan', $kode_surat_jalan);
		$query = $this->db->get ();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return NULL;
	}
	function get_kode_rekap($id){
		$query = $this->db->query("SELECT tbl_surat_jalan.* FROM tbl_surat_jalan 
			WHERE kode_surat_jalan='$id' GROUP BY kode_surat_jalan LIMIT 1");
		return $query;
	}
	function count_bretur($kode_surat_jalan) {
            $result = $this->db->query("SELECT SUM(retur_jumlah) AS bretur FROM tbl_list_retur_barang WHERE retur_kode_surat_jalan='$kode_surat_jalan'");
            return $result;
    }
	function get_detail_nota($id){
    	$result = $this->db->query("SELECT tbl_surat_jalan.*,kode_surat_jalan,jumlah_surat_jalan,id_user_surat_jalan,diserahkan_sj,penerima_sj,diketahui_sj,catatan_surat_jalan,tgl_surat_jalan,tgl_ubah_surat_jalan FROM tbl_surat_jalan WHERE kode_surat_jalan='$id'");
    	return $result;
    }
    private function _get_datatables_query_detail()
	{
		$this->db->from($this->tabledetailsuratjalan);
		$i = 0;
		foreach ($this->column_search_detail as $item) 
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

				if(count($this->column_search_detail) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
    function get_datatables_detail($id){
	
		$this->db->join ( 'tbl_stock_produksi', 'tbl_stock_produksi.kode_stock = tbl_list_surat_jalan.bahan_baku_id' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock_produksi.satuan_stock' , 'left' );
		$this->db->where('kode_ls_surat_jalan', $id);
		$this->db->order_by('ls_surat_jalan_id', 'desc');

		$this->_get_datatables_query_detail();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered_detail($id)
	{
		$this->_get_datatables_query_detail();
		$this->db->where('kode_ls_surat_jalan', $id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detail($id)
	{
		$this->db->from($this->tabledetailsuratjalan);
		$this->db->where('kode_ls_surat_jalan', $id);
		return $this->db->count_all_results();
	}
	function get_all_retur_by_kode($id){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select("tbl_list_retur_barang.*,nama_stock");
		$this->db->from('tbl_list_retur_barang');
		$this->db->join('tbl_stock_produksi', 'tbl_stock_produksi.kode_stock=tbl_list_retur_barang.retur_bahan_baku_id','left');
		$this->db->where ( 'retur_kode_surat_jalan', $id);
		$this->db->order_by('retur_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function delete_entry($kode_surat_jalan)
    {
    	
        $hsl = $this->db->delete('tbl_surat_jalan', array('kode_surat_jalan' => $kode_surat_jalan));
        $hsl = $this->db->delete('tbl_list_surat_jalan', array('kode_ls_surat_jalan' => $kode_surat_jalan));
        $hsl = $this->db->delete('tbl_list_retur_barang', array('retur_kode_surat_jalan' => $kode_surat_jalan));
        return $hsl;
    }
	
	
	
}