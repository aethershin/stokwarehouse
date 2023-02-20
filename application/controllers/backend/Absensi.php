<?php
class Absensi extends CI_Controller{
/**
* Description of Controller
*
* @author https://aethershin.com
*/	
	function __construct(){
		parent::__construct();
		//ini_set('memory_limit', "256M");
		error_reporting(0);
		if($this->session->userdata('logged') !=TRUE){
            $url=base_url('login_user');
            redirect($url);
        };
		$this->load->model('backend/Absensi_model','absensi_model');
		$this->load->model('backend/Transaksi_model','transaksi_model');
		$this->load->model('Site_model','site_model');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('tanggal');
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $x['site_title'] = $site['site_title'];
        $x['site_favicon'] = $site['site_favicon'];
        $x['images'] = $site['images'];
		$x['title'] = 'Absensi';
		$x['id'] = $this->session->userdata('id');
		$x['karyawan'] = $this->absensi_model->get_all_karyawan();
		$this->load->view('backend/menu',$x);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_absensi',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->absensi_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $d->user_name;
			$row[] = $d->kehadiran;
			$row[] = format_indo(date($d->tgl_absensi_masuk));
			$row[] = format_indo(date($d->tgl_absensi_keluar));
			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7"><a class="dropdown-item item_edit" href="javascript:void()" title="Edit" onclick="edit_person('."'".$d->id_absensi."'".')"><i class="bi bi-pen-fill"></i> Edit</a>
				  <a class="dropdown-item delete_record" href="javascript:void()" title="Hapus" id="del" value="'.$d->id_absensi.'"><i class="bi bi-trash"></i> Hapus</a></div></div></div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->absensi_model->count_all(),
						"recordsFiltered" => $this->absensi_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

    public function masuk() {
    	if ($this->input->is_ajax_request()) {
    		$id = $this->input->post('id');
    		
	    	$cek_absensi = $this->absensi_model->validasi_absen_masuk($id);
		    if($cek_absensi->num_rows() > 0){
				$data = array('res' => "errorduplicateabsen", 'message' => "Delete query error");
		    }else{

		    	// COBA TERLAMBAT
				date_default_timezone_set("Asia/Jakarta");
				$DATE_FORMAT = "Y-m-d H:i:s";
				$waktu = date($DATE_FORMAT);
				$kehadiran = 'Tepat Waktu';

				if ($this->absensi_model->isTerlambatMasuk($waktu)) {
				    $kehadiran = 'Terlambat';
				}
				if ($this->absensi_model->CannotSubmitMasuk($waktu)) {
				    $data = array('res' => "errorbelumjamkerja", 'message' => "Delete query error");
				} else {
					if ($this->absensi_model->CannotSubmitMasukClosed($waktu)) {
				    	$data = array('res' => "errorbelumjamkerja", 'message' => "Delete query error");
					} else {
				// COBA TERLAMBAT	

						if ($this->absensi_model->insert_absen_masuk($id,$kehadiran)) {
				    		// INSERT LOG
							$nama_users = $this->session->userdata('name');
							date_default_timezone_set('Asia/Jakarta');
							$tglmasuk = date("Y-m-d H:i:a");
							$ket_tanggal = format_indo(date($tglmasuk));
							$b = '<b>'.$nama_users.' '.$kehadiran.'</b> Melakukan <b>Absen Masuk</b> Pada '.$ket_tanggal;
							$data2 = array(
								'ket' => $b,
							);
							$this->transaksi_model->insert_log_stock($data2);
							// INSERT LOG
							$data = array('res' => "success", 'message' => "Data berhasil dihapus");
						} else {
							$data = array('res' => "error", 'message' => "Delete query error");
						}
					}
				}
				// COBA TERLAMBAT


		    	
		    }
				
				echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
    }

    public function keluar() {
    	if ($this->input->is_ajax_request()) {
    		$id = $this->input->post('id');
	    	$cek_absensi = $this->absensi_model->validasi_absen_keluar($id);
	    	$cek_absensi_masuk_dulu = $this->absensi_model->validasi_absen_masukdulu($id);
		    if($cek_absensi->num_rows() > 0){
				$data = array('res' => "errorduplicateabsen", 'message' => "Delete query error");
		    }else{
		    	if($cek_absensi_masuk_dulu->num_rows() <= 0){
					$data = array('res' => "errormasukdulu", 'message' => "Delete query error");
		    	}else{
		    		// COBA TERLAMBAT
					date_default_timezone_set("Asia/Jakarta");
					$DATE_FORMAT = "Y-m-d H:i:s";
					$waktu = date($DATE_FORMAT);
					

					
					if ($this->absensi_model->CannotSubmitKeluar($waktu)) {
					    $data = array('res' => "errorbelumjampulang", 'message' => "Delete query error");
					} else {
						if ($this->absensi_model->CannotSubmitKeluarClosed($waktu)) {
					    	$data = array('res' => "errorbelumjampulang", 'message' => "Delete query error");
						} else {
					// COBA TERLAMBAT

					    	if ($this->absensi_model->insert_absen_keluar($id)) {
					    		// INSERT LOG
								$nama_users = $this->session->userdata('name');
								date_default_timezone_set('Asia/Jakarta');
								$tglmasuk = date("Y-m-d H:i:a");
								$ket_tanggal = format_indo(date($tglmasuk));
								$b = '<b>'.$nama_users.'</b> Melakukan <b>Absen Keluar</b> Pada '.$ket_tanggal;
								$data2 = array(
									'ket' => $b,
								);
								$this->transaksi_model->insert_log_stock($data2);
								// INSERT LOG
								$data = array('res' => "success", 'message' => "Data berhasil dihapus");
							} else {
								$data = array('res' => "error", 'message' => "Delete query error");
							}
						}
					}
				}
		    }
				
				echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
    }
  


}