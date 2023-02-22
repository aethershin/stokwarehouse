<?php
class Transaksi extends CI_Controller{
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
		$this->load->model('backend/Transaksi_model','transaksi_model');
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
		$data['title'] = 'Transaksi';
		//$data['bbaku'] = $this->transaksi_model->get_all_bbaku();
		//$data['produksi'] = $this->transaksi_model->get_all_produksi();
		$data['jcicilan'] = $this->transaksi_model->get_all_jcicilan();
		
		$data['jharga'] = $this->transaksi_model->get_all_jharga();
		$data['konsumen'] = $this->transaksi_model->get_all_konsumen();
		$produksi_belum_selesai = $this->transaksi_model->count_produksi_belum_selesai();
		$row = $produksi_belum_selesai->row_array();
		$data['produksi_belum_selesai'] = $row['produksi'];
		$this->load->view('backend/menupos',$data);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_transaksi', $data);
	}
	public function get_ajax_list()
	{
		$list = $this->transaksi_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		
			
			$row[] = $d->nama_stock;
			$row[] = $d->jumlah_transaksi.' '.$d->nama_satuan;
			$row[] = "Rp. " . number_format($d->harga_jual_transaksi, 0, "", ",");
			$row[] = '<a class="btn icon btn-danger" href="javascript:void()" title="Minus" id="minus" value="'.$d->transaksi_id.'"><i class="bi bi-file-minus"></i></a>&nbsp;&nbsp;<a class="btn icon btn-success" href="javascript:void()" title="Plus" id="plus" value="'.$d->transaksi_id.'"><i class="bi bi-file-plus"></i></a>
						&nbsp;&nbsp;&nbsp;<a class="btn icon btn-primary btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->transaksi_id.'"><i class="bi bi-trash"></i> Hapus</a>';
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->transaksi_model->count_all(),
						"recordsFiltered" => $this->transaksi_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
  
	
	function add(){
		if ($this->input->is_ajax_request()) {
			$bahan_baku = $this->input->post('bahan_baku');
			$jharga_id = $this->input->post('jharga');
			$jumlah = $this->input->post('jumlah');
		$cek_bahan_baku = $this->transaksi_model->validasi_bahan($bahan_baku);
	    if($cek_bahan_baku->num_rows() > 0){
	    	$data = array('res' => "duplicate", 'message' => "Change query error");
	    } else {
	    		$datas2 = $this->transaksi_model->get_jharga($jharga_id);
				error_reporting(0);
			    $bxx = $datas2->row_array();
			    $jharga = $bxx['jenis_harga'];

				$datas = $this->transaksi_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
			    $kategori_stok = $bx['kategori_stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
			    // LOGIC PENGURANGAN STOCK PRODUKSI
			    $dapat_harga_beli = $harga_beli/$stock;
			    $nsaham = $dapat_harga_beli*$jumlah;
			    $pengurangan_stock = $stock-$jumlah;
			    $pengurangan_nilai_saham = $nilai_saham-$nsaham;
			    $pengurangan_harga_beli = $nilai_saham-$nsaham;
			    // LOGIC PENGURANGAN STOCK PRODUKSI

			    // LOGIC TRANSAKSI //
			    $totalhargajual = $jharga*$jumlah;
			    if($stock < $jumlah) { 
			    	$data = array('res' => "stok_habis", 'message' => "Change query error");
			    } else {


			    // LOGIC TRANSAKSI //
			    
			// GET NEW ID
			$get_new_id = $this->transaksi_model->get_new_kode_add_transaksi();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "STR-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID

			$ajax_data_stocks['stock'] = $pengurangan_stock;
			$ajax_data_stocks['harga_beli'] = $pengurangan_harga_beli;
			$ajax_data_stocks['nilai_saham'] = $pengurangan_nilai_saham;

			$konsumen = $this->input->post('konsumen');
			date_default_timezone_set('Asia/Jakarta');
			$ajax_data_stocks['tgl_ubah'] = date("Y-m-d H:i:a");
				if ($this->transaksi_model->update_entry_stocks($bahan_baku, $ajax_data_stocks)) {
					
					$id_users = $this->session->userdata('id');
					$data2 = array(
						'kode_transaksi_list' => $NewID,
						'konsumen_transaksi_id' => $konsumen,
						'bahan_baku_id' => $this->input->post('bahan_baku'),
						'jumlah_transaksi' => $this->input->post('jumlah'),
						'harga_jual_transaksi' => $totalhargajual,
						'harga_jual_konsumen' => $jharga,
						'harga_modal_transaksi' => $dapat_harga_beli,
						'transaksi_user_id' => $id_users,
					);
					$this->transaksi_model->insert_stock($data2);
					
					
					
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
			
			$transaksi_id = $this->input->post('id');
			$post = $this->transaksi_model->single_entry($transaksi_id);
			$jmlh = $post->jumlah_transaksi;
			$bahan_baku = $post->bahan_baku_id;
			$harga_modal = $post->harga_modal_transaksi;
			$konsumen = $post->konsumen_transaksi_id;

			$kembalikan_nilai_saham = $harga_modal*$jmlh;
			
				
			
				if ($this->transaksi_model->delete_entry($transaksi_id,$jmlh,$kembalikan_nilai_saham,$bahan_baku,$konsumen)) {
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

			$transaksi_id = $this->input->post('transaksi_id');
			$post = $this->transaksi_model->single_entry($transaksi_id);
			$jmlh = $post->jumlah_transaksi;
			$bahan_baku = $post->bahan_baku_id;
			$harga_modal = $post->harga_modal_transaksi;
			$konsumen = $post->konsumen_transaksi_id;
			$harga_jual_konsumen = $post->harga_jual_konsumen;
			

			

		    
				if ($jmlh < 2) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->transaksi_model->minus_entry($transaksi_id,$bahan_baku,$biaya_dikeluarkan,$harga_modal,$harga_jual_konsumen,$konsumen)) {
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

			$transaksi_id = $this->input->post('transaksi_id');
			$post = $this->transaksi_model->single_entry($transaksi_id);
			$jmlh = $post->jumlah_transaksi;
			$bahan_baku = $post->bahan_baku_id;
			$harga_modal = $post->harga_modal_transaksi;
			$konsumen = $post->konsumen_transaksi_id;
			$harga_jual_konsumen = $post->harga_jual_konsumen;

			$datas = $this->transaksi_model->get_stocks($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $stock = $bx['stock'];
		    $kategori_stok = $bx['kategori_stock'];

			    
			if($stock < 1) { 
			    	$data = array('res' => "stok_habis", 'message' => "Change query error");
			} else {
		    	if ($this->transaksi_model->plus_entry($transaksi_id,$bahan_baku,$biaya_dikeluarkan,$harga_modal,$harga_jual_konsumen,$konsumen)) {
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
	
	public function prosestransaksikonsumen()
	{
		if ($this->input->is_ajax_request()) {

			$konsumen = $this->input->post('konsumen');
			
			$jtransaksi = $this->input->post('jtransaksi');
			$tenors = $this->input->post('tenor');
			$catatan = $this->input->post('catatan');
			$totalbiaya = $this->input->post('totalbiaya');
			$totalbiayalog = "Rp. " . number_format($totalbiaya, 0, "", ",");
			$totaljumlah = $this->input->post('totaljumlah');
			
			$id_users = $this->session->userdata('id');
			
			// GET NEW ID
			$get_new_id = $this->transaksi_model->get_new_kode_add_transaksi();
	        foreach($get_new_id as $result){
	            $kode_New_id =  $result->maxKode;
	        }
	        $noUrut = (int) substr($kode_New_id, 4, 12);
	        $noUrut++;
	        $char = "STR-";
	        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
			// GET NEW ID
			
			if ($jtransaksi == 1) {
				$dapatkan_hutang = 0;
				$ketjtransaksi = 'Cash';
				$jumlah_cicilan = 0;
				$jumlah_tenor = 0;
				$nama_cicilan = '-';
				$jumlah_dibayar = $this->input->post('totalbiaya');

				// ADD CASH
				$ket_cash = 'Pembayaran Cash';
				$this->transaksi_model->add_cash($NewID,$ket_cash,$jumlah_dibayar);
				// ADD CASH
			} else if($jtransaksi == 2) {
				$datas = $this->transaksi_model->get_jcicilan($tenors);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $nama_cicilan = $bx['nama_cicilan'];
			    $tenor = $bx['tenor'];
			    $jumlah_tenor = $bx['jumlah_tenor'];
			    $jumlah_cicilan = $totalbiaya/$jumlah_tenor;

				$dapatkan_hutang = $this->input->post('totalbiaya');
				$ketjtransaksi = 'Cicil';
				$jumlah_dibayar = 0;
				
			
			
				$this->transaksi_model->add_cicilan($NewID,$konsumen,$nama_cicilan,$tenor,$jumlah_tenor,$jumlah_cicilan,$id_users);
			} else {
				$dapatkan_hutang = 0;
				$ketjtransaksi = 'Cash';
				$jumlah_cicilan = 0;
				$jumlah_tenor = 0;
				$nama_cicilan = '-';
				$jumlah_dibayar = $this->input->post('totalbiaya');
				// ADD CASH
				$ket_cash = 'Pembayaran Cash';
				$this->transaksi_model->add_cash($NewID,$ket_cash,$jumlah_dibayar);
				// ADD CASH
			}

		    	if ($this->transaksi_model->plus_entry_transaksi($NewID,$totaljumlah,$catatan,$id_users,$totalbiaya,$konsumen,$jumlah_dibayar,$nama_cicilan,$jumlah_cicilan,$ketjtransaksi,$dapatkan_hutang,$jumlah_tenor)) {
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					$datak = $this->transaksi_model->get_konsumen_nama($konsumen);
					error_reporting(0);
				    $nk = $datak->row_array();
				    $nama = $nk['nama'];
					$b = '<b>'.$nama_users.'</b> Nota:('.$NewID.') Melakukan Transaksi '.$ketjtransaksi.' dengan Konsumen '.$nama.' <b> sebesar '.$totalbiayalog.'</b>';
					$data2 = array(
						'ket' => $b,
					);
					$this->transaksi_model->insert_log_stock($data2);
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