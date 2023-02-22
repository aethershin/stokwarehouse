<?php
class Satuan extends CI_Controller{
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
		$this->load->model('backend/Satuan_model','satuan_model');
		$this->load->model('Site_model','site_model');
		$this->load->helper('text');
		$this->load->helper('url');
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $x['site_title'] = $site['site_title'];
        $x['site_favicon'] = $site['site_favicon'];
        $x['images'] = $site['images'];
		$x['title'] = 'Satuan';
		$this->load->view('backend/menu',$x);
		$this->load->view('backend/modal/satuan_modal');
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_satuan',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->satuan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $d->nama_satuan;
			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7"><a class="dropdown-item item_edit" href="javascript:void()" title="Edit" onclick="edit_satuan('."'".$d->id_satuan."'".')"><i class="bi bi-pen-fill"></i> Edit</a>
				  <a class="dropdown-item delete_record" href="javascript:void()" title="Hapus" id="del" value="'.$d->id_satuan.'"><i class="bi bi-trash"></i> Hapus</a></div></div></div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->satuan_model->count_all(),
						"recordsFiltered" => $this->satuan_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id_satuan)
	{
		$data = $this->satuan_model->get_by_id($id_satuan);
		echo json_encode($data);
	}

	function add(){
    	
		$this->_validate();
    		
		

			$arraysql = array(
    			"nama_satuan" => $this->input->post('nama',TRUE)
			);
				$insert = $this->satuan_model->insert_satuan($arraysql);
				
				if($insert){
					echo json_encode(array("status" => TRUE));
				}else{
					echo json_encode(array("status" => FALSE));
				}
		
    }

	
    public function edit() {
		$this->_validate_edit();
    	
    	
		$arraysql = array(
			"nama_satuan" => $this->input->post('nama',TRUE)
		);
		$this->satuan_model->update(array('id_satuan' => $this->input->post('id')), $arraysql);
		// update ke mysql
		echo json_encode(array("status" => TRUE));	
    }
    public function delete() {
    	if ($this->input->is_ajax_request()) {
    		$id = $this->input->post('id');
	    	
				if ($this->satuan_model->delete_entry($id)) {
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
		
	    $nama = $this->input->post('nama');
		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}
		$namalength= strlen($nama);
		if($namalength < 2)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Satuan Minimal 2 karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 10)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Satuan Maksimal 10 Karakter';
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
    	$nama = $this->input->post('nama');
		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}
		$namalength= strlen($nama);
		if($namalength < 2)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Satuan Minimal 2 karakter';
			$data['status'] = FALSE;
		}
		if($namalength > 10)
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Satuan Maksimal 10 Karakter';
			$data['status'] = FALSE;
		}
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	


}