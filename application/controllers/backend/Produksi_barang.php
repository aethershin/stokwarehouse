<?php
class Produksi_barang extends CI_Controller{
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
		$this->load->model('backend/Produksi_barang_model','produksi_barang_model');
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
		$data['title'] = 'Produksi Barang Untuk Pengantaran';
		$data['bbaku'] = $this->produksi_barang_model->get_all_bbaku();
		$data['produksi'] = $this->produksi_barang_model->get_all_produksi();
		$produksi_belum_selesai = $this->produksi_barang_model->count_produksi_belum_selesai();
		$row = $produksi_belum_selesai->row_array();
		$data['produksi_belum_selesai'] = $row['produksi'];
		$this->load->view('backend/menu',$data);
		$this->load->view('backend/modal/produksi_stock_modal');
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_produksi_barang', $data);
	}
	public function get_ajax_list()
	{
		$list = $this->produksi_barang_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		

			$row[] = $no;
			$row[] = $d->nama_stock;
			
			$row[] = number_format($d->jumlah, 0, "", ",").' '.$d->nama_satuan.'<b>';
			$row[] = "Rp. " . number_format($d->biaya_dikeluarkan, 0, "", ",");
			$row[] = '<a class="btn icon btn-danger" href="javascript:void()" title="Minus" id="minus" value="'.$d->produksi_id.'"><i class="bi bi-file-minus"></i></a>&nbsp;&nbsp;<a class="btn icon btn-success" href="javascript:void()" title="Plus" id="plus" value="'.$d->produksi_id.'"><i class="bi bi-file-plus"></i></a>
						&nbsp;&nbsp;&nbsp;<a class="btn icon btn-primary btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->produksi_id.'"><i class="bi bi-trash"></i> Hapus</a>';
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->produksi_barang_model->count_all(),
						"recordsFiltered" => $this->produksi_barang_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
  	
	
	function add(){
		$bahan_baku = $this->input->post('bahan_baku');
		$this->_validate();
		
			// GET NEW ID
			$get_new_id = $this->produksi_barang_model->get_new_kode_produksi();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "PDB-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID
		
				$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $id_stock = $bx['id_stock'];
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $kategori_stock = $bx['kategori_stock'];
			    $nilai_saham = $bx['nilai_saham'];
			    
				$jumlah_biasa = $this->input->post('jumlah');
					
					$hasil_pengurangan_stock = $stock - $jumlah_biasa;	
					$hasil_pengurangan_saham = $harga_beli*$jumlah_biasa;

				$nilai_saham_update = $nilai_saham-$hasil_pengurangan_saham;
				$ajax_data_stocks['stock'] = $hasil_pengurangan_stock;
				$ajax_data_stocks['nilai_saham'] = $nilai_saham_update;
				date_default_timezone_set('Asia/Jakarta');
				$ajax_data_stocks['tgl_ubah'] = date("Y-m-d H:i:a");
				$id_user = $this->session->userdata('id');
				if ($this->produksi_barang_model->update_entry_stocks($bahan_baku, $ajax_data_stocks)) {
					$data2 = array(
						'kode_produksi' => $NewID,
						'bahan_baku_id' => $this->input->post('bahan_baku'),
						'jumlah' => $this->input->post('jumlah'),
						'biaya_dikeluarkan' => $hasil_pengurangan_saham,
						'produksi_stock_user_id' => $id_user,
					);
					$insert = $this->produksi_barang_model->insert_stock($data2);
					
					if($insert){
						
						echo json_encode(array("status" => TRUE));
					}else{
						echo json_encode(array("status" => FALSE));
					}
				} else {
					echo json_encode(array("status" => FALSE));
				}
			
		
	}



	
	public function delete()
	{
		if ($this->input->is_ajax_request()) {

			$produksi_id = $this->input->post('id');
			$post = $this->produksi_barang_model->single_entry($produksi_id);
			$jmlh = $post->jumlah;
			$bahan_baku = $post->bahan_baku_id;
			$nilai_saham = $post->biaya_dikeluarkan;

			$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $kategori_stock = $bx['kategori_stock'];
			    $nilai_saham = $bx['nilai_saham'];
			    $id_stock = $bx['id_stock'];
			   
				
					$hasil_penambahan_stock = $stock+$jmlh;	
					$hasil_penambahan_saham = $harga_beli*$jmlh;

			
				if ($this->produksi_barang_model->delete_entry($produksi_id,$hasil_penambahan_stock,$hasil_penambahan_saham,$bahan_baku)) {
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

			$produksi_id = $this->input->post('id');
			$post = $this->produksi_barang_model->single_entry($produksi_id);
			$bahan_baku = $post->bahan_baku_id;
			$jumlah_bahan = $post->jumlah;
			$biaya_dikeluarkan = $post->biaya_dikeluarkan;

			$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
			    $kategori_stock = $bx['kategori_stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
			    $id_stock = $bx['id_stock'];
			    
				$jumlah_biasa = 1;

					$hasil_penambahan_stock = $stock + $jumlah_biasa;	
					$hasil_penambahan_saham = $harga_beli;

				
		    
				if ($jumlah_bahan < 2) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->produksi_barang_model->minus_entry($produksi_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli,$hasil_penambahan_stock,$hasil_penambahan_saham)) {
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

			$produksi_id = $this->input->post('id');
			$post = $this->produksi_barang_model->single_entry($produksi_id);
			$bahan_baku = $post->bahan_baku_id;
			$biaya_dikeluarkan = $post->biaya_dikeluarkan;

			$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $kategori_stock = $bx['kategori_stock'];
			    $nilai_saham = $bx['nilai_saham'];
			    $id_stock = $bx['id_stock'];
			    
				$jumlah_biasa = 1;

					$hasil_penambahan_stock = $stock-$jumlah_biasa;	
					$hasil_penambahan_saham = $harga_beli;

				
		    	if ($stock < $jumlah_biasa) {
		    		$data = array('res' => "error", 'message' => "Change query error");
		    	} else if ($this->produksi_barang_model->plus_entry($produksi_id,$bahan_baku,$stokkekurangan,$biaya_dikeluarkan,$harga_beli,$hasil_penambahan_stock,$hasil_penambahan_saham)) {
					$data = array('res' => "success", 'message' => "Data berhasil dirubah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
				}
			

			
				
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	
	public function prosesproduksi()
	{
		if ($this->input->is_ajax_request()) {

			$bahan_baku = $this->input->post('nama_produksi');
			$jumlah_produksi = $this->input->post('jumlah_produksi');
			$catatan_produksi = $this->input->post('catatan_produksi');
			$totalbiaya = $this->input->post('totalbiaya');
			$id_users = $this->session->userdata('id');
			// GET NEW ID
			$get_new_id = $this->produksi_barang_model->get_new_kode_produksi();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "PDB-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID
			

			$datas = $this->produksi_barang_model->get_stocks_produksi($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $j = $bx['nama_stock'];
		    $stock = $bx['stock'];
		    $harga_beli = $bx['harga_beli'];
		    $nilai_saham = $bx['nilai_saham'];
		    $stock_jumlah_produksi = $stock+$jumlah_produksi;
		    $hargabeli_total_bayar = $harga_beli+$totalbiaya;
		    $nilai_saham_totalbiaya = $nilai_saham+$totalbiaya;

		    	if ($this->produksi_barang_model->plus_entry_produksi($NewID,$bahan_baku,$catatan_produksi,$id_users,$stock_jumlah_produksi,$hargabeli_total_bayar,$nilai_saham_totalbiaya,$jumlah_produksi,$totalbiaya)) {
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Melakukan Produksi Barang <b>'.$j.' sebanyak '.$jumlah_produksi.'</b>';
					$data2 = array(
						'ket' => $b,
					);
					$this->produksi_barang_model->insert_log_stock($data2);
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

		$cek_bahan_baku = $this->produksi_barang_model->validasi_bahan($bahan_baku);
	    if($cek_bahan_baku->num_rows() > 0){
	    	$row = $cek_bahan_baku->row();
	    	$jmlh_old2 = $row->jumlah;
			$data['inputerror'][] = 'bahan_baku_alert';
			$data['error_string'][] = 'Duplikat Bahan Baku';
			$data['status'] = FALSE;
	    }
	    $datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
			    $kategori_stock = $bx['kategori_stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
			    $id_stock = $bx['id_stock'];
			    
				$jumlah_biasa = $this->input->post('jumlah');
				
				
		if($stock < $jumlah_biasa)
		{
			$data['inputerror'][] = 'jumlah';
			$data['error_string'][] = 'Stock Tidak Cukup';
			$data['status'] = FALSE;
		}
		if($this->input->post('bahan_baku') == '')
		{
			$data['inputerror'][] = 'bahan_baku_alert';
			$data['error_string'][] = 'Form Material harus berisi';
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