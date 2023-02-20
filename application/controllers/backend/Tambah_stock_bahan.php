<?php
class Tambah_stock_bahan extends CI_Controller{
/**
* Description of Controller
*
* @author https://aethershin.com
*/	
	function __construct(){
		parent::__construct();
		error_reporting(0);
		if($this->session->userdata('access') != "2" && $this->session->userdata('access') != "1"){
			$url=base_url('login_user');
            redirect($url);
		};
		$this->load->model('backend/Tambah_stock_bahan_model','tambah_stock_bahan_model');
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
		$data['title'] = 'Form Tambah Stok Bahan';
		$data['bbaku'] = $this->tambah_stock_bahan_model->get_all_bbaku();
		$data['produksi'] = $this->tambah_stock_bahan_model->get_all_produksi();
		$produksi_belum_selesai = $this->tambah_stock_bahan_model->count_produksi_belum_selesai();
		$row = $produksi_belum_selesai->row_array();
		$data['produksi_belum_selesai'] = $row['produksi'];
		$this->load->view('backend/menu',$data);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_tambah_stock_bahan', $data);
	}
	public function get_ajax_list()
	{
		$list = $this->tambah_stock_bahan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		
			$row[] = $no;
			$row[] = $d->nama_stock;
			$row[] = number_format($d->jumlah_add_stock, 0, "", ",");
			
			$row[] = "Rp. " . number_format($d->biaya_dikeluarkan, 0, "", ",");
			$row[] = '<a class="btn icon btn-danger" href="javascript:void()" title="Minus" id="minus" value="'.$d->add_stock_id.'"><i class="bi bi-file-minus"></i></a>&nbsp;&nbsp;<a class="btn icon btn-success" href="javascript:void()" title="Plus" id="plus" value="'.$d->add_stock_id.'"><i class="bi bi-file-plus"></i></a>
						&nbsp;&nbsp;&nbsp;<a class="btn icon btn-primary btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->add_stock_id.'"><i class="bi bi-trash"></i> Hapus</a>';
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->tambah_stock_bahan_model->count_all(),
						"recordsFiltered" => $this->tambah_stock_bahan_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
  
	
	function add(){
		if ($this->input->is_ajax_request()) {

			$bahan_baku = $this->input->post('bahan_baku');
			$y = $this->input->post('jumlah');
		$cek_bahan_baku = $this->tambah_stock_bahan_model->validasi_bahan($bahan_baku);
	    if($cek_bahan_baku->num_rows() > 0){
	    	$data = array('res' => "duplicate", 'message' => "Change query error");
	    } else {

				$datas = $this->tambah_stock_bahan_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $z = $bx['stock'];
			    $zz = $bx['harga_beli'];
			    $xxx = $bx['nilai_saham'];
			    $x = $z + $y;
			    $zzz = $zz*$y;
				$xxxx = $xxx+$zzz;
			// GET NEW ID
			$get_new_id = $this->tambah_stock_bahan_model->get_new_kode_add_stock();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "TSB-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID

			$ajax_data_stocks['stock'] = $x;
			$ajax_data_stocks['nilai_saham'] = $xxxx;
			date_default_timezone_set('Asia/Jakarta');
			$ajax_data_stocks['tgl_ubah'] = date("Y-m-d H:i:a");
				if ($this->tambah_stock_bahan_model->update_entry_stocks($bahan_baku, $ajax_data_stocks)) {
					$id_users = $this->session->userdata('id');
					$data2 = array(
						'kode_add_stock' => $NewID,
						'bahan_baku_id' => $this->input->post('bahan_baku'),
						'jumlah_add_stock' => $this->input->post('jumlah'),
						'biaya_dikeluarkan' => $zzz,
						'add_stock_stock_user_id' => $id_users,
					);
					$this->tambah_stock_bahan_model->insert_stock($data2);
					$data = array('res' => "success", 'message' => "Data berhasil ditambah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
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

			$add_stock_id = $this->input->post('id');
			$post = $this->tambah_stock_bahan_model->single_entry($add_stock_id);
			$jmlh = $post->jumlah_add_stock;
			$bahan_baku = $post->bahan_baku_id;
			$nilai_saham = $post->biaya_dikeluarkan;
			
			
				if ($this->tambah_stock_bahan_model->delete_entry($add_stock_id,$jmlh,$nilai_saham,$bahan_baku)) {
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

			$add_stock_id = $this->input->post('add_stock_id');
			$post = $this->tambah_stock_bahan_model->single_entry($add_stock_id);
			$bahan_baku = $post->bahan_baku_id;
			$jumlah_add_stock = $post->jumlah_add_stock;
			$biaya_dikeluarkan = $post->biaya_dikeluarkan;

			$datas = $this->tambah_stock_bahan_model->get_stocks($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $harga_beli = $bx['harga_beli'];
		    
				if ($jumlah_add_stock < 2) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->tambah_stock_bahan_model->minus_entry($add_stock_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli)) {
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

			$add_stock_id = $this->input->post('add_stock_id');
			$post = $this->tambah_stock_bahan_model->single_entry($add_stock_id);
			$bahan_baku = $post->bahan_baku_id;
			$biaya_dikeluarkan = $post->biaya_dikeluarkan;

			$datas = $this->tambah_stock_bahan_model->get_stocks($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $harga_beli = $bx['harga_beli'];
		    	if ($this->tambah_stock_bahan_model->plus_entry($add_stock_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli)) {
					$data = array('res' => "success", 'message' => "Data berhasil dirubah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
				}
			

			
				
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	
	public function prosestambahstokbahan()
	{
		if ($this->input->is_ajax_request()) {

			$catatan = $this->input->post('catatan');
			$suplier = $this->input->post('suplier');
			$totalbiaya = $this->input->post('totalbiaya',TRUE);
			$totaljumlah = $this->input->post('totaljumlah');
			$totaljumlahshow = number_format($totaljumlah, 0, "", ",");
			$id_users = $this->session->userdata('id');
			// GET NEW ID
			$get_new_id = $this->tambah_stock_bahan_model->get_new_kode_add_stock();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "TSB-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID
			

		    	if ($this->tambah_stock_bahan_model->plus_entry_produksi($NewID,$totaljumlah,$catatan,$suplier,$id_users,$totalbiaya)) {
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Melakukan Penambahan Stok Material <b> sebanyak '.$totaljumlahshow.' Pcs</b>';
					$data2 = array(
						'ket' => $b,
					);
					$this->tambah_stock_bahan_model->insert_log_stock($data2);
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
  
	
    private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$bahan_baku = $this->input->post('bahan_baku',TRUE);
		$jumlah2 = $this->input->post('jumlah',TRUE);

		$cek_bahan_baku = $this->tambah_stock_bahan_model->validasi_bahan($bahan_baku);
	    if($cek_bahan_baku->num_rows() > 0){
	    	$row = $cek_bahan_baku->row();
	    	$jmlh_old2 = $row->jumlah;
			$data['inputerror'][] = 'bahan_baku_alert';
			$data['error_string'][] = 'Duplikat Bahan Baku';
			$data['status'] = FALSE;
	    }
	    $datass = $this->tambah_stock_bahan_model->get_stocks($bahan_baku);
		error_reporting(0);
	    $bxx = $datass->row_array();
	    $zz = $bxx['stock'];
		if($zz < $jumlah2)
		{
			$data['inputerror'][] = 'jumlah';
			$data['error_string'][] = 'Stock Tidak Cukup';
			$data['status'] = FALSE;
		}
		if($this->input->post('bahan_baku') == '')
		{
			$data['inputerror'][] = 'bahan_baku_alert';
			$data['error_string'][] = 'Form Bahan Baku harus berisi';
			$data['status'] = FALSE;
		}
		if($this->input->post('jumlah') == '')
		{
			$data['inputerror'][] = 'jumlah';
			$data['error_string'][] = 'Form Jumlah harus berisi';
			$data['status'] = FALSE;
		}

		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	

}