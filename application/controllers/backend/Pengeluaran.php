<?php
class Pengeluaran extends CI_Controller{
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
		$this->load->model('backend/Pengeluaran_model','pengeluaran_model');
		$this->load->model('backend/Stock_model','stock_model');
		$this->load->model('backend/Absensi_model','absensi_model');
		$this->load->model('Site_model','site_model');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('tanggal');
		$this->load->library('upload');
		$this->load->helper('form');
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $x['site_title'] = $site['site_title'];
        $x['site_favicon'] = $site['site_favicon'];
        $x['images'] = $site['images'];
		$x['title'] = 'Pengeluaran';
		$x['karyawan'] = $this->pengeluaran_model->get_all_karyawan();
		$x['dataimage'] = $this->pengeluaran_model->get_all_bukti();
		$this->load->view('backend/menu',$x);
		$this->load->view('backend/modal/pengeluaran_modal');
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_pengeluaran',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->pengeluaran_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = $no;
		
			$row[] = "<div class='row gallery' data-bs-toggle='modal' data-bs-target='#galleryModal$d->id_pengeluaran'><a href='#'><img class='w-100 active' src='../assets/images/fotobukti/$d->imgbukti' data-bs-target='#Gallerycarousel'></a></div>";
			$row[] = $d->ket_pengeluaran;
			$row[] = "Rp " . number_format($d->biaya_pengeluaran, 0, "", ",");
			$row[] = format_indo(date($d->tgl_pengeluaran));
			$row[] = $d->user_name;
			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7"><a class="dropdown-item item_edit" href="javascript:void()" title="Edit" onclick="edit_pengeluaran('."'".$d->id_pengeluaran."'".')"><i class="bi bi-pen-fill"></i> Edit</a>
			<a class="dropdown-item delete_record" href="javascript:void()" title="Hapus" id="del" value="'.$d->id_pengeluaran.'"><i class="bi bi-trash"></i> Hapus</a>
				  </div></div></div>';
			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pengeluaran_model->count_all(),
						"recordsFiltered" => $this->pengeluaran_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_edit($id_pengeluaran)
	{
		$data = $this->pengeluaran_model->get_by_id($id_pengeluaran);
		echo json_encode($data);
	}

	function add(){
    	
		$this->_validate();
    	$config['upload_path'] = './assets/images/fotobukti/'; //path folder
	    $config['allowed_types'] = 'jpg|png|jpeg|webp';
	    $config['encrypt_name'] = TRUE;
	    $this->upload->initialize($config);
	    	if(!empty($_FILES['picture_1']['name'])){

	    		if ($this->upload->do_upload('picture_1')){
		            $filefotobukti = $this->upload->data();
		            $bg_filefotobukti=$filefotobukti['file_name'];
		        } 	
				$biaya = $this->input->post('biaya',TRUE);
				$ket = $this->input->post('ket',TRUE);
				$biayashow = "Rp " . number_format($biaya, 0, "", ",");
				$users = $this->session->userdata('id');
				$arraysql = array(
	    			"ket_pengeluaran" => $this->input->post('ket',TRUE),
	    			"biaya_pengeluaran" => $this->input->post('biaya',TRUE),
	    			"imgbukti" => $bg_filefotobukti,
	    			"id_user_pengeluaran" => $users
				);
					$insert = $this->pengeluaran_model->insert_pengeluaran($arraysql);
					
					if($insert){
						// INSERT LOG
						
						$nama_users = $this->session->userdata('name');
						$b = '<b>'.$nama_users.'</b> Menambah Pengeluaran Sebesar <b>'.$biayashow.'</b> Untuk Keperluan '.$ket;
						$data2 = array(
							'ket' => $b,
						);
						$this->stock_model->insert_log_stock($data2);
						// INSERT LOG
						echo json_encode(array("status" => TRUE));
					}else{
						echo json_encode(array("status" => FALSE));
					}
			} else {
				echo json_encode(array("status" => FALSE));
			}
		
    }

	
    function edit() {
    	$pengeluaranid=$this->input->post('id',TRUE);
		$this->_validate_edit();
					if (isset($_FILES["picture_1"]["name"])) {
			    		$config['upload_path'] = APPPATH . '../assets/images/fotobukti/';
						$config['allowed_types'] = 'jpg|png|jpeg|webp';
						$config['encrypt_name'] = TRUE;
					    $this->upload->initialize($config);
			    		if (!$this->upload->do_upload("picture_1")) {
				        	echo json_encode(array("status" => FALSE));
						} else {
				            $gbr = $this->upload->data();
			                //Compress Image

			                $config['image_library']='gd2';
							$config['source_image'] = APPPATH . '../assets/images/fotobukti/'.$gbr['file_name'];
					        $config['create_thumb']= FALSE;
					        $config['maintain_ratio']= FALSE;
					        $config['quality']= '100%';
					        $config['new_image'] = APPPATH . '../assets/images/fotobukti/'.$gbr['file_name'];
					        $this->load->library('image_lib', $config);
					        $this->image_lib->resize();

					        $gambar=$gbr['file_name'];
					        $id = $this->input->post('id',TRUE);
							$post2 = $this->pengeluaran_model->single_entry($id);
							$check = $post2->imgbukti;
							if ($check == 'user_blank.webp') {
								// Tidak hapus user_blank.webp
							} else {
								unlink(APPPATH . '../assets/images/fotobukti/' . $post2->imgbukti);
							}

							$ajax_data['imgbukti'] = $gambar;
							
						
				        }      
				    }
				$id = $this->input->post('id',TRUE);
	    		$biaya = $this->input->post('biaya',TRUE);
				$ket = $this->input->post('ket',TRUE);
				$biayashow = "Rp " . number_format($biaya, 0, "", ",");
	    		
				$post = $this->pengeluaran_model->single_entry($id);
				$biaya_lama = $post->biaya_pengeluaran;
				$biaya_lama_show = "Rp " . number_format($biaya_lama, 0, "", ",");
		
				// INSERT LOG
				$nama_users = $this->session->userdata('name');
				$b = '<b>'.$nama_users.'</b> Mengubah Pengeluaran Sebesar <b>'.$biaya_lama_show.' Menjadi '.$biayashow.'</b> Untuk Keperluan '.$ket;
				$data2 = array(
					'ket' => $b,
				);
				$this->stock_model->insert_log_stock($data2);
				// INSERT LOG


				$users = $this->session->userdata('id');
				
				$ajax_data['ket_pengeluaran'] = $this->input->post('ket',TRUE);
				$ajax_data['biaya_pengeluaran'] = $this->input->post('biaya',TRUE);
				$ajax_data['id_user_pengeluaran'] = $users;

				if ($this->pengeluaran_model->update_entry($pengeluaranid, $ajax_data)) {
					
					echo json_encode(array("status" => TRUE));
				} else {
					echo json_encode(array("status" => FALSE));
				}
		
    }
    public function delete() {
    	if ($this->input->is_ajax_request()) {
    		$id = $this->input->post('id');
	    	$post = $this->pengeluaran_model->single_entry($id);
			$biaya_lama = $post->biaya_pengeluaran;
			$ket = $post->ket_pengeluaran;
			$biaya_lama_show = "Rp " . number_format($biaya_lama, 0, "", ",");

			unlink(APPPATH . '../assets/images/fotobukti/' . $post->imgbukti);

				if ($this->pengeluaran_model->delete_entry($id)) {
					// INSERT LOG
					
					$nama_users = $this->session->userdata('name');
					$b = '<b>'.$nama_users.'</b> Menghapus Pengeluaran Sebesar <b>'.$biaya_lama_show.'</b> Untuk Keperluan '.$ket;
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
		$allowed_image_extension = array(
	        "png",
	        "jpg",
	        "jpeg",
	        "webp",
	    );
	    $file_extension_picture_1 = pathinfo($_FILES["picture_1"]["name"], PATHINFO_EXTENSION);
	    $ket = $this->input->post('ket');
		if($this->input->post('ket') == '')
		{
			$data['inputerror'][] = 'ket';
			$data['error_string'][] = 'Form Keterangan harus berisi';
			$data['status'] = FALSE;
		}
		$ketlength= strlen($ket);
		if($ketlength < 3)
		{
			$data['inputerror'][] = 'ket';
			$data['error_string'][] = 'Keterangan Minimal 3 karakter';
			$data['status'] = FALSE;
		}
		if($this->input->post('biaya') == '')
		{
			$data['inputerror'][] = 'biaya';
			$data['error_string'][] = 'Form Biaya harus berisi';
			$data['status'] = FALSE;
		}
		if (empty($_FILES['picture_1']['name'])) {
			$data['inputerror'][] = 'picture_1';
			$data['error_string'][] = 'Form Upload Bukti harus berisi';
			$data['status'] = FALSE;
		}
		if (($_FILES["picture_1"]["size"] > 5000000)) {
			$data['inputerror'][] = 'picture_1';
			$data['error_string'][] = 'Image size maksimal 5MB';
			$data['status'] = FALSE;
	    }
	    if (!in_array($file_extension_picture_1, $allowed_image_extension)) {
	        $data['inputerror'][] = 'picture_1';
			$data['error_string'][] = 'Format File *jpg,png,jpeg,webp';
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
		$allowed_image_extension = array(
	        "png",
	        "jpg",
	        "jpeg",
	        "webp",
	        "",
	    );
	    $file_extension_picture_1 = pathinfo($_FILES["picture_1"]["name"], PATHINFO_EXTENSION);
    	$ket = $this->input->post('ket');
		if($this->input->post('ket') == '')
		{
			$data['inputerror'][] = 'ket';
			$data['error_string'][] = 'Form Keterangan harus berisi';
			$data['status'] = FALSE;
		}
		$ketlength= strlen($ket);
		if($ketlength < 3)
		{
			$data['inputerror'][] = 'ket';
			$data['error_string'][] = 'Keterangan Minimal 3 karakter';
			$data['status'] = FALSE;
		}
		if($this->input->post('biaya') == '')
		{
			$data['inputerror'][] = 'biaya';
			$data['error_string'][] = 'Form Biaya harus berisi';
			$data['status'] = FALSE;
		}
		
		if (($_FILES["picture_1"]["size"] > 5000000)) {
			$data['inputerror'][] = 'picture_1';
			$data['error_string'][] = 'Image size maksimal 5MB';
			$data['status'] = FALSE;
	    }
	    if (!in_array($file_extension_picture_1, $allowed_image_extension)) {
	        $data['inputerror'][] = 'picture_1';
			$data['error_string'][] = 'Format File *jpg,png,jpeg,webp';
			$data['status'] = FALSE;
	    }
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	


}