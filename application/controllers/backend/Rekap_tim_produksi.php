<?php
class Rekap_tim_produksi extends CI_Controller{
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
		$this->load->model('backend/Rekap_produksi_barang_model','rekap_produksi_barang_model');
		$this->load->model('backend/Produksi_barang_model','produksi_barang_model');
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
		$x['title'] = 'Rekap Tim Produksi';
		$x['produksi'] = $this->rekap_produksi_barang_model->get_all_produksi();
		$x['karyawan'] = $this->rekap_produksi_barang_model->get_all_karyawan();
		$total = $this->rekap_produksi_barang_model->count_all_biaya();
		foreach($total as $result){
            $x['all'] = $result->biaya.' Kotak/ Pcs';
        }
        $this->load->view('backend/menu',$x);

		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_rekap_tim_produksi',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->rekap_produksi_barang_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $d->kode_produksi_selesai;
			$row[] = $d->nama_stock;
			
			
			date_default_timezone_set('Asia/Jakarta');
			$row[] = format_indo(date($d->produksi_selesai_tgl));
			$row[] = $d->user_name;
			$row[] = number_format($d->produksi_selesai_jumlah, 0, "", ",");
			// .' '.$d->nama_satuan
			

			if($this->session->userdata('level')==1) {
			
				$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
			<a class="dropdown-item delete_record detail_produksi" href="javascript:void()" data-id="'.$d->kode_produksi_selesai.'"><i class="bi bi-eye"></i> Detail</a>
			<a class="dropdown-item delete_record edit_rekap" href="javascript:void()" data-id="'.$d->kode_produksi_selesai.'"><i class="bi bi-pen-fill"></i> Edit</a>
			<a class="dropdown-item delete_record stock_rusak" href="javascript:void()" data-id="'.$d->kode_produksi_selesai.'"><i class="bi bi-gear"></i> Tambah Material Rusak</a>
			<a class="dropdown-item d-nota" href="javascript:void()" data-id="'.$d->produksi_selesai_id.'"><i class="bi bi-download"></i> Downlaod PDF</a>
				  </div></div></div>';
			} else {
				$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
			<a class="dropdown-item delete_record detail_produksi" href="javascript:void()" data-id="'.$d->kode_produksi_selesai.'"><i class="bi bi-eye"></i> Detail</a>

			<a class="dropdown-item delete_record stock_rusak" href="javascript:void()" data-id="'.$d->kode_produksi_selesai.'"><i class="bi bi-pen-fill"></i> Tambah Material Rusak</a>
			<a class="dropdown-item d-nota" href="javascript:void()" data-id="'.$d->produksi_selesai_id.'"><i class="bi bi-download"></i> Downlaod PDF</a>
				  </div></div></div>';
			}
			 

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_produksi_barang_model->count_all(),
						"recordsFiltered" => $this->rekap_produksi_barang_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($produksi_selesai_id)
	{
		$data = $this->rekap_produksi_barang_model->get_by_id($produksi_selesai_id);
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

		$detailstok = $this->rekap_produksi_barang_model->get_detail_tambah_stok($produksi_selesai_id);
		error_reporting(0);
	    $c = $detailstok->row_array();
	    $kode_produksi_selesai = $c['kode_produksi_selesai'];
	    $add_stock_jumlah = $c['produksi_selesai_jumlah'];
	    $nama_satuan = $c['nama_satuan'];
	    $nama_stock = $c['nama_stock'];
	    $add_stock_selesai_biaya = "Rp. " . number_format($c['produksi_selesai_biaya'], 0, "", ",");
	    $add_stock_catatan = $c['produksi_selesai_catatan'];
	    $add_stock_selesai_tgl = format_indo(date($c['produksi_selesai_tgl']));
	    $add_stock_selesai_user_id = $c['produksi_selesai_user_id'];

		$count_brusak = $this->rekap_produksi_barang_model->count_brusak($kode_produksi_selesai);
		$rowcount = $count_brusak->row_array();
		$brusak = $rowcount['brusak'];

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
        $pdf->Cell(190,7,$kode_produksi_selesai,0,1,'C');
        $pdf->SetFont('times','',12);
        $pdf->Cell(190,7,'Nama Produk : '.$nama_stock,0,1,'');
        $pdf->SetFont('times','',12);
        $pdf->Cell(190,7,'Total Produksi : '.$add_stock_jumlah.' '.$nama_satuan,0,1,'');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('times','B',12);
        $pdf->Cell(10,6,'No',1,0);
        $pdf->Cell(90,6,'Nama Material',1,0);
        $pdf->Cell(30,6,'Jumlah',1,0);
        $pdf->Cell(60,6,'Biaya',1,1);
        $pdf->SetFont('times','',12);
        $no=0;
        $krs_pdf = $this->rekap_produksi_barang_model->get_tambah_stock($kode_produksi_selesai);
        foreach ($krs_pdf as $row){
        	$penanggung_jawab = $row->user_name;

        	$no++;
            $pdf->Cell(10,6,$no,1,0);
            $pdf->Cell(90,6,$row->nama_stock,1,0);
            $pdf->Cell(30,6,number_format($row->jumlah, 0, "", ",").' '.$row->nama_satuan,1,0);

            $pdf->Cell(60,6,"Rp. " . number_format($row->biaya_dikeluarkan, 0, "", ","),1,1); 
        }
        $total_kerugian = 0;
        $pdf->SetFont('times','B',12);
        $pdf->Cell(10,6,' ',1,0);
        $pdf->Cell(90,6,'Grand Total: ',1,0);
        $pdf->Cell(30,6,' ',1,0);
        $pdf->Cell(60,6,$add_stock_selesai_biaya,1,1);
        $pdf->Cell(10,7,'',0,1);
        //////////////////////////////////////////////////////////////////////////////////////
        if ($brusak < 1) {

        } else {
	        $pdf->writeHTML("<hr>", true, false, false, false, '');
	        $pdf->SetFont('times','B',12);
	        $pdf->Cell(10,6,'No',1,0);
	        $pdf->Cell(90,6,'Material Rusak',1,0);
	        $pdf->Cell(30,6,'Jumlah',1,0);
	        $pdf->Cell(60,6,'Kerugian',1,1);
	        $pdf->SetFont('times','',12);
        
        
        	$no2=0;
        	$bahan_rusak = $this->rekap_produksi_barang_model->get_bahan_rusak($kode_produksi_selesai);
	        foreach ($bahan_rusak as $row2){
	        	$totalkerugian += $row2->biaya_dikeluarkan_rusak;
	        	$total_kerugian += $row2->jumlah_rusak;
	        	$totalkerugian_show = "Rp. " . number_format($totalkerugian, 0, "", ",");
	        	$no2++;
	            $pdf->Cell(10,6,$no2,1,0);
	            $pdf->Cell(90,6,$row2->nama_stock,1,0);
	            $pdf->Cell(30,6,number_format($row2->jumlah_rusak, 0, "", ",").' '.$row2->nama_satuan,1,0);

	            $pdf->Cell(60,6,"Rp. " . number_format($row2->biaya_dikeluarkan_rusak, 0, "", ","),1,1); 
	        }
	        $pdf->SetFont('times','B',12);
	        $pdf->Cell(10,6,' ',1,0);
	        $pdf->Cell(90,6,' ',1,0);
	        $pdf->Cell(30,6,'Jumlah : '.$total_kerugian,1,0);
	        $pdf->Cell(60,6,'Total Kerugian: '.$totalkerugian_show,1,1);
	        $pdf->Cell(10,7,'',0,1);
        }
        
        
        //////////////////////////////////////////////////////////////////////////////////////
        $pdf->SetFont('times','',12);
        $pdf->Cell(190,7,'Catatan* :'.$add_stock_catatan,0,1,'');
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('times','B',12);
        $pdf->Cell(120,7,$site_title,0,0,'');
        
        $pdf->Cell(120,7,'Medan, '.$add_stock_selesai_tgl,0,0,'');
        
        $pdf->Cell(10,7,' ',0,1,'');
        $pdf->Cell(10,7,'',0,1);
        $pdf->Cell(10,7,'',0,1);
        $pdf->Cell(120,7,$penanggung_jawab,0,0,'');
        
       

        $pdf->Output('BuktiProduksi-'.$kode_produksi_selesai.'.pdf', 'D');
        // PDF Template
	}


	function edit(){
		$id = $this->uri->segment(4);
		$get_kode=$this->rekap_produksi_barang_model->get_kode_rekap($id);
		if($get_kode->num_rows() > 0){
			
			if($this->session->userdata('level') != 1){
				$url=base_url('login_user');
	            redirect($url);
			}
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Edit Produksi Barang Untuk Pengantaran';
			$data['bbaku'] = $this->produksi_barang_model->get_all_bbaku();
			
			$data['id'] = $id;

				$datas = $this->rekap_produksi_barang_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $id_stock = $bx['produksi_selesai_jenis'];
			    $data['catatan'] = $bx['produksi_selesai_catatan'];
			    $data['jumlah'] = $bx['produksi_selesai_jumlah'];
			    $data['jenis'] = $bx['produksi_selesai_jenis'];
			$data['produksi'] = $this->produksi_barang_model->get_all_produksi_edit($id_stock);

			$this->load->view('backend/menu',$data);
			$this->load->view('backend/modal/edit_produksi_stock_modal');
			$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_edit_produksi_stock',$data);
		} else {
			redirect('backend/rekap_tim_produksi');
		}
	}

	public function get_ajax_list_edit()
	{
		$id = $this->input->post('id');
		$list = $this->rekap_produksi_barang_model->get_datatables_edit($id);
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
						"recordsTotal" => $this->rekap_produksi_barang_model->count_all_edit($id),
						"recordsFiltered" => $this->rekap_produksi_barang_model->count_filtered_edit($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function add(){
		$bahan_baku = $this->input->post('bahan_baku');
		$kode_produksi = $this->input->post('kode_produksi');
		$this->_validate();
		
		
		
				$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $kategori_stock = $bx['kategori_stock'];
			    $nilai_saham = $bx['nilai_saham'];
			    $id_stock = $bx['id_stock'];
			    
				$jumlah_biasa = $this->input->post('jumlah');
					
					$hasil_pengurangan_stock = $stock - $jumlah_biasa;	
					$hasil_pengurangan_saham = $harga_beli*$jumlah_biasa;

				$nilai_saham_update = $nilai_saham-$hasil_pengurangan_saham;
				$ajax_data_stocks['stock'] = $hasil_pengurangan_stock;
				$ajax_data_stocks['nilai_saham'] = $nilai_saham_update;
				date_default_timezone_set('Asia/Jakarta');
				$ajax_data_stocks['tgl_ubah'] = date("Y-m-d H:i:a");
				$id_user = $this->session->userdata('id');
				if ($this->rekap_produksi_barang_model->update_entry_stocks($bahan_baku, $ajax_data_stocks)) {
					$data2 = array(
						'kode_produksi' => $kode_produksi,
						'bahan_baku_id' => $this->input->post('bahan_baku'),
						'jumlah' => $this->input->post('jumlah'),
						
						'biaya_dikeluarkan' => $hasil_pengurangan_saham,
						'check_proses' => 1,
						'produksi_stock_user_id' => $id_user,
					);
					$insert = $this->rekap_produksi_barang_model->insert_stock($data2);
					
					if($insert){
						
						echo json_encode(array("status" => TRUE));
					}else{
						echo json_encode(array("status" => FALSE));
					}
				} else {
					echo json_encode(array("status" => FALSE));
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
		$kode_produksi = $this->input->post('kode_produksi');
		$cek_bahan_baku = $this->rekap_produksi_barang_model->validasi_bahan($bahan_baku,$kode_produksi);
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

	public function delete()
	{
		if ($this->input->is_ajax_request()) {

			$produksi_id = $this->input->post('id');
			$post = $this->rekap_produksi_barang_model->single_entry($produksi_id);
			$jmlh = $post->jumlah;
			$bahan_baku = $post->bahan_baku_id;
			$nilai_saham = $post->biaya_dikeluarkan;
			$id_nota = $post->kode_produksi;
			
			$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
			    $kategori_stock = $bx['kategori_stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
			    $id_stock = $bx['id_stock'];
			    
					$hasil_penambahan_stock = $stock+$jmlh;	
					$hasil_penambahan_saham = $harga_beli*$jmlh;

				
					if ($this->rekap_produksi_barang_model->delete_entry($produksi_id,$hasil_penambahan_stock,$hasil_penambahan_saham,$bahan_baku)) {
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
			$id_nota = $post->kode_produksi;
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
					} else if ($this->rekap_produksi_barang_model->minus_entry($produksi_id,$bahan_baku,$biaya_dikeluarkan,$harga_beli,$hasil_penambahan_stock,$hasil_penambahan_saham)) {
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
			    $kategori_stock = $bx['kategori_stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
			    $id_stock = $bx['id_stock'];
			   
				$jumlah_biasa = 1;

					$hasil_penambahan_stock = $stock-$jumlah_biasa;	
					$hasil_penambahan_saham = $harga_beli;

				
		    	if ($stock < $jumlah_biasa) {
		    		$data = array('res' => "error", 'message' => "Change query error");
		    	} else if ($this->rekap_produksi_barang_model->plus_entry($produksi_id,$bahan_baku,$stokkekurangan,$biaya_dikeluarkan,$harga_beli,$hasil_penambahan_stock,$hasil_penambahan_saham)) {
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
			$id_nota = $this->input->post('id_nota');
			$bahan_baku = $this->input->post('nama_produksi');
			$jumlah_produksi = $this->input->post('jumlah_produksi');
			$catatan_produksi = $this->input->post('catatan_produksi');
			$totalbiaya = $this->input->post('totalbiaya');
			$id_users = $this->session->userdata('id');

			$post = $this->rekap_produksi_barang_model->single_entry_rekap_stock($id_nota);
			$produksi_selesai_jumlah = $post->produksi_selesai_jumlah;
			$produksi_selesai_biaya = $post->produksi_selesai_biaya;
			


			$datas = $this->rekap_produksi_barang_model->get_stocks_produksi($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $stock = $bx['stock'];
		    $nilai_saham = $bx['nilai_saham'];


		    $stock_jumlah_produksi = $jumlah_produksi-$produksi_selesai_jumlah+$stock;
		    $hargabeli_total_bayar = $totalbiaya-$produksi_selesai_biaya+$nilai_saham;
		    $nilai_saham_totalbiaya = $totalbiaya-$produksi_selesai_biaya+$nilai_saham;

			$ajax_data_stocks['produksi_selesai_jenis'] = $bahan_baku;
			$ajax_data_stocks['produksi_selesai_jumlah'] = $jumlah_produksi;
			$ajax_data_stocks['produksi_selesai_biaya'] = $totalbiaya;
			$ajax_data_stocks['produksi_selesai_catatan'] = $catatan_produksi;
			$ajax_data_stocks['produksi_selesai_tgl'] = date("Y-m-d h:i:a");
			
			$this->rekap_produksi_barang_model->plus_entry_produksi2($bahan_baku,$stock_jumlah_produksi,$hargabeli_total_bayar,$nilai_saham_totalbiaya);
				if ($this->rekap_produksi_barang_model->plus_entry_produksi($id_nota, $ajax_data_stocks)) {
			

			
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					$b = '<b>'.$nama_users.'</b> Melakukan Perubahan Nota '.$id_nota.' Produksi Barang <b> sebanyak '.$jumlah_produksi.' Pcs</b>';
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
	
	public function prosespembatalannota()
	{
		if ($this->input->is_ajax_request()) {
			$kode_produksi_selesai = $this->input->post('id_nota');
			$pembatalan = $this->input->post('pembatalan');

			$id_users = $this->session->userdata('id');
			$post = $this->rekap_produksi_barang_model->single_entry_produksi_selesai($kode_produksi_selesai);
			$bahan_baku = $post->produksi_selesai_jenis;
			$produksi_selesai_biaya = $post->produksi_selesai_biaya;
			$produksi_selesai_jumlah = $post->produksi_selesai_jumlah;
			
			$datas = $this->rekap_produksi_barang_model->get_stocks_produksi($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $stock = $bx['stock'];
		    $nama_stock = $bx['nama_stock'];
		    $nilai_saham = $bx['nilai_saham'];

		    $hasil_pembatalan_stock = $stock-$produksi_selesai_jumlah;
		    $hasil_pembatalan_saham = $nilai_saham-$produksi_selesai_biaya;

			$ajax_data_stocks['stock'] = $hasil_pembatalan_stock;
			$ajax_data_stocks['nilai_saham'] = $hasil_pembatalan_saham;
			$ajax_data_stocks['harga_beli'] = $hasil_pembatalan_saham;
			$ajax_data_stocks['tgl_ubah'] = date("Y-m-d h:i:a");
			$ajax_data_stocks['user_id_stock'] = $id_users;
			$this->rekap_produksi_barang_model->update_stock_produksi($bahan_baku, $ajax_data_stocks);
			
				if ($this->rekap_produksi_barang_model->pembatalan_nota($kode_produksi_selesai)) {
		    	
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Melakukan Pembatalan Produksi Barang '.$nama_stock.' Sebanyak '.$produksi_selesai_jumlah;
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


	// RUSAK
	function stock_rusak_produksi(){
		$id = $this->uri->segment(4);
		$get_kode=$this->rekap_produksi_barang_model->get_kode_rekap($id);
		if($get_kode->num_rows() > 0){
		
			if($this->session->userdata('access') != "2" && $this->session->userdata('access') != "1"){
				$url=base_url('login_user');
	            redirect($url);
			}
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Tambah Material Rusak Produksi';
			$data['bbaku'] = $this->produksi_barang_model->get_all_bbaku();
			
			$data['id'] = $id;

				$datas = $this->rekap_produksi_barang_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $id_stock = $bx['produksi_selesai_jenis'];
			    $data['catatan'] = $bx['produksi_selesai_catatan'];
			   
			    $data['jenis'] = $bx['produksi_selesai_jenis'];
			$data['produksi'] = $this->produksi_barang_model->get_all_produksi_edit($id_stock);
			$this->load->view('backend/menu',$data);
			$this->load->view('backend/modal/tambah_stock_rusak_modal');
			$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_tambah_stock_rusak_produksi',$data);
		} else {
			redirect('backend/rekap_tim_produksi');
		}
	}
	public function get_ajax_list_rusak()
	{
	
		$id = $this->input->post('id');
		$list = $this->rekap_produksi_barang_model->get_datatables_rusak($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		

			$row[] = $no;
			$row[] = $d->nama_stock;
			

			
			$row[] = number_format($d->jumlah_rusak, 0, "", ",").' '.$d->nama_satuan.'<b>';
			$row[] = "Rp. " . number_format($d->biaya_dikeluarkan_rusak, 0, "", ",");
			$row[] = '<a class="btn icon btn-danger" href="javascript:void()" title="Minus" id="minus" value="'.$d->produksi_id_rusak.'"><i class="bi bi-file-minus"></i></a>&nbsp;&nbsp;<a class="btn icon btn-success" href="javascript:void()" title="Plus" id="plus" value="'.$d->produksi_id_rusak.'"><i class="bi bi-file-plus"></i></a>
						&nbsp;&nbsp;&nbsp;<a class="btn icon btn-primary btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->produksi_id_rusak.'"><i class="bi bi-trash"></i> Hapus</a>';
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_produksi_barang_model->count_all_rusak($id),
						"recordsFiltered" => $this->rekap_produksi_barang_model->count_filtered_rusak($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function addrusak(){
		$bahan_baku = $this->input->post('bahan_baku');
		$kode_produksi = $this->input->post('kode_produksi');
		$this->_validate_rusak();
		
		
		
				$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $nama_stock = $bx['nama_stock'];
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
				$jumlah_biasa = $this->input->post('jumlah');
				$hasil_pengurangan_saham = $harga_beli*$jumlah_biasa;
				$hasil_pengurangan_stock = $stock - $jumlah_biasa;	
				

				
				$nilai_saham_update = $nilai_saham-$hasil_pengurangan_saham;
				$ajax_data_stocks['stock'] = $hasil_pengurangan_stock;
				$ajax_data_stocks['nilai_saham'] = $nilai_saham_update;
				date_default_timezone_set('Asia/Jakarta');
				$ajax_data_stocks['tgl_ubah'] = date("Y-m-d H:i:a");
				$id_user = $this->session->userdata('id');
				if ($this->rekap_produksi_barang_model->update_entry_stocks($bahan_baku, $ajax_data_stocks)) {
					$data2 = array(
						'kode_produksi_rusak' => $kode_produksi,
						'bahan_baku_id_rusak' => $this->input->post('bahan_baku'),
						'jumlah_rusak' => $this->input->post('jumlah'),
						'biaya_dikeluarkan_rusak' => $hasil_pengurangan_saham,
						'check_proses_rusak' => 1,
						'produksi_stock_user_id_rusak' => $id_user,
					);
					$insert = $this->rekap_produksi_barang_model->insert_bahan_baku_rusak($data2);
					
					if($insert){
						// INSERT LOG
						$nama_users = $this->session->userdata('name');
						
						$b = '<b>'.$nama_users.'</b> Melakukan Penambahan Material Rusak '.$nama_stock.' dengan Kode Produksi '.$kode_produksi.' Sebanyak '.$jumlah_biasa;
						$data2 = array(
							'ket' => $b,
						);
						$this->produksi_barang_model->insert_log_stock($data2);
						// INSERT LOG
						
						echo json_encode(array("status" => TRUE));
					}else{
						echo json_encode(array("status" => FALSE));
					}
				} else {
					echo json_encode(array("status" => FALSE));
				}
			
		
	}

	private function _validate_rusak()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$bahan_baku = $this->input->post('bahan_baku',TRUE);
		$jumlah2 = $this->input->post('jumlah',TRUE);
		$kode_produksi = $this->input->post('kode_produksi');
		$cek_bahan_baku = $this->rekap_produksi_barang_model->validasi_bahan_rusak($bahan_baku,$kode_produksi);
	    if($cek_bahan_baku->num_rows() > 0){
	    	$row = $cek_bahan_baku->row();
			$data['inputerror'][] = 'bahan_baku_alert';
			$data['error_string'][] = 'Duplikat Bahan Baku';
			$data['status'] = FALSE;
	    }
	    $datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $stock = $bx['stock'];
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

	public function minusrusak()
	{
		if ($this->input->is_ajax_request()) {

			$produksi_id = $this->input->post('id');
			$post = $this->rekap_produksi_barang_model->single_entry_rusak($produksi_id);
			$bahan_baku = $post->bahan_baku_id_rusak;
			$jumlah_bahan = $post->jumlah_rusak;
			$biaya_dikeluarkan = $post->biaya_dikeluarkan_rusak;
			$kode_produksi = $post->kode_produksi_rusak;

			$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $nama_stock = $bx['nama_stock'];
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
				$jumlah_biasa = 1;
				$hasil_penambahan_saham = $harga_beli*$jumlah_biasa;
				$hasil_penambahan_stock = $stock + $jumlah_biasa;	
		    
				if ($jumlah_bahan < 2) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->rekap_produksi_barang_model->minus_entry_rusak($produksi_id,$bahan_baku,$hasil_penambahan_stock,$hasil_penambahan_saham)) {
						// INSERT LOG
						$nama_users = $this->session->userdata('name');
						$b = '<b>'.$nama_users.'</b> Melakukan Pengurangan Material Rusak '.$nama_stock.' dengan Kode Produksi '.$kode_produksi.' Sebanyak '.$jumlah_biasa;
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

	public function plusrusak()
	{
		if ($this->input->is_ajax_request()) {

			$produksi_id = $this->input->post('id');
			$post = $this->rekap_produksi_barang_model->single_entry_rusak($produksi_id);
			$bahan_baku = $post->bahan_baku_id_rusak;
			$jumlah_bahan = $post->jumlah_rusak;
			$biaya_dikeluarkan = $post->biaya_dikeluarkan_rusak;
			$kode_produksi = $post->kode_produksi_rusak;

			$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $nama_stock = $bx['nama_stock'];
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
				$jumlah_biasa = 1;
				$hasil_pengurangan_saham = $harga_beli*$jumlah_biasa;
				$hasil_pengurangan_stock = $stock - $jumlah_biasa;	
		    	if ($stock < $jumlah_biasa) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->rekap_produksi_barang_model->plus_entry_rusak($produksi_id,$bahan_baku,$hasil_pengurangan_stock,$hasil_pengurangan_saham)) {
						// INSERT LOG
						$nama_users = $this->session->userdata('name');
						$b = '<b>'.$nama_users.'</b> Melakukan Penambahan Material Rusak '.$nama_stock.' dengan Kode Produksi '.$kode_produksi.' Sebanyak '.$jumlah_biasa;

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
	public function deleterusak()
	{
		if ($this->input->is_ajax_request()) {

			$produksi_id = $this->input->post('id');
			$post = $this->rekap_produksi_barang_model->single_entry_rusak($produksi_id);
			$bahan_baku = $post->bahan_baku_id_rusak;
			$jumlah_bahan = $post->jumlah_rusak;
			$biaya_dikeluarkan = $post->biaya_dikeluarkan_rusak;

			$datas = $this->produksi_barang_model->get_stocks($bahan_baku);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $nama_stock = $bx['nama_stock'];
			    $stock = $bx['stock'];
			    $harga_beli = $bx['harga_beli'];
			    $nilai_saham = $bx['nilai_saham'];
				$hasil_penambahan_saham = $harga_beli*$jumlah_bahan;
				$hasil_penambahan_stock = $stock + $jumlah_bahan;	
		    
				if ($this->rekap_produksi_barang_model->delete_rusak($produksi_id,$bahan_baku,$hasil_penambahan_stock,$hasil_penambahan_saham)) {
						// INSERT LOG
						$nama_users = $this->session->userdata('name');
						
						$b = '<b>'.$nama_users.'</b> Menghapus Penambahan Material Rusak '.$nama_stock.' Sebanyak '.$jumlah_bahan;
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

	// DETAIL
	function detail(){
		$id = $this->uri->segment(4);
		$get_kode=$this->rekap_produksi_barang_model->get_kode_rekap($id);
		if($get_kode->num_rows() > 0){
		
			
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Detail Produksi';
			$data['bbaku'] = $this->produksi_barang_model->get_all_bbaku();
			
			$data['id'] = $id;

				$datas = $this->rekap_produksi_barang_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $id_stock = $bx['produksi_selesai_jenis'];
			    $data['catatan'] = $bx['produksi_selesai_catatan'];
			    $data['jumlah'] = $bx['produksi_selesai_jumlah'];
			    $data['satuan'] = $bx['nama_satuan'];
			    $data['jenis'] = $bx['nama_stock'];

			    $ctgl = $bx['produksi_selesai_tgl'];
			    $data['tgl_produksi'] = format_indo(date($ctgl));
			    $data['user_name'] = $bx['user_name'];
			    $data['datarusak'] = $this->rekap_produksi_barang_model->get_detail_rusak($id);
			$data['produksi'] = $this->produksi_barang_model->get_all_produksi_edit($id_stock);
			$this->load->view('backend/menu',$data);
			$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_detail_produksi',$data);
		} else {
			redirect('backend/rekap_produksi_barang');
		}
	}

	public function get_ajax_list_detail()
	{
		$id = $this->input->post('id');
		$list = $this->rekap_produksi_barang_model->get_datatables_detail($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		

			$row[] = $no;
			$row[] = $d->nama_stock;
			
			$row[] = number_format($d->jumlah, 0, "", ",").' '.$d->nama_satuan.'<b>';
			$row[] = "Rp. " . number_format($d->biaya_dikeluarkan, 0, "", ",");
			
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_produksi_barang_model->count_all_detail($id),
						"recordsFiltered" => $this->rekap_produksi_barang_model->count_filtered_detail($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
}