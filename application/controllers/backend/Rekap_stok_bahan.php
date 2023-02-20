<?php
class Rekap_stok_bahan extends CI_Controller{
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
		$this->load->model('backend/Rekap_tambah_stok_model','rekap_tambah_stok_model');
		$this->load->model('backend/Tambah_stock_bahan_model','tambah_stock_bahan_model');
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
		$x['title'] = 'Rekap Stok Bahan Masuk';
		
		$total = $this->rekap_tambah_stok_model->count_all_biaya();
		foreach($total as $result){
            $x['all'] = "Rp. " . number_format($result->biaya, 0, "", ",");
        }
        $this->load->view('backend/menu',$x);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_rekap_add_stock',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->rekap_tambah_stok_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $d->kode_add_stock_selesai;
			$row[] = $d->add_stock_jumlah.' Pcs';
			$row[] = format_indo(date($d->add_stock_selesai_tgl));
			$row[] = $d->user_name;
			$row[] = "Rp. " . number_format($d->add_stock_selesai_biaya, 0, "", ",");
			$row[] = $d->suplier;
			if($this->session->userdata('level')==1) {
			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
			<a class="dropdown-item delete_record edit_rekap" href="javascript:void()" data-id="'.$d->kode_add_stock_selesai.'"><i class="bi bi-pen-fill"></i> Edit</a>
			<a class="dropdown-item detail_tambah" href="javascript:void()" data-id="'.$d->kode_add_stock_selesai.'"><i class="bi bi-eye"></i> Detail</a>
			<a class="dropdown-item d-nota" href="javascript:void()" data-id="'.$d->produksi_selesai_id.'"><i class="bi bi-download"></i> Downlaod PDF</a>
				  </div></div></div>';
			} else {
				$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
				<a class="dropdown-item detail_tambah" href="javascript:void()" data-id="'.$d->kode_add_stock_selesai.'"><i class="bi bi-eye"></i> Detail</a>
				<a class="dropdown-item d-nota" href="javascript:void()" data-id="'.$d->produksi_selesai_id.'"><i class="bi bi-download"></i> Downlaod PDF</a>
				  </div></div></div>';
			}
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_tambah_stok_model->count_all(),
						"recordsFiltered" => $this->rekap_tambah_stok_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($produksi_selesai_id)
	{
		$data = $this->rekap_tambah_stok_model->get_by_id($produksi_selesai_id);
		echo json_encode($data);
	}

	public function nota_pdf() {
		// Mengambil KRS ID Array Mahasiswa
		$produksi_selesai_id = $this->uri->segment(4);
		$site = $this->site_model->get_site_data()->row_array();
        $images = $site['images'];
        $site_title = $site['site_title'];
        $notelp = $site['notelp'];
        $alamat_universitas = $site['alamat_universitas'];
        $email = $site['email'];


		$detailstok = $this->rekap_tambah_stok_model->get_detail_tambah_stok($produksi_selesai_id);
		error_reporting(0);
	    $c = $detailstok->row_array();
	    $kode_add_stock_selesai = $c['kode_add_stock_selesai'];
	    $add_stock_jumlah = $c['add_stock_jumlah'];

	    $add_stock_selesai_biaya = "Rp. " . number_format($c['add_stock_selesai_biaya'], 0, "", ",");
	    $add_stock_catatan = $c['add_stock_catatan'];
	    $suplier = $c['suplier'];

	    $add_stock_selesai_tgl = format_indo(date($c['add_stock_selesai_tgl']));
	    $add_stock_selesai_user_id = $c['add_stock_selesai_user_id'];


		
        
        // PDF Template            
        $this->load->library('Pdf');
		$pdf = new PDF('l','mm','A4');
		$pdf->setPrintHeader(false);
		// $pdf->setPrintFooter(false); < Jika ingin tanpa footer aktifkan ini
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->Image('assets/images/logo/'.$images, 10,10, 20, 20, '', '', 1, 0);
        $pdf->SetFont('times','B',16);
        $pdf->Cell(190,4,$site_title,0,1,'C');
        $pdf->SetFont('times','B',10);
        $pdf->MultiCell(45, 5, '', 0, 'C', 0, 0, '', '', true);
		$pdf->MultiCell(100, 5, $alamat_universitas."\n", 0, 'C', 0, 1, '' ,'', true);
        $pdf->Cell(190,4,$notelp.' '.$email,0,1,'C');
        $pdf->Cell(10,4,'',0,1);
        $pdf->writeHTML("<hr>", true, false, false, false, '');



        
        $pdf->SetFont('times','B',14);
        // mencetak string 
        $pdf->Cell(190,7,$kode_add_stock_selesai,0,1,'C');
        
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('times','B',12);
        $pdf->Cell(10,6,'No',1,0);
        $pdf->Cell(70,6,'Nama Bahan Baku',1,0);
        $pdf->Cell(40,6,'Jumlah',1,0);
        $pdf->Cell(70,6,'Biaya',1,1);
        $pdf->SetFont('times','',12);
        $no=0;
        $krs_pdf = $this->rekap_tambah_stok_model->get_tambah_stock($kode_add_stock_selesai);
        foreach ($krs_pdf as $row){
        	$penanggung_jawab = $row->user_name;
        	$no++;
            $pdf->Cell(10,6,$no,1,0);
            $pdf->Cell(70,6,$row->nama_stock,1,0);
            

            $pdf->Cell(40,6,number_format($row->jumlah_add_stock, 0, "", ",").' Pcs',1,0);
            $pdf->Cell(70,6,"Rp. " . number_format($row->biaya_dikeluarkan, 0, "", ","),1,1); 
        }
        $pdf->SetFont('times','B',12);
        $pdf->Cell(10,6,' ',1,0);
        $pdf->Cell(70,6,' ',1,0);
        $pdf->Cell(40,6,'Total :'.number_format($add_stock_jumlah, 0, "", ",").' Pcs',1,0);

        $pdf->Cell(70,6,'Grand Total: '.$add_stock_selesai_biaya,1,1);
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('times','',12);
        $pdf->Cell(190,7,'Catatan* :'.$add_stock_catatan,0,1,'');
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('times','B',12);
        $pdf->Cell(120,7,$site_title,0,0,'');
        $pdf->Cell(10,7,'Medan, '.$add_stock_selesai_tgl,0,1,'');
        $pdf->Cell(120,7,'Penanggung Jawab',0,0,'');
        $pdf->Cell(10,7,' ',0,1,'');
        $pdf->Cell(10,7,'',0,1);
        $pdf->Cell(10,7,'',0,1);
        $pdf->Cell(120,7,$penanggung_jawab,0,0,'');
        $pdf->Cell(10,7,$suplier,0,1,'');
       

        $pdf->Output('NOTA-'.$kode_add_stock_selesai.'.pdf', 'D');
        // PDF Template
	}
	// EDIT PAGE
	function edit(){
		$id = $this->uri->segment(4);
		$get_kode=$this->tambah_stock_bahan_model->get_kode_rekap($id);
		if($get_kode->num_rows() > 0){
		
			if($this->session->userdata('level') != 1){
				$url=base_url('login_user');
	            redirect($url);
			}
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Form Edit Nota Stock Bahan';
			$data['bbaku'] = $this->tambah_stock_bahan_model->get_all_bbaku();
			$data['produksi'] = $this->tambah_stock_bahan_model->get_all_produksi();
			$data['id'] = $id;
				$datas = $this->rekap_tambah_stok_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $data['catatan'] = $bx['add_stock_catatan'];
			$this->load->view('backend/menu',$data);
			$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_edit_stock_bahan',$data);
		} else {
			redirect('backend/rekap_stok_bahan');
		}
	}

	public function get_ajax_list_edit()
	{
		$id = $this->input->post('id');
		$list = $this->rekap_tambah_stok_model->get_datatables_edit($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		
			$row[] = $no;
			$row[] = $d->nama_stock;
			$row[] = $d->jumlah_add_stock;
			$row[] = "Rp. " . number_format($d->biaya_dikeluarkan, 0, "", ",");
			$row[] = '<a class="btn icon btn-danger" href="javascript:void()" title="Minus" id="minus" value="'.$d->add_stock_id.'"><i class="bi bi-file-minus"></i></a>&nbsp;&nbsp;<a class="btn icon btn-success" href="javascript:void()" title="Plus" id="plus" value="'.$d->add_stock_id.'"><i class="bi bi-file-plus"></i></a>
						&nbsp;&nbsp;&nbsp;<a class="btn icon btn-primary btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->add_stock_id.'"><i class="bi bi-trash"></i> Hapus</a>';
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_tambah_stok_model->count_all_detail($id),
						"recordsFiltered" => $this->rekap_tambah_stok_model->count_filtered_detail($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	function add(){
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$bahan_baku = $this->input->post('bahan_baku');
			$y = $this->input->post('jumlah');
		$cek_bahan_baku = $this->rekap_tambah_stok_model->validasi_bahan($bahan_baku,$id);
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
			

			$ajax_data_stocks['stock'] = $x;
			$ajax_data_stocks['nilai_saham'] = $xxxx;
			date_default_timezone_set('Asia/Jakarta');
			$ajax_data_stocks['tgl_ubah'] = date("Y-m-d H:i:a");
				if ($this->rekap_tambah_stok_model->update_entry_stocks_edit($bahan_baku, $ajax_data_stocks)) {
					$id_users = $this->session->userdata('id');
					$data2 = array(
						'kode_add_stock' => $id,
						'bahan_baku_id' => $this->input->post('bahan_baku'),
						'jumlah_add_stock' => $this->input->post('jumlah'),
						'check_proses' => 1,
						'biaya_dikeluarkan' => $zzz,
						'add_stock_stock_user_id' => $id_users,
					);
					$this->rekap_tambah_stok_model->insert_stock($data2);
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

	public function delete_stock()
	{
		if ($this->input->is_ajax_request()) {

			$add_stock_id = $this->input->post('id');
			$post = $this->tambah_stock_bahan_model->single_entry($add_stock_id);
			$jmlh = $post->jumlah_add_stock;
			$bahan_baku = $post->bahan_baku_id;
			$nilai_saham = $post->biaya_dikeluarkan;
			
			$datas = $this->tambah_stock_bahan_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $z = $bx['stock'];
			if ($z < $jmlh) {
				$data = array('res' => "errorstock", 'message' => "Delete query error");
			} else {
				if ($this->rekap_tambah_stok_model->delete_entry($add_stock_id,$jmlh,$nilai_saham,$bahan_baku)) {
					$data = array('res' => "success", 'message' => "Data berhasil dihapus");
				} else {
					$data = array('res' => "error", 'message' => "Delete query error");
				}
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
		    $z = $bx['stock'];
		    if ($z < 1) {
		    	$data = array('res' => "errorstock", 'message' => "Delete query error");
			} else {
				if ($jumlah_add_stock < 2) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->rekap_tambah_stok_model->minus_entry($add_stock_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli)) {
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
		    	if ($this->rekap_tambah_stok_model->plus_entry($add_stock_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli)) {
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
			$id = $this->input->post('id_nota');
			$catatan = $this->input->post('catatan');
			$totalbiaya = $this->input->post('totalbiaya');
			$totaljumlah = $this->input->post('totaljumlah');
			$totaljumlahshow = number_format($totaljumlah, 0, "", ",");
			$id_users = $this->session->userdata('id');
			
			$post = $this->rekap_tambah_stok_model->single_entry_selesai_add_stock($id);
			$add_stock_jumlah = $post->add_stock_jumlah;
			$add_stock_jumlahshow = number_format($add_stock_jumlah, 0, "", ",");
			
			$ajax_data_stocks['add_stock_jumlah'] = $totaljumlah;
			$ajax_data_stocks['add_stock_selesai_biaya'] = $totalbiaya;
			$ajax_data_stocks['add_stock_catatan'] = $catatan;
			$ajax_data_stocks['add_stock_selesai_tgl'] = date("Y-m-d h:i:a");
			
				if ($this->rekap_tambah_stok_model->plus_entry_produksi($id, $ajax_data_stocks)) {
		    	
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Melakukan Perubahan Nota Tambah Stok Material '.$id.' <b> dari '.$add_stock_jumlahshow.' Menjadi '.$totaljumlahshow.' Pcs</b>';
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

	public function prosespembatalannota()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id_nota');
			$pembatalan = $this->input->post('pembatalan');

			$id_users = $this->session->userdata('id');
			$post = $this->rekap_tambah_stok_model->single_entry_selesai_add_stock($id);
			$jmlh = $post->add_stock_jumlah;
			
			$datas = $this->rekap_tambah_stok_model->count_total_stock_bahan();
			error_reporting(0);
		    $bx = $datas->row_array();
		    $total_stocks = $bx['total_stocks'];
			//if ($total_stocks < $jmlh) {
			//	$data = array('res' => "errorstock", 'message' => "Change query error");
			//} else {
				if ($this->rekap_tambah_stok_model->pembatalan_nota($id)) {
		    	
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Melakukan Pembatalan Nota Tambah Stok Material '.$id;
					$data2 = array(
						'ket' => $b,
					);
					$this->tambah_stock_bahan_model->insert_log_stock($data2);
					// INSERT LOG
					$data = array('res' => "success", 'message' => "Data berhasil dirubah");
				} else {
					$data = array('res' => "error", 'message' => "Change query error");
				}
			//}
				
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	// EDIT PAGE


	// DETAIL
	function detail(){
		$id = $this->uri->segment(4);
		$get_kode=$this->tambah_stock_bahan_model->get_kode_rekap($id);
		if($get_kode->num_rows() > 0){
		
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Detail Tambah Stok Bahan';
			$data['bbaku'] = $this->tambah_stock_bahan_model->get_all_bbaku();
			$data['produksi'] = $this->tambah_stock_bahan_model->get_all_produksi();
			$data['id'] = $id;
				$datas = $this->rekap_tambah_stok_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $data['kode'] = $bx['kode_add_stock_selesai'];
			    $data['user_name'] = $bx['user_name'];
			    $data['catatan'] = $bx['add_stock_catatan'];
			    $data['suplier'] = $bx['suplier'];
			    $tgl = $bx['add_stock_selesai_tgl'];
			    $data['tgl_penambahan'] = format_indo(date($tgl));
			$this->load->view('backend/menu',$data);
			$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_detail_stock_bahan',$data);
		} else {
			redirect('backend/rekap_stok_bahan');
		}
	}

	public function get_ajax_list_detail()
	{
		$id = $this->input->post('id');
		$list = $this->rekap_tambah_stok_model->get_datatables_detail($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		
			$row[] = $no;
			$row[] = $d->nama_stock;
			$row[] = number_format($d->jumlah_add_stock, 0, "", ",");
			
			$row[] = "Rp. " . number_format($d->biaya_dikeluarkan, 0, "", ",");
			
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_tambah_stok_model->count_all_detail($id),
						"recordsFiltered" => $this->rekap_tambah_stok_model->count_filtered_detail($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
}