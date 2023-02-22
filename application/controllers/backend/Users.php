<?php
class Users extends CI_Controller{

	function __construct(){
		parent::__construct();
		error_reporting(0);
		if($this->session->userdata('access') != "1"){
			$url=base_url('login_user');
            redirect($url);
		};
		$this->load->model('backend/Users_model','users_model');
		$this->load->model('Site_model','site_model');
		$this->load->library('upload');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('form');
		
	}

	public function index()
	{
		$site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_favicon'] = $site['site_favicon'];
        $data['images'] = $site['images'];
		$data['title'] = 'Users Karyawan';
		$data['jsonfilepstudi'] = json_decode($getfilepstudi);
		$this->load->view('backend/menu',$data);
		$this->load->view('backend/modal/user_modal');
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_users', $data);
	}
	
	
  	public function get_ajax_list()
	{

		$list = $this->users_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$status = $d->user_status;
			$level = $d->user_level;
			if ($status == 1) {
				$class = 'lock';
				$ket = 'Lock User';
				$icon = 'check';
				$actket = 'Aktif';
				$actclass = 'success';
			} else {
				$class = 'unlock';
				$ket = 'Unlock User';
				$icon = 'exclamation';
				$actket = 'Nonaktif';
				$actclass = 'danger';
			}
			if($level == 1) {
				$ket_level = 'Admin';

			} else if($level == 2) {
				$ket_level = 'Warehouse';

			} else if ($level == 3) {
				$ket_level = 'Ekspedisi';
			} else {
				$ket_level = 'Karyawan';
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<div class='avatar avatar-lg me-3'><img alt='Image' src='../assets/images/profilusers/$d->user_photo' width=50></div>";
			$row[] = $d->user_email;
			$row[] = $d->user_name;
			$row[] = $ket_level;
			
			$row[] = '<div class="alert alert-light-'.$actclass.' color-'.$actclass.'"><i class="bi bi-'.$icon.'-circle"></i> '.$actket.'</div>';
			
			$row[] = '<div class="btn-group mb-1"><div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton7"><a class="dropdown-item" href="javascript:void()" title="Edit" onclick="edit_person('."'".$d->user_id."'".')"><i class="bi bi-pen-fill"></i> Edit</a>
				<a class="dropdown-item" href="javascript:void()" title="Lock" id="lock" value="'.$d->user_id.'"><i class="bi bi-'.$class.'"></i> '.$ket.'</a>
				<a class="dropdown-item delete_record" href="javascript:void()" title="Hapus" id="del" value="'.$d->user_id.'"><i class="bi bi-trash"></i> Hapus</a></div></div></div>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->users_model->count_all(),
						"recordsFiltered" => $this->users_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	

	public function ajax_edit($user_id)
	{
		$data = $this->users_model->get_by_id($user_id);
		echo json_encode($data);
	}
	function add(){
		
		$this->_validate();
		$config['upload_path'] = './assets/images/profilusers/'; //path folder
		$config['allowed_types'] = 'jpg|png|jpeg|webp';
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);

	        if(!empty($_FILES['user_photo']['name'])){
		    	if ($this->upload->do_upload('user_photo')){
		            $filefotoprofil = $this->upload->data();
		            $bg_filefotoprofil=$filefotoprofil['file_name'];
		        }

				$data = array(
					'user_name' => $this->input->post('nama'),
					'user_email' => $this->input->post('email'),
					'user_password' => MD5($this->input->post('password')),
					'user_level' => $this->input->post('level'),
					'user_status' => '1',
					'user_photo' => $bg_filefotoprofil,
				);
				$insert = $this->users_model->insert_users($data);
				if($insert){
					echo json_encode(array("status" => TRUE));
				}else{
					echo json_encode(array("status" => FALSE));
				}
			} else {
				

				$data = array(
					'user_name' => $this->input->post('nama'),
					'user_email' => $this->input->post('email'),
					'user_password' => MD5($this->input->post('password')),
					'user_level' => $this->input->post('level'),
					'user_status' => '1',
					'user_photo' => 'user_blank.webp',
				);
				$insert = $this->users_model->insert_users($data);
				if($insert){
					echo json_encode(array("status" => TRUE));
				}else{
					echo json_encode(array("status" => FALSE));
				}
			}
		
	}


	function edit(){
		
		
		$userid=$this->input->post('id',TRUE);
		
		$this->_validate_edit();
		
			    	if (isset($_FILES["user_photo"]["name"])) {
			    		$config['upload_path'] = './assets/images/profilusers/'; //path folder
						$config['allowed_types'] = 'jpg|png|jpeg|webp';
						$config['encrypt_name'] = TRUE;
					    $this->upload->initialize($config);
			    		if (!$this->upload->do_upload("user_photo")) {
				        	echo json_encode(array("status" => FALSE));
						} else {
				            $gbr = $this->upload->data();
			                //Compress Image

			                $config['image_library']='gd2';
							$config['source_image'] = APPPATH . '../assets/images/profilusers/'.$gbr['file_name'];
					        $config['create_thumb']= FALSE;
					        $config['maintain_ratio']= FALSE;
					        $config['quality']= '100%';
					        $config['new_image'] = APPPATH . '../assets/images/profilusers/'.$gbr['file_name'];
					        $this->load->library('image_lib', $config);
					        $this->image_lib->resize();

					        $gambar=$gbr['file_name'];
					        $user_id = $this->input->post('id');
							$post = $this->users_model->single_entry($user_id);
							$check = $post->user_photo;
							if ($check == 'user_blank.webp') {
								// Tidak hapus user_blank.webp
							} else {
								unlink(APPPATH . '../assets/images/profilusers/' . $post->user_photo);
							}
							$ajax_data['user_photo'] = $gambar;
						
				        }      
				    }
				    			
				    $pass = $this->input->post('password');
					$conf_pass = $this->input->post('conf_pass');
						if(empty($pass) || empty($conf_pass)){
							

							$ajax_data['user_name'] = $this->input->post('nama');
							$ajax_data['user_email'] = $this->input->post('email');
							$ajax_data['user_level'] = $this->input->post('level');
							if ($this->users_model->update_entry($userid, $ajax_data)) {
								echo json_encode(array("status" => TRUE));
							} else {
								echo json_encode(array("status" => FALSE));
							}
						} else {
							$ajax_data['user_name'] = $this->input->post('nama');
							$ajax_data['user_email'] = $this->input->post('email');
							$ajax_data['user_level'] = $this->input->post('level');
							$ajax_data['user_password'] = MD5($this->input->post('password'));
							
							if ($this->users_model->update_entry($userid, $ajax_data)) {
								echo json_encode(array("status" => TRUE));
							} else {
								echo json_encode(array("status" => FALSE));
							}
						}
	}
	

	
	
	public function delete()
	{
		if ($this->input->is_ajax_request()) {

			$user_id = $this->input->post('user_id');

			$post = $this->users_model->single_entry($user_id);
			if ($post->user_photo == 'user_blank.webp') {

				

				if ($this->users_model->delete_entry($user_id)) {
					$data = array('res' => "success", 'message' => "Data berhasil dihapus");
				} else {
					$data = array('res' => "error", 'message' => "Delete query error");
				}
			} else {


				unlink(APPPATH . '../assets/images/profilusers/' . $post->user_photo);

				

				if ($this->users_model->delete_entry($user_id)) {
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
    
    public function lock()
	{
		if ($this->input->is_ajax_request()) {

			$user_id = $this->input->post('user_id');

			$post = $this->users_model->single_entry($user_id);
			if ($post->user_status == 1) {

				$ajax_data['user_status'] = 0;
							
				if ($this->users_model->update_lock($user_id, $ajax_data)) {
					$data = array('res' => "success", 'message' => "Proses berhasil dilakukan");
				} else {
					$data = array('res' => "error", 'message' => "Proses gagal dilakukan");
				}

				
			} else {
				$ajax_data['user_status'] = 1;
							
				if ($this->users_model->update_lock($user_id, $ajax_data)) {
					$data = array('res' => "success", 'message' => "Proses berhasil dilakukan");
				} else {
					$data = array('res' => "error", 'message' => "Proses gagal dilakukan");
				}
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
	        "",
	    );
	    $file_extension_picture_1 = pathinfo($_FILES["user_photo"]["name"], PATHINFO_EXTENSION);
		$nama=htmlspecialchars($this->input->post('nama',TRUE),ENT_QUOTES);
		$email=htmlspecialchars($this->input->post('email',TRUE),ENT_QUOTES);
		$pass=htmlspecialchars($this->input->post('password',TRUE),ENT_QUOTES);
		$conf_pass=htmlspecialchars($this->input->post('conf_pass',TRUE),ENT_QUOTES);
		$cek_email = $this->users_model->validasi_email($email);
	    if($cek_email->num_rows() > 0){
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Duplikat Email';
			$data['status'] = FALSE;
	    }else{
	    	if($pass == $conf_pass){
	    		$data['status'] = TRUE;
	    	} else {
	    		$data['inputerror'][] = 'conf_pass';
				$data['error_string'][] = 'Password Tidak Sama';
				$data['status'] = FALSE;
	    		
	    	}
	    }
		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Form Email harus berisi';
			$data['status'] = FALSE;
		}
		

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Form Password harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('conf_pass') == '')
		{
			$data['inputerror'][] = 'conf_pass';
			$data['error_string'][] = 'Form Konfirmasi Password harus berisi';
			$data['status'] = FALSE;
		}
		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Form Tipe Akun harus berisi';
			$data['status'] = FALSE;
		}
		
		if (($_FILES["user_photo"]["size"] > 5000000)) {
			$data['inputerror'][] = 'user_photo';
			$data['error_string'][] = 'Image size maksimal 5MB';
			$data['status'] = FALSE;
	    }
	    if (!in_array($file_extension_picture_1, $allowed_image_extension)) {
	        $data['inputerror'][] = 'user_photo';
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
	    $file_extension_picture_1 = pathinfo($_FILES["user_photo"]["name"], PATHINFO_EXTENSION);
		$userid=$this->input->post('id',TRUE);
		$email=$this->input->post('email');
		$pass=htmlspecialchars($this->input->post('password',TRUE),ENT_QUOTES);
		$conf_pass=htmlspecialchars($this->input->post('conf_pass',TRUE),ENT_QUOTES);
		
		$cek_email = $this->users_model->validasi_email($email);
	    if($cek_email->num_rows() > 0){
	    	$row = $cek_email->row();
	    	$user_id = $row->user_id;
	    	if($user_id <> $userid){
	    		$data['inputerror'][] = 'email';
				$data['error_string'][] = 'Duplikat Email';
				$data['status'] = FALSE;
	    	}else{
	    		if($pass == $conf_pass){
	    			$data['status'] = TRUE;
		    	} else {
		    		$data['inputerror'][] = 'conf_pass';
					$data['error_string'][] = 'Password Tidak Sama';
					$data['status'] = FALSE;
		    	}
	    	}
	    } else {
    		if($pass == $conf_pass){
    			$data['status'] = TRUE;
	    	} else {
	    		$data['inputerror'][] = 'conf_pass';
				$data['error_string'][] = 'Password Tidak Sama';
				$data['status'] = FALSE;
	    		
	    	}
	    }


		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Form Nama harus berisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Form Email harus berisi';
			$data['status'] = FALSE;
		}
		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Form Tipe Akun harus berisi';
			$data['status'] = FALSE;
		}
		if (($_FILES["user_photo"]["size"] > 5000000)) {
			$data['inputerror'][] = 'user_photo';
			$data['error_string'][] = 'Image size maksimal 5MB';
			$data['status'] = FALSE;
	    }
	    if (!in_array($file_extension_picture_1, $allowed_image_extension)) {
	        $data['inputerror'][] = 'user_photo';
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