<?php
class Absensi_model extends CI_Model{
	
	
	var $tableabsensi = 'tbl_absensi';
	var $jamkerja = 'tbl_jam_kerja';
	
	var $column_search_absensi = array('id_user_absensi','kehadiran'); 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		//add custom filter here
		if($this->input->post('id_user_absensi'))
		{
			$this->db->like('id_user_absensi', $this->input->post('id_user_absensi'));
		}
		if($this->input->post('kehadiran'))
		{
			$this->db->like('kehadiran', $this->input->post('kehadiran'));
		}
		$this->db->from($this->tableabsensi);
		$i = 0;
		foreach ($this->column_search_absensi as $item) 
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

				if(count($this->column_search_absensi) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		
	}
	function get_datatables(){
		$id_user = $this->session->userdata('id');
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_absensi.id_user_absensi' , 'left' );
		$this->db->order_by('id_absensi', 'desc');
		if($this->session->userdata('access')=='1') {

		} else {
			$this->db->where('id_user_absensi', $id_user);
		}
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_filtered()
	{
		$id_user = $this->session->userdata('id');
		$this->_get_datatables_query();
		if($this->session->userdata('access')=='1') {

		} else {
			$this->db->where('id_user_absensi', $id_user);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$id_user = $this->session->userdata('id');
		$this->db->from($this->tableabsensi);
		if($this->session->userdata('access')=='1') {

		} else {
			$this->db->where('id_user_absensi', $id_user);
		}
		return $this->db->count_all_results();
	}
	
	function get_all_karyawan(){
		$this->db->select('tbl_user.*');
		$this->db->from('tbl_user');
		$this->db->where('user_level', 3);
		$this->db->or_where('user_level', 2);
		$this->db->order_by('user_id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function insert_satuan($arraysql){
		$insert = $this->db->insert($this->tableabsensi, $arraysql);
		if($insert){
			return true;
		}
	}
	
	// TERLAMBAT LOGIC
	function isTerlambatMasuk($waktu) {
	

	    $batas_waktu_menit = 8 * 60; # diatas 08:00 dihitung terlambat
	    
	    $waktu_time = strtotime($waktu);
	    $waktu_menit = date('H', $waktu_time) * 60 + date('i', $waktu_time);
	    
	    return $waktu_menit > $batas_waktu_menit;
	}
	function CannotSubmitMasuk($waktu) {
			
			  
	    $batas_waktu_menit = 7 * 60; # Lakukan Absen pada jam 07:00
	    
	    $waktu_time = strtotime($waktu);
	    $waktu_menit = date('H', $waktu_time) * 60 + date('i', $waktu_time);
	    
	    return $waktu_menit < $batas_waktu_menit;
	}
	function CannotSubmitMasukClosed($waktu) {
		
	    $batas_waktu_menit = 12 * 60; # diatas 12:00 tidak bisa absen keluar
	    
	    $waktu_time = strtotime($waktu);
	    $waktu_menit = date('H', $waktu_time) * 60 + date('i', $waktu_time);
	    
	    return $waktu_menit > $batas_waktu_menit;
	}
	function CannotSubmitKeluar($waktu) {
		
	    $batas_waktu_menit = 17 * 60; # Lakukan Absen pada jam 17:00
	    
	    $waktu_time = strtotime($waktu);
	    $waktu_menit = date('H', $waktu_time) * 60 + date('i', $waktu_time);
	    
	    return $waktu_menit < $batas_waktu_menit;
	}
	function CannotSubmitKeluarClosed($waktu) {
		
	    $batas_waktu_menit = 19 * 60; # diatas 19:00 tidak bisa absen keluar
	    
	    $waktu_time = strtotime($waktu);
	    $waktu_menit = date('H', $waktu_time) * 60 + date('i', $waktu_time);
	    
	    return $waktu_menit > $batas_waktu_menit;
	}
	// TERLAMBAT LOGIC
	function validasi_absen_masuk($id){
		$id_user = $this->session->userdata('id');
		$user_ip=$_SERVER['REMOTE_ADDR'];
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot(); 
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent='Other';
        }
		$hsl=$this->db->query("SELECT * FROM tbl_absensi WHERE id_user_absensi='$id_user' AND DATE(tgl_absensi_masuk)=CURDATE()");
		return $hsl;
	}
	function insert_absen_masuk($id,$kehadiran){
		$user_ip=$_SERVER['REMOTE_ADDR'];
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot(); 
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent='Other';
        }
        $ket_absensi = '1';
		$hsl=$this->db->query("INSERT INTO tbl_absensi (id_user_absensi,ip_adress_absensi_masuk,ip_adress_absensi_keluar,ket_absensi,tgl_absensi_keluar,kehadiran) VALUES('$id','$user_ip','-','$ket_absensi','-','$kehadiran')");
        return $hsl;
	}

	function validasi_absen_keluar($id){
		$id_user = $this->session->userdata('id');
		$user_ip=$_SERVER['REMOTE_ADDR'];
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot(); 
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent='Other';
        }
		$hsl=$this->db->query("SELECT * FROM tbl_absensi WHERE id_user_absensi='$id_user' AND ket_absensi='2' AND DATE(tgl_absensi_keluar)=CURDATE()");
		return $hsl;
	}
	function validasi_absen_masukdulu($id){
		$id_user = $this->session->userdata('id');
		$user_ip=$_SERVER['REMOTE_ADDR'];
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot(); 
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent='Other';
        }
		$hsl=$this->db->query("SELECT * FROM tbl_absensi WHERE id_user_absensi='$id_user' AND ket_absensi='1' AND DATE(tgl_absensi_masuk)=CURDATE()");
		return $hsl;
	}
	function insert_absen_keluar($id){
		$user_ip=$_SERVER['REMOTE_ADDR'];
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        }elseif ($this->agent->is_robot()){
            $agent = $this->agent->robot(); 
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent='Other';
        }
        $ket_absensi = '2';
        $hsl = $this->db->query("UPDATE tbl_absensi SET ip_adress_absensi_keluar='$user_ip',ket_absensi='$ket_absensi',tgl_absensi_keluar=NOW() WHERE id_user_absensi='$id' AND ket_absensi=1 AND DATE(tgl_absensi_masuk)=CURDATE()");

        return $hsl;
	}


 
	
}