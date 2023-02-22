<?php
class Konsumen extends CI_Controller{
/**
* Description of Controller
*
* @author https://aethershin.com
*/	
	function __construct(){
		parent::__construct();
		error_reporting(0);
		if($this->session->userdata('access') != "3" && $this->session->userdata('access') != "1"){
			$url=base_url('login_user');
            redirect($url);
		};
		$this->load->model('backend/Konsumen_model','konsumen_model');
		$this->load->model('Site_model','site_model');
		$this->load->library('upload');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('download');
		$this->load->helper('tanggal');
		$this->load->library(array('excel','session'));
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_favicon'] = $site['site_favicon'];
        $data['images'] = $site['images'];
		$data['title'] = 'Konsumen';
		$total = $this->konsumen_model->count_all_stock();
		foreach($total as $result){
            $data['all'] = "Rp. " . number_format($result->stock, 0, "", ",");
        }
        $this->load->view('backend/menu',$data);
		
		$this->load->view('backend/modal/konsumen_modal');
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_konsumen', $data);
	}
	public function get_ajax_list()
	{
		$list = $this->konsumen_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$status = $d->user_status;
			
			if ($status == 1) {
				$class = 'lock';
				$ket = 'Nonaktifkan Konsumen';
				$icon = 'check';
				$actket = 'Aktif';
				$actclass = 'success';
			} else {
				$class = 'unlock';
				$ket = 'Aktifkan Konsumen';
				$icon = 'exclamation';
				$actket = 'Nonaktif';
				$actclass = 'danger';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $d->id_cus;
			$row[] = $d->nama;
			$row[] = $d->alamat;
			$row[] = $d->no_hp;
			$row[] = '<div class="alert alert-light-'.$actclass.' color-'.$actclass.'"><i class="bi bi-'.$icon.'-circle"></i>'.$actket.'</div>';

			
			
				$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
				<a class="dropdown-item" href="javascript:void()" id="detail" data-id="'.$d->id_cus.'"><i class="bi bi-eye"></i> Detail Riwayat</a>
				<a class="dropdown-item" href="javascript:void()" title="Edit" onclick="edit_konsumen('."'".$d->id_konsumen."'".')"><i class="bi bi-pen-fill"></i> Edit</a>
				<a class="dropdown-item" href="javascript:void()" title="Lock" id="lock" value="'.$d->id_konsumen.'"><i class="bi bi-'.$class.'"></i> '.$ket.'</a>
				<a class="dropdown-item" href="javascript:void()" title="Hapus" id="deletekonsumen" value="'.$d->id_konsumen.'"><i class="bi bi-trash"></i> Hapus</a></div></div></div>';
			
			
			
			
			$data[] = $row;
		}
			
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->konsumen_model->count_all(),
						"recordsFiltered" => $this->konsumen_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
			
		echo json_encode($output);
	}
  	function download(){
		$path="assets/files/FormatKonsumen.xlsx";
		$data =  file_get_contents($path);
		$name = 'FormatKonsumen.xlsx';
		force_download($name, $data); 
		redirect('backend/konsumen');
	}
	public function ajax_edit($id_konsumen)
	{
		$data = $this->konsumen_model->get_by_id($id_konsumen);
		echo json_encode($data);
	}
	function add(){
		$this->_validate();
		
		
		$users = $this->session->userdata('id');
		$nama_users = $this->session->userdata('name');
		// GET NEW ID
		$get_new_id = $this->konsumen_model->get_new_id_cus();
        foreach($get_new_id as $result){
            $kode_New_id =  $result->maxKode;
        }
        $noUrut = (int) substr($kode_New_id, 4, 12);
        $noUrut++;
        $char = "CST-";
        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
		// GET NEW ID

				$data = array(
					'id_cus' => $NewID,
					'nama' => $this->input->post('nama'),
					'alamat' => $this->input->post('alamat'),
					'no_hp' => $this->input->post('nohp'),
					'user_status' => 1,
					'hutang' => 0,
				);
				$insert = $this->konsumen_model->insert_stock($data);
				
				if($insert){
					// INSERT LOG
					
					$j = $this->input->post('nama');
					$b = '<b>'.$nama_users.'</b> Melakukan Tambah Konsumen <b>'.$j.'</b>';
					$data2 = array(
						'ket' => $b,
					);
					$this->konsumen_model->insert_log_stock($data2);
					// INSERT LOG
					echo json_encode(array("status" => TRUE));
				}else{
					echo json_encode(array("status" => FALSE));
				}
			
		
	}



	function edit(){
		$id=$this->input->post('id',TRUE);
		$this->_validate_edit();
		
			    	
					$users = $this->session->userdata('id');
					$ajax_data['nama'] = $this->input->post('nama');
					$ajax_data['alamat'] = $this->input->post('alamat');
					$ajax_data['no_hp'] = $this->input->post('nohp');
					date_default_timezone_set("Asia/Jakarta");
					$ajax_data['tgl_ubah_konsumen'] = date("Y-m-d H:i:a");
					

					if ($this->konsumen_model->update_entry($id, $ajax_data)) {
						// INSERT LOG
						$nama_users = $this->session->userdata('name');

						$j = $this->input->post('nama');
						$b = '<b>'.$nama_users.'</b> Melakukan Edit Konsumen <b>'.$j.'</b>';
						$data2 = array(
							'ket' => $b,
						);
						$this->konsumen_model->insert_log_stock($data2);
						// INSERT LOG
						echo json_encode(array("status" => TRUE));
					} else {
						echo json_encode(array("status" => FALSE));
					}
						
	}

	
	public function deletekonsumen()
	{
		if ($this->input->is_ajax_request()) {

			$id_konsumen = $this->input->post('idkon');

			
			
				if ($this->konsumen_model->delete_entry($id_konsumen)) {
					
					$data = array('res' => "success", 'message' => "Proses berhasil dilakukan");
				} else {
					$data = array('res' => "error", 'message' => "Proses gagal dilakukan");
				}
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	public function lock()
	{
		if ($this->input->is_ajax_request()) {

			$id_konsumen = $this->input->post('id_konsumen');

			$post = $this->konsumen_model->single_entry($id_konsumen);
			if ($post->user_status == 1) {

				$ajax_data['user_status'] = 0;
							
				if ($this->konsumen_model->update_lock($id_konsumen, $ajax_data)) {
					$data = array('res' => "success", 'message' => "Proses berhasil dilakukan");
				} else {
					$data = array('res' => "error", 'message' => "Proses gagal dilakukan");
				}

				
			} else {
				$ajax_data['user_status'] = 1;
							
				if ($this->konsumen_model->update_lock($id_konsumen, $ajax_data)) {
					$data = array('res' => "success", 'message' => "Proses berhasil dilakukan");
				} else {
					$data = array('res' => "error", 'message' => "Proses gagal dilakukan");
				}
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
		$alamat = $this->input->post('alamat');
		$nohp = $this->input->post('nohp');

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('alamat') == '')
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Form Alamat harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('nohp') == '')
		{
			$data['inputerror'][] = 'nohp';
			$data['error_string'][] = 'Form No HP harus berisi';
			$data['status'] = FALSE;
		}
		

		$namalength= strlen($nama);
		if($namalength < 3)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Miminal 3 Karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 25)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Maksimal 25 Karakter';
			$data['status'] = FALSE;
		}
		$alamatlength= strlen($alamat);
		if($alamatlength < 3)
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat Miminal 3 Karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 50)
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat Maksimal 50 Karakter';
			$data['status'] = FALSE;
		}
		if(!preg_match("/^(\+62|62|0)8[1-9][0-9]{9,10}$/", $nohp)) {
		  	$data['inputerror'][] = 'nohp';
			$data['error_string'][] = 'Format No HP harus diawali 62, minimal 13 angka dan maksimal 14 angka';
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
		$alamat = $this->input->post('alamat');
		$nohp = $this->input->post('nohp');

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('alamat') == '')
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Form Alamat harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('nohp') == '')
		{
			$data['inputerror'][] = 'nohp';
			$data['error_string'][] = 'Form No HP harus berisi';
			$data['status'] = FALSE;
		}
		

		$namalength= strlen($nama);
		if($namalength < 3)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Miminal 3 Karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 25)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Maksimal 25 Karakter';
			$data['status'] = FALSE;
		}
		$alamatlength= strlen($alamat);
		if($alamatlength < 3)
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat Miminal 3 Karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 50)
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat Maksimal 50 Karakter';
			$data['status'] = FALSE;
		}
		if(!preg_match("/^(\+62|62|0)8[1-9][0-9]{9,10}$/", $nohp)) {
		  	$data['inputerror'][] = 'nohp';
			$data['error_string'][] = 'Format No HP harus diawali 62, minimal 13 angka dan maksimal 14 angka';
			$data['status'] = FALSE;
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function detail(){
		$id = $this->uri->segment(4);
		$get_kode=$this->konsumen_model->get_id_cus($id);
		if($get_kode->num_rows() > 0){
		
			
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Detail Riwayat';
			
			
			$data['id_cus'] = $id;

				$datas = $this->konsumen_model->get_detail_riwayat($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $data['id'] = $bx['id_konsumen'];
			   	$id_konsumen = $bx['id_konsumen']; 
			    $data['name'] = $bx['nama'];
			  

			    

			    $hutang = $bx['hutang'];
			    $data['hutangshow'] = "Rp. " . number_format($hutang, 0, "", ",");
			    
			    // Stok Produksi
				$produksi = $this->konsumen_model->riwayat_pembelian($id_konsumen);
				foreach($produksi as $result2){
		            $namesproduk[] = $result2->stk; 
		            $valuespembelian[] = (float) $result2->jumlah;
		        }
		        $data['namesproduk'] = json_encode($namesproduk);
		        $data['valuespembelian'] = json_encode($valuespembelian);
				// Stok Produksi
			    $this->load->view('backend/menu',$data);
				$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_detail_riwayat',$data);
		} else {
			redirect('backend/customer');
		}
	}

	public function get_ajax_list_cicil()
	{
		$id = $this->input->post('id');
		$list = $this->konsumen_model->get_datatables_cicil($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
				$ket_cicilan = $d->ket_cicilan;
				$jumlah_telah_dibayar = $d->jumlah_telah_dibayar;
				$jumlah_cicilan = $d->jumlah_cicilan;
				$tgl_cicil = $d->tgl_update;
				$jenis_cicilan = $d->jenis_cicilan;
				$tgl_lunas = $d->tgl_update_bayar;
			    $date1 = $tgl_cicil;
			  
			if ($jumlah_cicilan == $jumlah_telah_dibayar && $jumlah_telah_dibayar > 0) {
					$listjatuhtempo = 'Telah Dilunasi pada '.format_indo(date($tgl_lunas));

			} else if ($jenis_cicilan == 'Bulanan') {
				date_default_timezone_set("Asia/Jakarta");
				$date = new DateTime($date1);

				$datajcicilan = $this->konsumen_model->get_jenis_cicilan($ket_cicilan);
				error_reporting(0);
			    $jc = $datajcicilan->row_array();
			    $jumlah_tenor = $jc['jumlah_tenor'];
				for ($x=0; $x<$jumlah_tenor; $x++) {
			    	$date_plus = $date->modify("+30 days");
					$hasil1 = $date_plus->format("Y-m-d");
			    }
			    $listjatuhtempo = $this->getDatesFromRangeBulanan($date1, $hasil1);
			} else if ($jenis_cicilan == 'Mingguan') {
				date_default_timezone_set("Asia/Jakarta");
				$date = new DateTime($date1);

				$datajcicilan2 = $this->konsumen_model->get_jenis_cicilan($ket_cicilan);
				error_reporting(0);
			    $jcc = $datajcicilan2->row_array();
			    $jumlah_tenor2 = $jcc['jumlah_tenor'];
				for ($x=0; $x<$jumlah_tenor2; $x++) {
			    	$date_plus = $date->modify("+7 days");
					$hasil1 = $date_plus->format("Y-m-d");
			    }
			    $listjatuhtempo = $this->getDatesFromRangeMingguan($date1, $hasil1);
			} else {
				$listjatuhtempo = 'Tidak Tersedia';
			}
			$no++;
			$row = array();
			$row[] = '<a class="dropdown-item detail" href="javascript:void()" data-id="'.$d->kode_transaksi_cicil.'"><i class="bi bi-eye"></i> '.$d->kode_transaksi_cicil.'</a>';
			$row[] = $d->ket_cicilan;
			$row[] = "Rp. " . number_format($d->cicilan, 0, "", ",");
			$row[] = $d->jumlah_telah_dibayar;
			
			
			$row[] = $listjatuhtempo;
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->konsumen_model->count_all_cicil($id),
						"recordsFiltered" => $this->konsumen_model->count_filtered_cicil($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	function getDatesFromRangeBulanan($start, $end, $format = 'Y-m-d') {
	    $array = array();
	    $interval = new DateInterval('P30D');

	    $realEnd = new DateTime($end);
	    $realEnd->add($interval);

	    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

	    foreach($period as $dates) { 
	        $arrays = $dates->format($format); 
	        $array[] = format_indo(date($arrays)).'<br/>';
	    }

	    return $array;
	}
	function getDatesFromRangeMingguan($start, $end, $format = 'Y-m-d') {
	    $array = array();
	    $interval = new DateInterval('P7D'); 

	    $realEnd = new DateTime($end);
	    $realEnd->add($interval);

	    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

	    foreach($period as $dates) { 
	        $arrays = $dates->format($format); 
	        $array[] = format_indo(date($arrays)).'<br/>';
	    }

	    return $array;
	}
	function import(){
		$allowed_excel_extension = array(
	        "xls",
	        "xlsx",
	    );
	    $file_extension_excel_1 = pathinfo($_FILES["fileExcel"]["name"], PATHINFO_EXTENSION);
		if (!in_array($file_extension_excel_1, $allowed_excel_extension)) {
	        echo $this->session->set_flashdata('msg','falied-import-ekstensi');
			redirect('backend/konsumen');
	    } else {


					// BATAS IMPORT MYSQL
					if (isset($_FILES["fileExcel"]["name"])) {
						$path = $_FILES["fileExcel"]["tmp_name"];
						$object = PHPExcel_IOFactory::load($path);
							
						foreach($object->getWorksheetIterator() as $worksheet)
						{
							// GET NEW ID
							$get_new_id = $this->konsumen_model->get_new_id_cus();
					        foreach($get_new_id as $result){
					            $kode_New_id =  $result->maxKode;
					        }
					        $noUrut = (int) substr($kode_New_id, 4, 12);
					        $noUrut++;
					        $char = "CST-";
					        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
							// GET NEW ID
							$highestRow = $worksheet->getHighestRow();
							$highestColumn = $worksheet->getHighestColumn();	
							for($row=2; $row<=$highestRow; $row++)
							{
								
								
								$nama = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
								$alamat = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
								$no_hp = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
								$hutang = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
								
								$user_level = 1;
								
								$id_users = $this->session->userdata('id');
								$temp_data[] = array(
									'id_cus'	=> $NewID++,
									'nama'	=> $nama,
									'alamat'	=> $alamat,
									'no_hp'	=> $no_hp,
									'user_status'	=> $user_level,
									'hutang'	=> $hutang
								); 
									
							}
						}
							$this->load->model('backend/konsumen_model');
							$insert = $this->konsumen_model->import($temp_data);
						if($insert){
							echo $this->session->set_flashdata('msg','success-import');
							redirect('backend/konsumen');
						}else{
							echo $this->session->set_flashdata('msg','falied-import-mysql');
							redirect('backend/konsumen');
						}
					}else{
						echo $this->session->set_flashdata('msg','falied-import-mysql');
						redirect('backend/konsumen');
					}
					// BATAS IMPORT MYSQL
		}
				
    }

}