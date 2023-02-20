<?php
class Retur_barang_ekspedisi extends CI_Controller{
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
		$this->load->model('backend/Retur_barang_model','retur_barang_model');
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
		$data['title'] = 'Retur Barang Ekspedisi';
		
		$data['ksuratjalan'] = $this->retur_barang_model->get_all_ksuratjalan();
		$data['karyawan'] = $this->retur_barang_model->get_all_karyawan();
		$this->load->view('backend/menu',$data);
		$this->load->view('backend/_partials/templatejs');
		
		$this->load->view('backend/v_retur_barang', $data);
	}
	public function get_ajax_list()
	{
		$list = $this->retur_barang_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			
			$no++;
			$row = array();
		
			$row[] = $no;
			$row[] = $d->retur_kode_surat_jalan;
			$row[] = $d->nama_stock;
			$row[] = $d->retur_jumlah.' '.$d->nama_satuan;
			$row[] = format_indo(date($d->retur_tgl_buat));
			$row[] = '<a class="btn icon btn-danger btn-sm" href="javascript:void()" title="Hapus" id="del" value="'.$d->retur_id.'"><i class="bi bi-trash"></i> Hapus</a>';
			
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->retur_barang_model->count_all(),
						"recordsFiltered" => $this->retur_barang_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
  
	
	function add() {
		if ($this->input->is_ajax_request()) {
			$bahan_baku = $this->input->post('bahan_baku');
		
			$y = $this->input->post('jumlah');
		
	    	$datas = $this->retur_barang_model->get_stocks($bahan_baku);
			error_reporting(0);
		    $bx = $datas->row_array();
		    $z = $bx['stock'];
		    $zz = $bx['harga_beli'];
		    $xxx = $bx['nilai_saham'];
		    $x = $z + $y;
		    $kk = $zz/$z;
		    $kkk = $kk*$y;
			$xxxx = $xxx+$kkk;	

		    if($z < $y) { 
		    	$data = array('res' => "stok_habis", 'message' => "Change query error");
		    } else {

			
	        		$id_users = $this->session->userdata('id');
					$data2 = array(
						'retur_kode_surat_jalan' => $this->input->post('kode_surat_jalan'),
						'retur_bahan_baku_id' => $this->input->post('bahan_baku'),
						'retur_jumlah' => $this->input->post('jumlah'),
						'retur_nilai_saham' => $kkk,
						'retur_user_id' => $id_users,
					);
				

				if ($this->retur_barang_model->insert_stock($data2)) {
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
			
			$ls_surat_jalan_id = $this->input->post('id');
			

	
				if ($this->retur_barang_model->delete_entry($ls_surat_jalan_id)) {
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