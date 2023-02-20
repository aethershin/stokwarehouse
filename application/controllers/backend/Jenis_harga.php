<?php
class Jenis_harga extends CI_Controller{
/**
* Description of Controller
*
* @author https://aethershin.com
*/	
	function __construct(){
		parent::__construct();
		error_reporting(0);
		if($this->session->userdata('access') != "1"){
			$url=base_url('login_user');
            redirect($url);
		};
		$this->load->model('backend/Jenis_harga_model','jenis_harga_model');
		$this->load->model('backend/Stock_model','stock_model');
		$this->load->model('Site_model','site_model');
		$this->load->helper('text');
		$this->load->helper('url');
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $x['site_title'] = $site['site_title'];
        $x['site_favicon'] = $site['site_favicon'];
        $x['images'] = $site['images'];
		$x['title'] = 'Jenis Harga';
		$x['produksi'] = $this->jenis_harga_model->get_all_produksi();
		$this->load->view('backend/menu',$x);
		$this->load->view('backend/modal/jenis_harga_modal');
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_jenis_harga',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->jenis_harga_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $d->nama_jenis_harga;
			$row[] = $d->nama_stock;
			$row[] = "Rp " . number_format($d->jenis_harga, 0, "", ",");
			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7"><a class="dropdown-item item_edit" href="javascript:void()" title="Edit" onclick="edit_jharga('."'".$d->kode_jharga."'".')"><i class="bi bi-pen-fill"></i> Edit</a>
				<a class="dropdown-item delete_record" href="javascript:void()" title="Hapus" id="del" value="'.$d->kode_jharga.'"><i class="bi bi-trash"></i> Hapus</a>
				</div></div></div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->jenis_harga_model->count_all(),
						"recordsFiltered" => $this->jenis_harga_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($kode_jharga)
	{
		$data = $this->jenis_harga_model->get_by_id($kode_jharga);
		echo json_encode($data);
	}

	function add(){
    	
		$this->_validate();
		$id_produksi = $this->input->post('kategori_stock',TRUE);
		$d_harga = $this->input->post('harga',TRUE);
		$file = "databasejson/jenisharga/".$id_produksi.".json";
		$get_data = file_get_contents($file);
		$array = json_decode($get_data, true);
    	// GET NEW ID
		$get_new_id = $this->jenis_harga_model->get_new_kode_jharga();
        foreach($get_new_id as $result){
            $kode_New_id =  $result->maxKode;
        }
        $noUrut = (int) substr($kode_New_id, 4, 12);
        $noUrut++;
        $char = "JHG-";
        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
        $dapatkan_harga = "Rp " . number_format($d_harga, 0, "", ",");
		// GET NEW ID		

        $array[] = Array (
			"id" => $NewID,
			"nama" => $this->input->post('nama',TRUE),
			"harga" => $dapatkan_harga
		);
		$json = json_encode($array);
		file_put_contents($file, $json);

			$arraysql = array(
				"kode_jharga" => $NewID,
    			"nama_jenis_harga" => $this->input->post('nama',TRUE),
    			"jenis_harga" => $this->input->post('harga',TRUE),
    			"kategori_jenis" => $this->input->post('kategori_stock'),
			);
				$insert = $this->jenis_harga_model->insert($arraysql);
				
				if($insert){
					// INSERT LOG
					$nama_jenis = $this->input->post('nama',TRUE);
					$harga = $this->input->post('harga',TRUE);
					$hargashow = "Rp " . number_format($harga, 0, "", ",");
					$nama_users = $this->session->userdata('name');
					$b = '<b>'.$nama_users.'</b> Melakukan Penambahan Jenis Harga <b>'.$nama_jenis.'</b> Dengan Harga '.$hargashow;
					$data2 = array(
						'ket' => $b,
					);
					$this->stock_model->insert_log_stock($data2);
					// INSERT LOG
					echo json_encode(array("status" => TRUE));
				}else{
					echo json_encode(array("status" => FALSE));
				}
		
    }

	
    public function edit() {
		$this->_validate_edit();
		$check_id_edit = $this->input->post('id');
		$d_harga = $this->input->post('harga',TRUE);
		$dapatkan_harga = "Rp " . number_format($d_harga, 0, "", ",");	
		$post = $this->jenis_harga_model->single_entry($check_id_edit);
		$kategori_jenis_lama = $post->kategori_jenis;
		$jenis_harga = $post->jenis_harga;
		$id_produksi = $this->input->post('kategori_stock',TRUE);
		if ($kategori_jenis_lama != $id_produksi) {
			// DELETE YANG LAMA
			$filelama = "databasejson/jenisharga/".$kategori_jenis_lama.".json";
	    	$get_data_lama = file_get_contents($filelama);
	    	$data_lama = json_decode($get_data_lama, true);
			foreach ($data_lama as $key2 => $x) {
				if ($x['id'] == $check_id_edit) {
	    			array_splice($data_lama, $key2, 1);
				}
			}
			$jsonfile_lama = json_encode($data_lama);
			file_put_contents($filelama, $jsonfile_lama);
			// DELETE YANG LAMA
			// GANTI YANG BARU
			
			$file = "databasejson/jenisharga/".$id_produksi.".json";
			$get_data = file_get_contents($file);
			$array = json_decode($get_data, true);

			$array[] = Array (
				"id" => $check_id_edit,
				"nama" => $this->input->post('nama',TRUE),
				"harga" => $dapatkan_harga
			);
			$json = json_encode($array);
			file_put_contents($file, $json);						
	    	// GANTI YANG BARU
		} else {
			$filehanyaganti = "databasejson/jenisharga/".$kategori_jenis_lama.".json";
			$get_data_hanyaganti = file_get_contents($filehanyaganti);
			// Mendecode Data_matakuliah.json
			$array_hanyaganti = json_decode($get_data_hanyaganti, true);
	    	// Membaca data array menggunakan foreach
			
			foreach ($array_hanyaganti as $key3 => $z) {
			// Perbarui data kedua
				if ($z['id'] == $check_id_edit) {
	    			$array_hanyaganti[$key3]['nama'] = $this->input->post('nama');
	    			$array_hanyaganti[$key3]['harga'] = $dapatkan_harga;
				}
			}
			// Mengencode data menjadi json
			$jsonfile_hanyaganti = json_encode($array_hanyaganti);
			file_put_contents($filehanyaganti, $jsonfile_hanyaganti);
		}
			

		$arraysql = array(
			"nama_jenis_harga" => $this->input->post('nama',TRUE),
    		"jenis_harga" => $this->input->post('harga',TRUE),
    		"kategori_jenis" => $this->input->post('kategori_stock',TRUE),
		);
		$this->jenis_harga_model->update(array('kode_jharga' => $this->input->post('id')), $arraysql);
		// update ke mysql
					// INSERT LOG
					$nama_jenis = $this->input->post('nama',TRUE);
					$harga = $this->input->post('harga',TRUE);
					$hargashow = "Rp " . number_format($harga, 0, "", ",");
					$nama_users = $this->session->userdata('name');
					$b = '<b>'.$nama_users.'</b> Melakukan Perubahan Jenis Harga <b>'.$nama_jenis.'</b> Dengan Harga '.$jenis_harga.' Menjadi '.$hargashow;
					$data2 = array(
						'ket' => $b,
					);
					$this->stock_model->insert_log_stock($data2);
					// INSERT LOG
		echo json_encode(array("status" => TRUE));	
    }
    public function delete() {
    	if ($this->input->is_ajax_request()) {
    		$check_id_edit = $this->input->post('id');
    		$post = $this->jenis_harga_model->single_entry($check_id_edit);
			$kategori_jenis_lama = $post->kategori_jenis;
			$nama_jenis_harga = $post->nama_jenis_harga;
	    	$file = "databasejson/jenisharga/".$kategori_jenis_lama.".json";
	    	$get_data = file_get_contents($file);
	    	$data = json_decode($get_data, true);
				foreach ($data as $key => $d) {
	    			if ($d['id'] == $check_id_edit) {
	        			array_splice($data, $key, 1);
	    			}
				}
				$jsonfile = json_encode($data);
				file_put_contents($file, $jsonfile);

				if ($this->jenis_harga_model->delete_entry($check_id_edit)) {
					// INSERT LOG
					
					$hargashow = "Rp " . number_format($harga, 0, "", ",");
					$nama_users = $this->session->userdata('name');
					$b = '<b>'.$nama_users.'</b> Melakukan Hapus Jenis Harga <b>'.$nama_jenis_harga.'</b>';
					$data2 = array(
						'ket' => $b,
					);
					$this->stock_model->insert_log_stock($data2);
					// INSERT LOG
					$data = array('res' => "success", 'message' => "Data berhasil dihapus");
				} else {
					$data = array('res' => "error", 'message' => "Delete query error");
				}
				echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
    }

    private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
	    $nama = $this->input->post('nama');
		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Form Nama Jenis harus berisi';
			$data['status'] = FALSE;
		}
		$namalength= strlen($nama);
		if($namalength < 3)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Jenis Minimal 3 karakter';
			$data['status'] = FALSE;
		}
		if($this->input->post('harga') == '')
		{
			$data['inputerror'][] = 'harga';
			$data['error_string'][] = 'Form Harga harus berisi';
			$data['status'] = FALSE;
		}
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private function _validate_edit()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
    	$nama = $this->input->post('nama');
		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Form Nama Jenis harus berisi';
			$data['status'] = FALSE;
		}
		$namalength= strlen($nama);
		if($namalength < 3)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Jenis Minimal 3 karakter';
			$data['status'] = FALSE;
		}
		if($this->input->post('harga') == '')
		{
			$data['inputerror'][] = 'harga';
			$data['error_string'][] = 'Form Harga harus berisi';
			$data['status'] = FALSE;
		}
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	


}