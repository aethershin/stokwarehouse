<?php
class Warehouse extends CI_Controller{
/**
* Description of Controller
*
* @author https://aethershin.com
*/	
	function __construct(){
		parent::__construct();
		error_reporting(0);
		if($this->session->userdata('access') != "1"){
			$url=base_url('login_user');
            redirect($url);
		};
		$this->load->model('backend/Stock_model','stock_model');
		$this->load->model('Site_model','site_model');
		$this->load->library('upload');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('download');
		$this->load->helper('tanggal');
		$this->load->library('ciqrcode');
		
	}

	
	
	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_favicon'] = $site['site_favicon'];
        $data['images'] = $site['images'];
		$data['title'] = 'Warehouse';
		$data['kategori'] = $this->stock_model->get_all_kategori();
		$data['satuan'] = $this->stock_model->get_all_satuan();
		$total = $this->stock_model->count_all_stock();
		
		foreach($total as $result){
            $data['all'] = "Rp. " . number_format($result->stock, 0, "", ",");
        }
        $this->load->view('backend/menu',$data);
        $this->load->view('backend/modal/stock_modal');
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_warehouse', $data);
	}
	public function get_ajax_list()
	{
		$list = $this->stock_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$a = $d->stock_minimal;
			$b = $d->stock;
			$xxz = $d->kode_stock;
			if ($b <= $a) {
				$c = 'warning';
				$x = 'bi bi-exclamation-triangle';
			} else {
				
			}
			$no++;
			$row = array();
			
			$row[] = $d->nama_stock;

			$row[] = "Rp " . number_format($d->harga_beli, 0, "", ",");
	
			if ($b <= $a) {
				$row[] = '<div class="alert-sm-xd alert-light-'.$c.' color-'.$c.'"><i class="'.$x.'"></i> '.number_format($d->stock, 0, "", ",").' '.$d->nama_satuan.'</div>';
			} else {
				$row[] = number_format($d->stock, 0, "", ",").' '.$d->nama_satuan;
			}
			
			
			

			

			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7"><a class="dropdown-item" href="javascript:void()" title="Edit" onclick="edit_stock('."'".$d->id_stock."'".')"><i class="bi bi-pen-fill"></i> Edit</a>
				  <a class="dropdown-item delete_record" href="javascript:void()" title="Hapus" id="del" value="'.$d->id_stock.'"><i class="bi bi-trash"></i> Hapus</a></div></div></div>';
			
			
			$data[] = $row;
		}
			
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->stock_model->count_all(),
						"recordsFiltered" => $this->stock_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
			
		echo json_encode($output);
	}
  	function download_qr(){
  		$id_qr = $this->uri->segment(4);

		$path="assets/images/qrcode/".$id_qr.".png";
		$data =  file_get_contents($path);
		$name = $id_qr.'.png';
		force_download($name, $data); 
		redirect('backend/warehouse');
	}
	public function ajax_edit($id_stock)
	{
		$data = $this->stock_model->get_by_id($id_stock);
		echo json_encode($data);
	}
	function add(){
		$this->_validate();
		
		// GET NEW ID
		$get_new_id = $this->stock_model->get_new_kode_stock();
        foreach($get_new_id as $result){
            $kode_New_id =  $result->maxKode;
        }
        $noUrut = (int) substr($kode_New_id, 4, 12);
        $noUrut++;
        $char = "BHN-";
        $NewID = $char.str_pad($noUrut, 12, '0', STR_PAD_LEFT);
		// GET NEW ID
		$users = $this->session->userdata('id');
		$nama_users = $this->session->userdata('name');
		$j = $this->input->post('nama_stock');
		
	    $xx = $this->input->post('kategori_material');    
			
		//QRCODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$NewID.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $NewID; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
		//QRCODE	
				$data = array(
					'kode_stock' => $NewID,
					'nama_stock' => $this->input->post('nama_stock'),
					'kategori_stock' => $this->input->post('kategori_stock'),
					'kategori_material' => $this->input->post('kategori_material'),
					'satuan_stock' => $this->input->post('satuan_stock'),
					'harga_beli' => $this->input->post('harga_beli'),
					'stock' => 0,
					'stock_minimal' => $this->input->post('stock_minimal'),
					'nilai_saham' => 0,
					'user_id_stock' => $users,
					
				);
				
				
				$insert = $this->stock_model->insert_stock($data);
				
				if($insert){
					// INSERT LOG
					$kx = $this->input->post('kategori_material');
					$j = $this->input->post('nama_stock');
					$b = '<b>'.$nama_users.'</b> Melakukan Tambah '.$kx.' <b>'.$j.'</b>';
					$data2 = array(
						'ket' => $b,
					);
					$this->stock_model->insert_log_stock($data2);
					// INSERT LOG
					echo json_encode(array("status" => TRUE));
				}else{
					echo json_encode(array("status" => FALSE));
				}
			
		
	}



	function edit(){
		$id=$this->input->post('id',TRUE);
		$id_stock=$this->input->post('id',TRUE);
		$this->_validate_edit();
			
					
					$users = $this->session->userdata('id');
					$ajax_data['nama_stock'] = $this->input->post('nama_stock');
					$ajax_data['kategori_stock'] = $this->input->post('kategori_stock');
					$ajax_data['kategori_material'] = $this->input->post('kategori_material');
					$ajax_data['satuan_stock'] = $this->input->post('satuan_stock');
					$ajax_data['harga_beli'] = $this->input->post('harga_beli');
					$ajax_data['stock_minimal'] = $this->input->post('stock_minimal');
					
					$ajax_data['user_id_stock'] = $users;
					date_default_timezone_set("Asia/Jakarta");
					$ajax_data['tgl_ubah'] = date("Y-m-d H:i:a");
					

					if ($this->stock_model->update_entry($id, $ajax_data)) {
						// INSERT LOG
						$nama_users = $this->session->userdata('name');
						$kx = $this->input->post('kategori_material');

						$j = $this->input->post('nama_stock');
						$jjj = $this->input->post('stock');
						$b = '<b>'.$nama_users.'</b> Melakukan Edit '.$kx.' <b>'.$j.'</b>';
						$data2 = array(
							'ket' => $b,
						);
						$this->stock_model->insert_log_stock($data2);
						// INSERT LOG
						echo json_encode(array("status" => TRUE));
					} else {
						echo json_encode(array("status" => FALSE));
					}
						
	}

	
	public function delete()
	{
		if ($this->input->is_ajax_request()) {

			$id_stock = $this->input->post('id');

			$post = $this->stock_model->single_entry($id_stock);

				if ($this->stock_model->delete_entry($id_stock)) {
					$NewID = $post->kode_stock;
					unlink(APPPATH . '../assets/images/qrcode/'.$NewID.'.png');
					// INSERT LOG
					$nama_users = $this->session->userdata('name');
					$kx = $post->kategori_material;
					
					$j = $post->nama_stock;
					$b = '<b>'.$nama_users.'</b> Melakukan Menghapus '.$kx.' <b>'.$j.'</b>';
					$data2 = array(
						'ket' => $b,
					);
					$this->stock_model->insert_log_stock($data2);
					// INSERT LOG
					$data = array('res' => "success", 'message' => "Data berhasil dihapus");
				} else {
					$data = array('res' => "error", 'message' => "Delete query error");
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
		$nama = $this->input->post('nama_stock');
		

		if($this->input->post('nama_stock') == '')
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('harga_beli') == '')
		{
			$data['inputerror'][] = 'harga_beli';
			$data['error_string'][] = 'Form Harga Beli harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('kategori_stock') == '')
		{
			$data['inputerror'][] = 'kategori_stock';
			$data['error_string'][] = 'Form Kategori harus berisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('kategori_material') == '')
		{
			$data['inputerror'][] = 'kategori_material';
			$data['error_string'][] = 'Form Kategori Material harus berisi';
			$data['status'] = FALSE;
		}
		if($this->input->post('satuan_stock') == '')
		{
			$data['inputerror'][] = 'satuan_stock';
			$data['error_string'][] = 'Form Satuan harus berisi';
			$data['status'] = FALSE;
		}

		$namalength= strlen($nama);
		if($namalength < 3)
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Nama Miminal 3 Karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 35)
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Nama Maksimal 35 Karakter';
			$data['status'] = FALSE;
		}
	
		if($this->input->post('stock_minimal') == '')
		{
			$data['inputerror'][] = 'stock_minimal';
			$data['error_string'][] = 'Form Stock Minimal harus berisi';
			$data['status'] = FALSE;
		}
		
		
	    

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private function _validate_edit()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		$nama = $this->input->post('nama_stock');
		
		if($this->input->post('nama_stock') == '')
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('harga_beli') == '')
		{
			$data['inputerror'][] = 'harga_beli';
			$data['error_string'][] = 'Form Harga Beli harus berisi';
			$data['status'] = FALSE;
		}
		if($this->input->post('kategori_stock') == '')
		{
			$data['inputerror'][] = 'kategori_stock';
			$data['error_string'][] = 'Form Kategori harus berisi';
			$data['status'] = FALSE;
		}
		if($this->input->post('kategori_material') == '')
		{
			$data['inputerror'][] = 'kategori_material';
			$data['error_string'][] = 'Form Kategori Material harus berisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('satuan_stock') == '')
		{
			$data['inputerror'][] = 'satuan_stock';
			$data['error_string'][] = 'Form Satuan harus berisi';
			$data['status'] = FALSE;
		}

		$namalength= strlen($nama);
		if($namalength < 3)
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Nama Miminal 3 Karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 35)
		{
			$data['inputerror'][] = 'nama_stock';
			$data['error_string'][] = 'Nama Maksimal 35 Karakter';
			$data['status'] = FALSE;
		}
	
		if($this->input->post('stock_minimal') == '')
		{
			$data['inputerror'][] = 'stock_minimal';
			$data['error_string'][] = 'Form Stock Minimal harus berisi';
			$data['status'] = FALSE;
		}
		
		
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	
}