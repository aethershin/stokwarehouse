<?php
class Rekap_nota_transaksi_konsumen extends CI_Controller{
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
		$this->load->model('backend/Rekap_nota_transaksi_konsumen_model','rekap_nota_transaksi_konsumen_model');
		$this->load->model('backend/Transaksi_model','transaksi_model');
		$this->load->model('backend/Konsumen_model','konsumen_model');
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
		$x['title'] = 'Rekap Nota Transaksi Konsumen';
		$x['konsumen'] = $this->transaksi_model->get_all_konsumen();
		$total = $this->rekap_nota_transaksi_konsumen_model->count_all_biaya();
		foreach($total as $result){
            $x['all'] = "Rp. " . number_format($result->biaya, 0, "", ",");
        }
        $this->load->view('backend/menu',$x);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_rekap_nota_transaksi_konsumen',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->rekap_nota_transaksi_konsumen_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
			$jtrans = $d->jenis_transaksi;
			$row[] = $no;
			$row[] = $d->kode_transaksi;
			$row[] = $d->nama;
			$row[] = $d->jenis_transaksi;
			
			$row[] = format_indo(date($d->tgl_ubah));
			
			$row[] = "Rp. " . number_format($d->total_belanja, 0, "", ",");
			$row[] = "Rp. " . number_format($d->jumlah_dibayar, 0, "", ",");
		
				if ($jtrans == 'Cash') {
					$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
					<a class="dropdown-item detail" href="javascript:void()" data-id="'.$d->kode_transaksi.'"><i class="bi bi-eye"></i> Detail</a>
					<a class="dropdown-item d-nota-a5" href="javascript:void()" data-id="'.$d->id_transaksi.'"><i class="bi bi-download"></i> Nota A5</a>
					<a class="dropdown-item d-nota-a7" href="javascript:void()" data-id="'.$d->id_transaksi.'"><i class="bi bi-download"></i> Nota A7</a>
					  </div></div></div>';
				}  else if ($jtrans == 'Cicil') {
					$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
					<a class="dropdown-item detail" href="javascript:void()" data-id="'.$d->kode_transaksi.'"><i class="bi bi-eye"></i> Detail</a>
					<a class="dropdown-item bayar_cicilan" href="javascript:void()" data-id="'.$d->kode_transaksi.'"><i class="bi bi-currency-dollar"></i> Bayar Cicilan</a>
					<a class="dropdown-item d-nota-a5" href="javascript:void()" data-id="'.$d->id_transaksi.'"><i class="bi bi-download"></i> Nota A5</a>
					<a class="dropdown-item d-nota-a7" href="javascript:void()" data-id="'.$d->id_transaksi.'"><i class="bi bi-download"></i> Nota A7</a>
					  </div></div></div>';
				} else {
					$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
					<a class="dropdown-item detail" href="javascript:void()" data-id="'.$d->kode_transaksi.'"><i class="bi bi-eye"></i> Detail</a>
					<a class="dropdown-item d-nota-a5" href="javascript:void()" data-id="'.$d->id_transaksi.'"><i class="bi bi-download"></i> Nota A5</a>
					<a class="dropdown-item d-nota-a7" href="javascript:void()" data-id="'.$d->id_transaksi.'"><i class="bi bi-download"></i> Nota A7</a>
					  </div></div></div>';
				}
			
			
			

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_nota_transaksi_konsumen_model->count_all(),
						"recordsFiltered" => $this->rekap_nota_transaksi_konsumen_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id_transaksi)
	{
		$data = $this->rekap_nota_transaksi_konsumen_model->get_by_id($id_transaksi);
		echo json_encode($data);
	}

	public function nota_pdf_a7() {
		// Mengambil KRS ID Array Mahasiswa
		$id_transaksi = $this->uri->segment(4);
		$site = $this->site_model->get_site_data()->row_array();
        $images = $site['images'];
        $site_title = $site['site_title'];
        $notelp = $site['notelp'];
        $alamat_universitas = $site['alamat_universitas'];
        $email = $site['email'];


		$detailstok = $this->rekap_nota_transaksi_konsumen_model->get_detail_tambah_stok($id_transaksi);
		error_reporting(0);
	    $c = $detailstok->row_array();
	    $kode_add_stock_selesai = $c['kode_transaksi'];

	    $add_stock_selesai_biaya = "Rp. " . number_format($c['total_belanja'], 0, "", ",");
	    $add_stock_catatan = $c['catatan'];
	    $id_konsumen_transaksi = $c['id_konsumen_transaksi'];
	    $jenis_transaksi = $c['jenis_transaksi'];
	    $tenorbulan = $c['tenorbulan'];
	    $kasir = $c['user_name'];
	    $tenorcicil = "Rp. " . number_format($c['tenorcicil'], 0, "", ",");

	    $total_hutang = "Rp. " . number_format($c['dapatkan_hutang'], 0, "", ",");
	    $jumlah_dibayar = "Rp. " . number_format($c['jumlah_dibayar'], 0, "", ",");
	    $add_stock_selesai_tgl = format_indo(date($c['tgl_transaksi']));
	    $add_stock_selesai_user_id = $c['id_user_transaksi'];

	    $detailkonsumen = $this->rekap_nota_transaksi_konsumen_model->get_detail_konsumen($id_konsumen_transaksi);
		error_reporting(0);
	    $d = $detailkonsumen->row_array();
	    $namakonsumen = $d['nama'];

	    $detailcicilan = $this->rekap_nota_transaksi_konsumen_model->get_detail_cicilan($kode_add_stock_selesai);
		error_reporting(0);
	    $d = $detailcicilan->row_array();
	    $jumlah_telah_dibayar = $d['jumlah_telah_dibayar'];
	    $tgl_update_bayar = $d['tgl_update_bayar'];
		$show_tgl_update_bayar = format_indo(date($tgl_update_bayar));
        
        // PDF Template            
        $this->load->library('Pdf');
        
		$pdf= new PDF(PDF_PAGE_ORIENTATION,PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
		$pdf->AddPage('P','A7');
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// $pdf->setPrintFooter(false); < Jika ingin tanpa footer aktifkan ini
		
		
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // membuat halaman baru
        
        
        $pdf->SetFont('times','B',12);
        $pdf->Cell(0,0,$site_title,0,1,'C');
        $pdf->SetFont('times','B',8);	
        $pdf->MultiCell(6, 5, '', 0, 'C', 0, 0, '', '', true);
		$pdf->MultiCell(42, 5, $alamat_universitas."\n", 0, 'C', 0, 1, '' ,'', true);
        $pdf->Cell(54,4,$notelp.' '.$email,0,1,'C');
        
        $pdf->writeHTML("<hr>", false, false, false, false, '');



        $pdf->SetFont('times','I',8);
        $pdf->Cell(0,1,'Medan, '.$add_stock_selesai_tgl,0,1,'R');
        
        $pdf->SetFont('times','B',10);
        // mencetak string 
        $pdf->Cell(0,0,$kode_add_stock_selesai,0,1,'C');
        $pdf->SetFont('times','',8);
        $pdf->Cell(0,2,'Konsumen : '.$namakonsumen,0,1,'');
        if ($jenis_transaksi == 'Cash') {
        	$pdf->Cell(0,2,'Jenis Transaksi : '.$jenis_transaksi,0,1,'');
        } else if ($jenis_transaksi == 'Cicil') {
        	$pdf->Cell(0,2,'Jenis Transaksi : '.$jenis_transaksi,0,1,'');
        	$pdf->Cell(0,2,'Sisa Hutang : '.$total_hutang,0,1,'');
        	
        } else {
        	$pdf->Cell(0,2,'Jenis Transaksi : '.$jenis_transaksi,0,1,'');
        	$pdf->Cell(0,2,'Sisa Hutang : '.$total_hutang,0,1,'');
        	$pdf->Cell(0,2,'Telah dilunasi : '.$show_tgl_update_bayar,0,1,'');
        }
        $pdf->Cell(0,2,'Ekspedisi : '.$kasir,0,1,'');
        
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(0,0,'',0,1);
        $pdf->SetFont('times','B',8);
        $pdf->Cell(23,2,'Nama',0,0);
        $pdf->Cell(13,2,'Jml',0,0);
        $pdf->Cell(20,2,'Total',0,1);
        $pdf->SetFont('times','',8);
        $krs_pdf = $this->rekap_nota_transaksi_konsumen_model->get_tambah_stock($kode_add_stock_selesai);
        foreach ($krs_pdf as $row){
        	$penanggung_jawab = $row->user_name;
            $pdf->Cell(23,2,$row->nama_stock,0,0);
            $pdf->Cell(13,2,$row->jumlah_transaksi.' '.$row->nama_satuan,0,0);
            $pdf->Cell(20,2,"Rp. " . number_format($row->harga_jual_transaksi, 0, "", ","),0,1); 
        }
        $pdf->SetFont('times','B',8);
        $pdf->Cell(23,2,'Total ',1,0);
        $pdf->Cell(13,2,'    :',1,0);
        $pdf->Cell(20,2,$add_stock_selesai_biaya,1,1);
        if ($jenis_transaksi == 'Cicil') {
        	$pdf->SetFont('times','B',8);
	        $pdf->Cell(23,3,'Cicilan',1,0);
	        $pdf->Cell(13,3,'    /',1,0);
	        $pdf->Cell(20,3,$tenorcicil,1,1);

	        $pdf->SetFont('times','B',8);
	        $pdf->Cell(23,4,'Cicilan ke',1,0);
	        $pdf->Cell(13,4,'    :',1,0);
	        $pdf->Cell(20,4,$jumlah_telah_dibayar,1,1);
	        	
	        
	        
        } else if ($jenis_transaksi == 'Cicilan Lunas') {
        	

        } else {

        }
        
        
        $pdf->SetFont('times','',8);
        $pdf->MultiCell(1, 7, '', 0, '', 0, 0, '', '', true);
		$pdf->MultiCell(50, 7, 'Catatan* :'.$add_stock_catatan."\n", 0, '', 0, 1, '' ,'', true);
       	$pdf->IncludeJS('print();');
        $pdf->Output('NOTA-TRANSAKSI-A7-'.$kode_add_stock_selesai.'.pdf', 'D');
        // PDF Template
	}

	public function nota_pdf_a5() {
		// Mengambil KRS ID Array Mahasiswa
		$id_transaksi = $this->uri->segment(4);
		$site = $this->site_model->get_site_data()->row_array();
        $images = $site['images'];
        $site_title = $site['site_title'];
        $notelp = $site['notelp'];
        $alamat_universitas = $site['alamat_universitas'];
        $email = $site['email'];


		$detailstok = $this->rekap_nota_transaksi_konsumen_model->get_detail_tambah_stok($id_transaksi);
		error_reporting(0);
	    $c = $detailstok->row_array();
	    $kode_add_stock_selesai = $c['kode_transaksi'];

	    $add_stock_selesai_biaya = "Rp. " . number_format($c['total_belanja'], 0, "", ",");
	    $add_stock_catatan = $c['catatan'];
	    $id_konsumen_transaksi = $c['id_konsumen_transaksi'];
	    $jenis_transaksi = $c['jenis_transaksi'];
	    $tenorbulan = $c['tenorbulan'];
	    $kasir = $c['user_name'];
	    
	    $tenorcicil = "Rp. " . number_format($c['tenorcicil'], 0, "", ",");

	    $total_hutang = "Rp. " . number_format($c['dapatkan_hutang'], 0, "", ",");
	    $jumlah_dibayar = "Rp. " . number_format($c['jumlah_dibayar'], 0, "", ",");
	    
	    $add_stock_selesai_tgl = format_indo(date($c['tgl_transaksi']));
	    $add_stock_selesai_user_id = $c['id_user_transaksi'];

	    $detailkonsumen = $this->rekap_nota_transaksi_konsumen_model->get_detail_konsumen($id_konsumen_transaksi);
		error_reporting(0);
	    $d = $detailkonsumen->row_array();
	    $namakonsumen = $d['nama'];

	    $detailcicilan = $this->rekap_nota_transaksi_konsumen_model->get_detail_cicilan($kode_add_stock_selesai);
		error_reporting(0);
	    $d = $detailcicilan->row_array();
	    $jumlah_telah_dibayar = $d['jumlah_telah_dibayar'];
	    $tgl_update_bayar = $d['tgl_update_bayar'];
		$show_tgl_update_bayar = format_indo(date($tgl_update_bayar));
        // PDF Template            
        $this->load->library('Pdf');
        
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		
		$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // membuat halaman baru
        $pdf->AddPage('L','A5');
        $pdf->Image('assets/images/logo/'.$images, 10,5, 20, 20, '', '', 1, 0);
        $pdf->SetFont('times','B',14);
        $pdf->Cell(0,0,$site_title,0,1,'C');
        $pdf->SetFont('times','B',12);	
        $pdf->MultiCell(13, 5, '', 0, 'C', 0, 0, '', '', true);
		$pdf->MultiCell(170, 5, $alamat_universitas."\n", 0, 'C', 0, 1, '' ,'', true);
        $pdf->Cell(190,4,$notelp.' '.$email,0,1,'C');
        
        $pdf->writeHTML("<hr>", false, false, false, false, '');



        $pdf->SetFont('times','I',10);
        $pdf->Cell(0,1,'Medan, '.$add_stock_selesai_tgl,0,1,'R');
        
        $pdf->SetFont('times','B',14);
        // mencetak string 
        $pdf->Cell(0,0,$kode_add_stock_selesai,0,1,'C');
        $pdf->Cell(0,0,'',0,1);
        $pdf->SetFont('times','B',12);
        $pdf->Cell(50,2,'Konsumen',0,0);
        $pdf->Cell(5,2,':',0,0);
        $pdf->Cell(80,2,$namakonsumen,0,1);
        if ($jenis_transaksi == 'Cash') {
        	$pdf->Cell(50,2,'Jenis Transaksi',0,0);
        	$pdf->Cell(5,2,':',0,0);
        	$pdf->Cell(80,2,$jenis_transaksi,0,1);
        } else if ($jenis_transaksi == 'Cicil') {
        	$pdf->Cell(50,2,'Jenis Transaksi',0,0);
        	$pdf->Cell(5,2,':',0,0);
        	$pdf->Cell(80,2,$jenis_transaksi,0,1);

        	$pdf->Cell(50,2,'Total Hutang',0,0);
        	$pdf->Cell(5,2,':',0,0);
        	$pdf->Cell(80,2,$total_hutang,0,1);
        } else {
        	$pdf->Cell(50,2,'Jenis Transaksi',0,0);
        	$pdf->Cell(5,2,':',0,0);
        	$pdf->Cell(80,2,$jenis_transaksi,0,1);

        	$pdf->Cell(50,2,'Total Hutang',0,0);
        	$pdf->Cell(5,2,':',0,0);
        	$pdf->Cell(80,2,$total_hutang,0,1);

        	$pdf->Cell(50,2,'Telah dilunasi',0,0);
        	$pdf->Cell(5,2,':',0,0);
        	$pdf->Cell(80,2,$show_tgl_update_bayar,0,1);
        }
        $pdf->Cell(50,2,'Ekspedisi',0,0);
        $pdf->Cell(5,2,':',0,0);
        $pdf->Cell(80,2,$kasir,0,1);
        
        
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(0,0,'',0,1);
        $pdf->SetFont('times','B',12);
       	
	    	$pdf->Cell(125,2,'Nama Produk',1,0);
	        $pdf->Cell(25,2,'Jumlah',1,0);
	        $pdf->Cell(40,2,'Total',1,1);
	        $pdf->SetFont('times','',12);
	        $krs_pdf = $this->rekap_nota_transaksi_konsumen_model->get_tambah_stock($kode_add_stock_selesai);
	        foreach ($krs_pdf as $row){
	        	$penanggung_jawab = $row->user_name;
	        	$nama_satuan = $row->nama_satuan;
	        	$sum_jum += $row->jumlah_transaksi;
	        	$jumlah_laku += $row->jumlah_laku;
	        	$hasil_jumlah_laku = number_format($jumlah_laku, 0, "", ",");
	            $pdf->Cell(125,2,$row->nama_stock,1,0);
	            $pdf->Cell(25,2,$row->jumlah_transaksi.' '.$row->nama_satuan,1,0);
	            $pdf->Cell(40,2,"Rp. " . number_format($row->harga_jual_transaksi, 0, "", ","),1,1); 
	        }
	        
	        $pdf->SetFont('times','B',12);
	        $pdf->Cell(125,2,'Total ',1,0);
	        $pdf->Cell(25,2,$sum_jum.' '.$nama_satuan,1,0);
	        $pdf->Cell(40,2,$add_stock_selesai_biaya,1,1);
	    
        if ($jenis_transaksi == 'Cicil') {
        	$pdf->SetFont('times','B',12);
	        $pdf->Cell(125,3,'Cicilan',1,0);
	        $pdf->Cell(25,3,'          /',1,0);
	        $pdf->Cell(40,3,$tenorcicil,1,1);

	        $pdf->SetFont('times','B',12);
	        $pdf->Cell(150,4,'Cicilan ke',1,0);
	        $pdf->Cell(40,4,$jumlah_telah_dibayar,1,1);
	        
	        
        }  else {

        }
        
        
        $pdf->SetFont('times','',12);
        $pdf->MultiCell(1, 7, '', 0, '', 0, 0, '', '', true);
		$pdf->MultiCell(190, 7, 'Catatan* :'.$add_stock_catatan."\n", 0, '', 0, 1, '' ,'', true);
       	// $pdf->IncludeJS('print();');
        $pdf->Output('NOTA-TRANSAKSI-A5-'.$kode_add_stock_selesai.'.pdf', 'D');
        // PDF Template
	}
	

	// BAYAR CICILAN
	function bayar_cicilan(){
		$id = $this->uri->segment(4);
		$get_kode=$this->rekap_nota_transaksi_konsumen_model->get_kode_rekap($id);
		if($get_kode->num_rows() > 0){
		
			
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Pembayaran Cicilan';
			
			
			$data['id'] = $id;

				$datas = $this->rekap_nota_transaksi_konsumen_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $data['catatan'] = $bx['catatan'];
			    $data['kode_transaksi'] = $bx['kode_transaksi'];
			    $data['nama'] = $bx['nama'];
			    
			$this->load->view('backend/menu',$data);
			$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_bayar_cicilan',$data);
		} else {
			redirect('backend/rekap_transaksi_barang');
		}
	}
	public function get_ajax_list_cicil()
	{
		$id = $this->input->post('id');
		$list = $this->rekap_nota_transaksi_konsumen_model->get_datatables_cicil($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$jumlahdibayar = $d->jumlah_telah_dibayar;
			$no++;
			$row = array();
		
			
			$row[] = $d->ket_cicilan;
			
			$row[] = "Rp. " . number_format($d->cicilan, 0, "", ",");
			$row[] = $d->jumlah_telah_dibayar;
			
			
			$row[] = "Rp. " . number_format($d->telah_dibayar, 0, "", ",");
			date_default_timezone_set("Asia/Jakarta");
			if ($jumlahdibayar == 0) {
				$row[] = '-';
			} else {
				$row[] = format_indo(date($d->tgl_update_bayar));
			}
			
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_nota_transaksi_konsumen_model->count_all_edit($id),
						"recordsFiltered" => $this->rekap_nota_transaksi_konsumen_model->count_filtered_edit($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function paid()
	{
		if ($this->input->is_ajax_request()) {

			$id_notas = $this->input->post('id_notas');
			$post = $this->rekap_nota_transaksi_konsumen_model->single_entry_cicilan($id_notas);
			$id_konsumen_cicil = $post->id_konsumen_cicil;
			$cicilan = $post->cicilan;
			$cicilanlog = "Rp. " . number_format($post->cicilan, 0, "", ",");
			$telah_dibayar = $post->telah_dibayar;
			$jumlah_telah_dibayar = $post->jumlah_telah_dibayar;
			$jumlah_cicilan = $post->jumlah_cicilan;
			//RUMUS
			$hasil_telah_bayar = $cicilan+$telah_dibayar;
			$hasil_jumlah = $jumlah_telah_dibayar+1;
			//RUMUS
				$data_konsumen = $this->rekap_nota_transaksi_konsumen_model->get_konsumen($id_konsumen_cicil);
				error_reporting(0);
			    $dk = $data_konsumen->row_array();
			    $nama = $dk['nama'];


				$data_list_transaksi = $this->rekap_nota_transaksi_konsumen_model->get_list_transaksi($id_notas);
				error_reporting(0);
			    $bx = $data_list_transaksi->row_array();
			    $dapatkan_hutang = $bx['dapatkan_hutang'];
			    $jenis_transaksi = $bx['jenis_transaksi'];
			//RUMUS   
			$rubah_list_dapatkan_hutang = $dapatkan_hutang-$cicilan;
			
			if ($hasil_jumlah >= $jumlah_cicilan) {
				$rubah_list_jenis_transaksi = 'Cicilan Lunas';	
			} else {
				$rubah_list_jenis_transaksi = 'Cicil';	
			}
		    //RUMUS
				if ($hasil_jumlah > $jumlah_cicilan) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->rekap_nota_transaksi_konsumen_model->paid_entry($id_notas,$id_konsumen_cicil,$cicilan,$hasil_telah_bayar,$hasil_jumlah,$rubah_list_dapatkan_hutang,$rubah_list_jenis_transaksi)) {

					// ADD CASH
					$NewID = $this->input->post('id_notas');
					$jumlah_dibayar = $cicilan;
					$id_cicil_cancel = $hasil_jumlah;
					$ket_cash = 'Pembayaran Cicilan';
					$this->rekap_nota_transaksi_konsumen_model->add_cash($NewID,$id_cicil_cancel,$ket_cash,$jumlah_dibayar);
					// ADD CASH

					// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Mengkonfirmasi Pembayaran Cicilan <b>'.$nama.' Sebanyak '.$cicilanlog.'</b>';
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

	public function cancelpaid()
	{
		if ($this->input->is_ajax_request()) {

			$id_notas = $this->input->post('id_notas');
			$post = $this->rekap_nota_transaksi_konsumen_model->single_entry_cicilan($id_notas);
			$id_konsumen_cicil = $post->id_konsumen_cicil;
			$cicilan = $post->cicilan;
			$cicilanlog = "Rp. " . number_format($post->cicilan, 0, "", ",");
			$telah_dibayar = $post->telah_dibayar;
			$jumlah_telah_dibayar = $post->jumlah_telah_dibayar;
			$jumlah_cicilan = $post->jumlah_cicilan;
			//RUMUS
			$hasil_telah_bayar = $telah_dibayar-$cicilan;
			$hasil_jumlah = $jumlah_telah_dibayar-1;
			//RUMUS
				$data_konsumen = $this->rekap_nota_transaksi_konsumen_model->get_konsumen($id_konsumen_cicil);
				error_reporting(0);
			    $dk = $data_konsumen->row_array();
			    $nama = $dk['nama'];


				$data_list_transaksi = $this->rekap_nota_transaksi_konsumen_model->get_list_transaksi($id_notas);
				error_reporting(0);
			    $bx = $data_list_transaksi->row_array();
			    $dapatkan_hutang = $bx['dapatkan_hutang'];
			    $jenis_transaksi = $bx['jenis_transaksi'];
			//RUMUS   
			$rubah_list_dapatkan_hutang = $dapatkan_hutang+$cicilan;
			
			if ($hasil_jumlah <= $jumlah_cicilan) {
				$rubah_list_jenis_transaksi = 'Cicil';	
			} else {
				$rubah_list_jenis_transaksi = 'Cicilan Lunas';	
				
			}
		    //RUMUS
				if ($hasil_jumlah < 0) {
		    		$data = array('res' => "error", 'message' => "Change query error");
				} else if ($this->rekap_nota_transaksi_konsumen_model->unpaid_entry($id_notas,$id_konsumen_cicil,$cicilan,$hasil_telah_bayar,$hasil_jumlah,$rubah_list_dapatkan_hutang,$rubah_list_jenis_transaksi)) {
					// DELETE CASH
				
					$id_cicil_cancel = $jumlah_telah_dibayar;
					$this->rekap_nota_transaksi_konsumen_model->delete_cash($id_cicil_cancel,$id_notas);
					// DELETE CASH


					// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Mengkonfirmasi Pembatalan Pembayaran Cicilan <b>'.$nama.' Sebanyak '.$cicilanlog.'</b>';
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
	// BAYAR CICILAN

	
	//DETAIL
	function detail(){
		$id = $this->uri->segment(4);
		$get_kode=$this->rekap_nota_transaksi_konsumen_model->get_kode_detail($id);
		if($get_kode->num_rows() > 0){
		
			
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Detail Nota Transaksi Konsumen';
			
			
			$data['id'] = $id;

				$datas = $this->rekap_nota_transaksi_konsumen_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $data['catatan'] = $bx['catatan'];
			    $data['kode_transaksi'] = $bx['kode_transaksi'];
			    $data['jenis_transaksi'] = $bx['jenis_transaksi'];
			    $data['tenorbulan'] = $bx['tenorbulan'];
			    $total_belanja = $bx['total_belanja'];
			    $data['showtotal_belanja'] = "Rp. " . number_format($total_belanja, 0, "", ",");
			    $cicilan = $bx['cicilan'];
			    $data['showcicilan'] = "Rp. " . number_format($cicilan, 0, "", ",");
			    $data['jumlah_telah_dibayar'] = $bx['jumlah_telah_dibayar'];
			    $telah_dibayar = $bx['telah_dibayar'];
			    $data['telah_dibayar'] = $bx['telah_dibayar'];
			    $data['showtelah_dibayar'] = "Rp. " . number_format($telah_dibayar, 0, "", ",");
			    $data['tgl_update_bayar'] = format_indo(date($bx['tgl_update_bayar']));
			    $data['nama'] = $bx['nama'];
			    $data['jumlah_laku'] = $bx['totals'];

			    $jumlah_dibayar = $bx['jumlah_dibayar'];
			    $data['jumlah_dibayar'] = "Rp. " . number_format($jumlah_dibayar, 0, "", ",");

			    $harga_jual_laku = $bx['harga_jual_laku'];
			    $data['showharga_jual_laku'] = "Rp. " . number_format($harga_jual_laku, 0, "", ",");

			    $data['tgl_transaksi'] = format_indo(date($bx['tgl_transaksi']));
			    $data['tgl_ubah'] = format_indo(date($bx['tgl_ubah']));
			   	$data['karyawan'] = $bx['user_name'];
				$this->load->view('backend/menu',$data);
				$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_detail_transaksi',$data);
		} else {
			redirect('backend/rekap_transaksi_barang');
		}
	}
	function detailnota(){
		$id = $this->uri->segment(4);
		$get_kode=$this->rekap_nota_transaksi_konsumen_model->get_kode_detail($id);
		if($get_kode->num_rows() > 0){
		
			
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Detail Nota Transaksi Konsumen';
			
			
			$data['id'] = $id;

				$datas = $this->rekap_nota_transaksi_konsumen_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $data['catatan'] = $bx['catatan'];
			    $data['kode_transaksi'] = $bx['kode_transaksi'];
			    $data['jenis_transaksi'] = $bx['jenis_transaksi'];
			    $data['tenorbulan'] = $bx['tenorbulan'];
			    $total_belanja = $bx['total_belanja'];
			    $data['showtotal_belanja'] = "Rp. " . number_format($total_belanja, 0, "", ",");
			    $cicilan = $bx['cicilan'];
			    $data['showcicilan'] = "Rp. " . number_format($cicilan, 0, "", ",");
			    $data['jumlah_telah_dibayar'] = $bx['jumlah_telah_dibayar'];
			    $telah_dibayar = $bx['telah_dibayar'];
			    $data['telah_dibayar'] = $bx['telah_dibayar'];
			    $data['showtelah_dibayar'] = "Rp. " . number_format($telah_dibayar, 0, "", ",");
			    $data['tgl_update_bayar'] = format_indo(date($bx['tgl_update_bayar']));
			    $data['nama'] = $bx['nama'];
			    $data['jumlah_laku'] = $bx['totals'];

			    $id_kon = $bx['id_konsumen_transaksi'];
			  	$datak = $this->konsumen_model->get_id_cus2($id_kon);
				error_reporting(0);
			    $bxx = $datak->row_array();
			    $data['id_cus'] = $bxx['id_cus'];

			    $jumlah_dibayar = $bx['jumlah_dibayar'];
			    $data['jumlah_dibayar'] = "Rp. " . number_format($jumlah_dibayar, 0, "", ",");

			    $harga_jual_laku = $bx['harga_jual_laku'];
			    $data['showharga_jual_laku'] = "Rp. " . number_format($harga_jual_laku, 0, "", ",");

			    $data['tgl_transaksi'] = format_indo(date($bx['tgl_transaksi']));
			    $data['tgl_ubah'] = format_indo(date($bx['tgl_ubah']));
			   	$data['karyawan'] = $bx['user_name'];
				$this->load->view('backend/menu',$data);
				$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_detail_nota',$data);
		} else {
			redirect('backend/rekap_transaksi_barang');
		}
	}
	public function get_ajax_list_detail()
	{
		$id = $this->input->post('id');
		$list = $this->rekap_nota_transaksi_konsumen_model->get_datatables_detail($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		
			$row[] = $no;
			$row[] = $d->nama_stock;
			$row[] = $d->jumlah_transaksi.' '.$d->nama_satuan;
			$row[] = "Rp. " . number_format($d->harga_jual_transaksi, 0, "", ",");
			if($this->session->userdata('level')==1) {
				$row[] = '<a class="btn icon btn-primary btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->transaksi_id.'"><i class="bi bi-trash"></i> Hapus</a>';
			} else {

			}
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_nota_transaksi_konsumen_model->count_all_detail($id),
						"recordsFiltered" => $this->rekap_nota_transaksi_konsumen_model->count_filtered_detail($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
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
			
				if ($this->rekap_nota_transaksi_konsumen_model->delete_entry($transaksi_id,$jmlh,$kembalikan_nilai_saham,$bahan_baku,$konsumen)) {
					$data = array('res' => "success", 'message' => "Data berhasil dihapus");
				} else {
					$data = array('res' => "error", 'message' => "Delete query error");
				}
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	public function prosespembatalannota()
	{
		if ($this->input->is_ajax_request()) {
			$id_notas = $this->input->post('id_nota');
			

			$id_users = $this->session->userdata('id');
			$post = $this->rekap_nota_transaksi_konsumen_model->single_entry_transaksi_list($id_notas);
			$id_konsumen_transaksi = $post->id_konsumen_transaksi;
			$dapatkan_hutang = $post->dapatkan_hutang;

			$datas = $this->rekap_nota_transaksi_konsumen_model->get_hutang_konsumen($id_konsumen_transaksi);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $hutang = $bx['hutang'];
		    $pembatalan_hutang_konsumen = $hutang-$dapatkan_hutang;
		    $ajax_data_konsumen['hutang'] = $pembatalan_hutang_konsumen;
			$ajax_data_konsumen['tgl_ubah_konsumen'] = date("Y-m-d h:i:a");
			$this->rekap_nota_transaksi_konsumen_model->update_hutang_konsumen($id_konsumen_transaksi, $ajax_data_konsumen);
			
				if ($this->rekap_nota_transaksi_konsumen_model->pembatalan_nota($id_notas)) {
		    	
		    		// INSERT LOG
					$nama_users = $this->session->userdata('name');
					
					$b = '<b>'.$nama_users.'</b> Melakukan Pembatalan Nota Transaksi '.$id_notas.'';
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
	//DETAIL



}