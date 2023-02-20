<?php
class Surat_jalan extends CI_Controller{
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
		$this->load->model('backend/Surat_jalan_model','surat_jalan_model');
		$this->load->model('Site_model','site_model');
		$this->load->library('upload');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('download');
		$this->load->helper('tanggal');
		
		
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_favicon'] = $site['site_favicon'];
        $data['images'] = $site['images'];
		$data['title'] = 'Buat Surat Jalan';
		$data['bbaku'] = $this->surat_jalan_model->get_all_bbaku();
		$data['produksi'] = $this->surat_jalan_model->get_all_produksi();
		$data['karyawan'] = $this->surat_jalan_model->get_all_karyawan();
		
		$produksi_belum_selesai = $this->surat_jalan_model->count_produksi_belum_selesai();
		$row = $produksi_belum_selesai->row_array();
		$data['produksi_belum_selesai'] = $row['produksi'];
		$this->load->view('backend/menu',$data);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_surat_jalan', $data);
	}
	public function get_ajax_list()
	{
		$list = $this->surat_jalan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		
			$row[] = $no;
			$row[] = $d->nama_stock;
			$row[] = $d->jumlah_ls_surat_jalan;
			
			$row[] = '<a class="btn icon btn-danger" href="javascript:void()" title="Minus" id="minus" value="'.$d->ls_surat_jalan_id.'"><i class="bi bi-file-minus"></i></a>&nbsp;&nbsp;<a class="btn icon btn-success" href="javascript:void()" title="Plus" id="plus" value="'.$d->ls_surat_jalan_id.'"><i class="bi bi-file-plus"></i></a>
						&nbsp;&nbsp;&nbsp;<a class="btn icon btn-primary btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->ls_surat_jalan_id.'"><i class="bi bi-trash"></i> Hapus</a>';
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->surat_jalan_model->count_all(),
						"recordsFiltered" => $this->surat_jalan_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
  
	
	function add() {
		if ($this->input->is_ajax_request()) {
			$bahan_baku = $this->input->post('bahan_baku');
		
			$jumlah = $this->input->post('jumlah');
		$cek_bahan_baku = $this->surat_jalan_model->validasi_bahan($bahan_baku);
	    if($cek_bahan_baku->num_rows() > 0){
	    	$data = array('res' => "duplicate", 'message' => "Change query error");
	    } else {
	    	$datas = $this->surat_jalan_model->get_stocks($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $stock = $bx['stock'];	

		    if($stock < $jumlah) { 
		    	$data = array('res' => "stok_habis", 'message' => "Change query error");
		    } else {

			// GET NEW ID
			$get_new_id = $this->surat_jalan_model->get_new_kode_add_surat_jalan();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "SJL-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID
	        		$id_users = $this->session->userdata('id');
					$data2 = array(
						'kode_ls_surat_jalan' => $NewID,
						'bahan_baku_id' => $this->input->post('bahan_baku'),
						'jumlah_ls_surat_jalan' => $this->input->post('jumlah'),
						'ls_surat_jalan_user_id' => $id_users,
					);
			
				if ($this->surat_jalan_model->insert_stock($data2)) {
					$data = array('res' => "success", 'message' => "Data berhasil ditambah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
				}
			}
		}
			
			echo json_encode($data);
		
		} else {
			echo "No direct script access allowed";
		}
		
	}



	
	public function delete()
	{
		if ($this->input->is_ajax_request()) {
			
			$ls_surat_jalan_id = $this->input->post('id');
		

	
				if ($this->surat_jalan_model->delete_entry($ls_surat_jalan_id)) {
					$data = array('res' => "success", 'message' => "Data berhasil dihapus");
				} else {
					$data = array('res' => "error", 'message' => "Delete query error");
				}
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	public function minus()
	{
		if ($this->input->is_ajax_request()) {

			$ls_surat_jalan_id = $this->input->post('ls_surat_jalan_id');
			$post = $this->surat_jalan_model->single_entry($ls_surat_jalan_id);
			$jmlh = $post->jumlah_ls_surat_jalan;
			
			
			    
		    
				if ($jmlh < 2) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->surat_jalan_model->minus_entry($ls_surat_jalan_id)) {
					$data = array('res' => "success", 'message' => "Data berhasil dirubah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
				}
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	public function plus()
	{
		if ($this->input->is_ajax_request()) {

			$ls_surat_jalan_id = $this->input->post('ls_surat_jalan_id');
			$post = $this->surat_jalan_model->single_entry($ls_surat_jalan_id);
			$jmlh = $post->jumlah_ls_surat_jalan;
			$bahan_baku = $post->bahan_baku_id;


			$datas = $this->surat_jalan_model->get_stocks($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $stock = $bx['stock'];
		    
			if($stock <= $jmlh) { 
			    	$data = array('res' => "stok_habis", 'message' => "Change query error");
			} else {
		    	if ($this->surat_jalan_model->plus_entry($ls_surat_jalan_id)) {
					$data = array('res' => "success", 'message' => "Data berhasil dirubah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
				}
			}
			

			
				
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	
	public function prosessuratjalan()
	{
		if ($this->input->is_ajax_request()) {

			
			$catatan = $this->input->post('catatan');
			$diserahkan = $this->input->post('diserahkan');
			$penerima = $this->input->post('penerima');
			$diketahui = $this->input->post('diketahui');
			$totaljumlah = $this->input->post('totaljumlah');
			$totaljumlahlog = number_format($totaljumlah, 0, "", ",");
			$id_users = $this->session->userdata('id');
			
			// GET NEW ID
			$get_new_id = $this->surat_jalan_model->get_new_kode_add_surat_jalan();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "SJL-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID
			
			

		    	if ($this->surat_jalan_model->plus_entry_surat_jalan($NewID,$totaljumlah,$catatan,$id_users,$diserahkan,$penerima,$diketahui)) {
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Membuat Surat jalan dengan Kode :('.$NewID.')';
					$data2 = array(
						'ket' => $b,
					);
					$this->surat_jalan_model->insert_log_stock($data2);
					// INSERT LOG
					$data = array('res' => "success", 'message' => "Data berhasil dirubah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
				}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
  
	
	

}