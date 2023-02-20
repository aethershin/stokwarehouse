<?php
class Rekap_surat_jalan extends CI_Controller{
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
		$this->load->model('backend/Rekap_surat_jalan_model','rekap_surat_jalan_model');
		$this->load->model('backend/Surat_jalan_model','surat_jalan_model');
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
		$x['title'] = 'Rekap Surat Jalan';
		
		$total = $this->rekap_surat_jalan_model->count_all_biaya();
		foreach($total as $result){
            $x['all'] = number_format($result->biaya, 0, "", ",");
        }
        $this->load->view('backend/menu',$x);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_rekap_surat_jalan',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->rekap_surat_jalan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $d->kode_surat_jalan;
			$row[] = $d->jumlah_surat_jalan;
			$row[] = format_indo(date($d->tgl_ubah_surat_jalan));
			$row[] = $d->user_name;
			if($this->session->userdata('access')=='1') {
			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
			<a class="dropdown-item delete_record detail" href="javascript:void()" data-id="'.$d->kode_surat_jalan.'"><i class="bi bi-eye"></i> Detail</a>
			<a class="dropdown-item" href="javascript:void()" title="Hapus" id="del" value="'.$d->kode_surat_jalan.'"><i class="bi bi-trash"></i> Batalkan Surat Jalan</a>
			
			<a class="dropdown-item d-nota" href="javascript:void()" data-id="'.$d->surat_jalan_id.'"><i class="bi bi-download"></i> Downlaod PDF</a>
				  </div></div></div>';
			} else {
				$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
				<a class="dropdown-item delete_record detail" href="javascript:void()" data-id="'.$d->kode_surat_jalan.'"><i class="bi bi-eye"></i> Detail</a>
				<a class="dropdown-item d-nota" href="javascript:void()" data-id="'.$d->surat_jalan_id.'"><i class="bi bi-download"></i> Downlaod PDF</a>
				  </div></div></div>';
			}
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_surat_jalan_model->count_all(),
						"recordsFiltered" => $this->rekap_surat_jalan_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($produksi_selesai_id)
	{
		$data = $this->rekap_surat_jalan_model->get_by_id($produksi_selesai_id);
		echo json_encode($data);
	}

	public function nota_pdf() {
		// Mengambil KRS ID Array Mahasiswa
		$surat_jalan_id = $this->uri->segment(4);
		$site = $this->site_model->get_site_data()->row_array();
        $images = $site['images'];
        $site_title = $site['site_title'];
        $notelp = $site['notelp'];
        $alamat_universitas = $site['alamat_universitas'];
        $email = $site['email'];


		$detailstok = $this->rekap_surat_jalan_model->get_detail_surat_jalan($surat_jalan_id);
		error_reporting(0);
	    $c = $detailstok->row_array();
	    $kode_surat_jalan = $c['kode_surat_jalan'];
	    $jumlah_surat_jalan = $c['jumlah_surat_jalan'];
	    $catatan_surat_jalan = $c['catatan_surat_jalan'];

	    $diserahkan = $c['diserahkan_sj'];
	    $penerima = $c['penerima_sj'];
	    $diketahui = $c['diketahui_sj'];

	    $tgl_ubah_surat_jalan = format_indo(date($c['tgl_ubah_surat_jalan']));

	    $count_retur = $this->rekap_surat_jalan_model->count_bretur($kode_surat_jalan);
		$rowcount = $count_retur->row_array();
		$bretur = $rowcount['bretur'];


		
        
        // PDF Template            
        $this->load->library('Pdf');
		$pdf = new PDF('l','mm','A4');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); 
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
        $pdf->SetFont('times','B',16);
        $pdf->Cell(190,7,'SURAT JALAN',0,1,'C');

        
        $pdf->SetFont('times','B',14);
        // mencetak string 
        $pdf->Cell(190,7,$kode_surat_jalan,0,1,'C');
        $pdf->Cell(190,7,'Medan, '.$tgl_ubah_surat_jalan,0,1,'R');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('times','B',12);
        $pdf->Cell(10,6,'No',1,0);
        $pdf->Cell(110,6,'Nama Produk',1,0);
        $pdf->Cell(70,6,'Jumlah',1,1);
        $pdf->SetFont('times','',12);
        $no=0;
        $foreach = $this->rekap_surat_jalan_model->get_tambah_surat_jalan($kode_surat_jalan);
        foreach ($foreach as $row){
        	$nama_satuan = $row->nama_satuan;
        	$no++;
            $pdf->Cell(10,6,$no,1,0);
            $pdf->Cell(110,6,$row->nama_stock,1,0);
            $pdf->Cell(70,6,$row->jumlah_ls_surat_jalan.' '.$row->nama_satuan,1,1);
        }
        $pdf->SetFont('times','B',12);
        $pdf->Cell(10,6,' ',1,0);
        $pdf->Cell(110,6,' ',1,0);
        $pdf->Cell(70,6,'Total Jumlah :'.$jumlah_surat_jalan.' '.$nama_satuan,1,0);
        $pdf->Cell(10,7,'',0,1);
        $pdf->Cell(10,7,'',0,1);
        if ($bretur < 1) {

        } else {

        	$pdf->writeHTML("<hr>", true, false, false, false, '');

        	$pdf->SetFont('times','B',12);
	        $pdf->Cell(10,6,'No',1,0);
	        $pdf->Cell(110,6,'Nama Produk Retur',1,0);
	        $pdf->Cell(70,6,'Jumlah Retur',1,1);
	        $pdf->SetFont('times','',12);
	        $no=0;
	        $krs_pdf = $this->rekap_surat_jalan_model->get_tambah_retur($kode_surat_jalan);
	        foreach ($krs_pdf as $row){
	        	$total_retur_jumlah += $row->retur_jumlah;
	        	$nama_satuan_retur = $row->nama_satuan;
	        	$no++;
	            $pdf->Cell(10,6,$no,1,0);
	            $pdf->Cell(110,6,$row->nama_stock,1,0);
	            $pdf->Cell(70,6,$row->retur_jumlah.' '.$row->nama_satuan,1,1);
	        }
	        $pdf->SetFont('times','B',12);
	        $pdf->Cell(10,6,' ',1,0);
	        $pdf->Cell(110,6,' ',1,0);
	        $pdf->Cell(70,6,'Total Jumlah :'.$total_retur_jumlah.' '.$nama_satuan_retur,1,0);
	        $pdf->Cell(10,7,'',0,1);
        }

        $pdf->SetFont('times','',12);
        $pdf->Cell(190,7,'Catatan* :'.$catatan_surat_jalan,0,1,'');
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('times','B',12);
        
        $pdf->Cell(70,7,'Diserahkan',0,0,'');
        $pdf->Cell(70,7,'Penerima',0,0,'');
        $pdf->Cell(60,7,'Diketahui',0,1,'');
        $pdf->Cell(10,7,' ',0,1,'');
        $pdf->Cell(10,7,'',0,1);
        $pdf->Cell(10,7,'',0,1);
        $pdf->Cell(70,7,$diserahkan,0,0,'');
        $pdf->Cell(70,7,$penerima,0,0,'');
        $pdf->Cell(60,7,$diketahui,0,1,'');
       

        $pdf->Output('Surat_Jalan-'.$kode_surat_jalan.'.pdf', 'D');
        // PDF Template
	}
	function detail(){
		$id = $this->uri->segment(4);
		$get_kode=$this->rekap_surat_jalan_model->get_kode_rekap($id);
		if($get_kode->num_rows() > 0){
		
			
			
			$site = $this->site_model->get_site_data()->row_array();
	        $data['site_title'] = $site['site_title'];
	        $data['site_favicon'] = $site['site_favicon'];
	        $data['images'] = $site['images'];
			$data['title'] = 'Detail Surat Jalan';
			
			
			$data['id'] = $id;

				$datas = $this->rekap_surat_jalan_model->get_detail_nota($id);
				error_reporting(0);
			    $bx = $datas->row_array();
			    $kode_surat_jalan = $bx['kode_surat_jalan'];
			    $data['jumlah_surat_jalan'] = $bx['jumlah_surat_jalan'];
			    $data['id_user_surat_jalan'] = $bx['id_user_surat_jalan'];
			    $data['diserahkan_sj'] = $bx['diserahkan_sj'];

			    $data['penerima_sj'] = $bx['penerima_sj'];
			    $data['diketahui_sj'] = $bx['diketahui_sj'];
			    $data['catatan_surat_jalan'] = $bx['catatan_surat_jalan'];
			    $tglshow = $bx['tgl_ubah_surat_jalan'];
			    $data['tgl_ubah_surat_jalan'] = format_indo(date($tglshow));
				$data['dataretur'] = $this->rekap_surat_jalan_model->get_all_retur_by_kode($id);
				$this->load->view('backend/menu',$data);
				$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_detail_surat_jalan',$data);
		} else {
			redirect('backend/rekap_surat_jalan');
		}
	}

	public function get_ajax_list_detail()
	{
		$id = $this->input->post('id');
		$list = $this->rekap_surat_jalan_model->get_datatables_detail($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
			
			
			$row[] = $no;
			$row[] = $d->nama_stock;
			$row[] = $d->jumlah_ls_surat_jalan;
			
			
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rekap_surat_jalan_model->count_all_detail($id),
						"recordsFiltered" => $this->rekap_surat_jalan_model->count_filtered_detail($id),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->input->is_ajax_request()) {
			
			$kode_surat_jalan = $this->input->post('id');
			
			
			
				if ($this->rekap_surat_jalan_model->delete_entry($kode_surat_jalan)) {
					$data = array('res' => "success", 'message' => "Data berhasil dihapus");
				} else {
					$data = array('res' => "error", 'message' => "Delete query error");
				}
			
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
	
}