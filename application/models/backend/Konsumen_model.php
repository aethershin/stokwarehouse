<?php
class Konsumen_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	
	var $tablekonsumen = 'tbl_konsumen';
	var $tablecicil = 'tbl_cicil';
	var $column_search_cicil = array('id'); 
	var $tablelog = 'tbl_log';
	var $column_search_konsumen = array('nama','alamat','no_hp','hutang','id_cus'); 
	var $order = array('id_konsumen' => 'desc'); // default order 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		//add custom filter here
		if($this->input->post('nama'))
		{
			$this->db->like('nama', $this->input->post('nama'));
		}
		if($this->input->post('alamat'))
		{
			$this->db->like('alamat', $this->input->post('alamat'));
		}
		if($this->input->post('nohp'))
		{
			$this->db->like('nohp', $this->input->post('nohp'));
		}

		

		
		

		
		$this->db->from($this->tablekonsumen);
		$i = 0;
		foreach ($this->column_search_konsumen as $item) 
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

				if(count($this->column_search_konsumen) - 1 == $i) 
					$this->db->group_end(); 
			}
			$column_search_stock[$i] = $item; // set column array variable to order processing
			$i++;
		}
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column_search_stock[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		
		
	}
	function get_datatables(){
		$this->db->order_by('id_konsumen', 'desc');
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
		$this->db->from($this->tablekonsumen);
		return $this->db->count_all_results();
	}
	function count_all_stock(){
        $query = $this->db->query("SELECT SUM(hutang) AS stock FROM tbl_konsumen");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }

    function get_new_id_cus(){
        
        $query = $this->db->query("SELECT max(id_cus) as maxKode FROM tbl_konsumen");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
                            
    }
    public function get_by_id($id_konsumen)
	{
		$this->db->from($this->tablekonsumen);
		$this->db->where('id_konsumen',$id_konsumen);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_stock($data){
		$insert = $this->db->insert($this->tablekonsumen, $data);
		if($insert){
			return true;
		}
	}
	function insert_log_stock($data2){
		$insert = $this->db->insert($this->tablelog, $data2);
		if($insert){
			return true;
		}
	}
	public function update_entry($id, $data)
    {
        return $this->db->update('tbl_konsumen', $data, array('id_konsumen' => $id));
    }
	public function single_entry($id_konsumen)
    {
        $this->db->select('*');
        $this->db->from('tbl_konsumen');
        $this->db->where('id_konsumen', $id_konsumen);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    public function update_lock($id_konsumen, $data)
    {
        return $this->db->update('tbl_konsumen', $data, array('id_konsumen' => $id_konsumen));
    }
    function delete_entry($id_konsumen)
    {
        return $this->db->delete('tbl_konsumen', array('id_konsumen' => $id_konsumen));
        
    }

	function get_id_cus($id_cus){
		$query = $this->db->query("SELECT tbl_konsumen.* FROM tbl_konsumen 
			WHERE id_cus='$id_cus' GROUP BY id_cus LIMIT 1");
		return $query;
	}
	
	function get_detail_riwayat($id){
    	$result = $this->db->query("SELECT tbl_konsumen.*,nama,id_cus,alamat,no_hp,hutang FROM tbl_konsumen WHERE id_cus='$id'");
    	return $result;
    }
    function get_id_cus2($id_kon){
    	$result = $this->db->query("SELECT tbl_konsumen.*,id_cus,nama FROM tbl_konsumen WHERE id_konsumen='$id_kon'");
    	return $result;
    }
    function riwayat_pembelian($id_konsumen){
		date_default_timezone_set('Asia/Jakarta');
		$bulan =date('m');
		
		$this->db->select("tbl_transaksi.*,SUM(IF(konsumen_transaksi_id='$id_konsumen', jumlah_transaksi, 0)) AS jumlah, nama_stock AS stk");
		$this->db->from('tbl_transaksi');
        $this->db->join('tbl_stock_produksi', 'tbl_stock_produksi.kode_stock=tbl_transaksi.bahan_baku_id','left');
		
		$this->db->group_by('tbl_transaksi.bahan_baku_id');
		$query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    

    private function _get_datatables_query_cicil()
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
			$column_search_stock[$i] = $item; // set column array variable to order processing
			$i++;
		}
		
		
		
	}
	function get_datatables_cicil($id){
		
		
		$this->db->where('id_konsumen_cicil', $id);
		$this->db->where('jumlah_telah_dibayar >=', 0);

		$this->db->order_by('id', 'desc');
		$this->_get_datatables_query_cicil();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered_cicil($id)
	{
		$id_users = $this->session->userdata('id');
		$this->_get_datatables_query_cicil();
		$this->db->where('id_konsumen_cicil', $id);
		$this->db->where('jumlah_telah_dibayar >=', 0);
		
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_cicil($id)
	{
		$id_users = $this->session->userdata('id');
		$this->db->from($this->tablecicil);
		$this->db->where('id_konsumen_cicil', $id);
		$this->db->where('jumlah_telah_dibayar >=', 0);
		
		return $this->db->count_all_results();
	}
	function get_jenis_cicilan($ket_cicilan){
    	$result = $this->db->query("SELECT tbl_jenis_cicilan.*,id_jenis_cicilan,nama_cicilan,tenor,jumlah_tenor FROM tbl_jenis_cicilan WHERE nama_cicilan='$ket_cicilan'");
    	return $result;
    }
	function import($data){
		$insert = $this->db->insert_batch('tbl_konsumen', $data);
		if($insert){
			return true;
		}
	}


}

	
