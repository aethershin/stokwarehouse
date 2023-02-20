<?php
class Profil extends CI_Controller{
/**
* Description of Controller
*
* @author https://aethershin.com
*/	
	function __construct(){
		parent::__construct();
		error_reporting(0);
		if($this->session->userdata('logged') !=TRUE){
            $url=base_url('login_user');
            redirect($url);
        };
		$this->load->model('backend/Profil_setting_model','profil_setting_model');
		$this->load->model('Site_model','site_model');
		$this->load->library('upload');
		$this->load->helper('text');
		$this->load->helper('download');
		$this->load->library('form_validation');
	}

	function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $x['site_title'] = $site['site_title'];
        $x['site_favicon'] = $site['site_favicon'];
        $x['images'] = $site['images'];
        $x['title'] = 'Profil';
		$this->load->view('backend/menu',$x);
		$this->load->view('backend/_partials/templatejs');
		if($this->session->userdata('access')=='1') {
			if($this->session->userdata('access') != "1"){
				$url=base_url('login_user');
	            redirect($url);
			};
			
			
			$this->load->view('backend/v_profil_setting',$x);

		} else {
			$x['title'] = 'Profil';
			
			$this->load->view('backend/v_profil_setting_karyawan',$x);
		}
		
	}
	
	function get_detail_profil(){
		$id = $this->input->post('id');
		if($this->session->userdata('access')=='1') {
			$data = $this->profil_setting_model->get_detail_profil($id)->result();
	        echo json_encode($data);
		} else {
			$data = $this->profil_setting_model->get_detail_profil_peserta($id)->result();
	        echo json_encode($data);
		}
	        
    }

    function change() {
    		if($this->session->userdata('access') != "1"){
				$url=base_url('login_user');
	            redirect($url);
			};
    	$id = $this->input->post('id');
    	$user_name = $this->input->post('user_name');
    	$user_email = $this->input->post('user_email');
    				if (isset($_FILES["user_photo"]["name"])) {
			    		$config['upload_path'] = APPPATH . '../assets/images/profilusers/';
						$config['allowed_types'] = 'jpg|png|jpeg|webp';
						$config['max_size']     = '5056';
						$config['encrypt_name'] = TRUE;
					    $this->upload->initialize($config);
						
			    		if (!$this->upload->do_upload("user_photo")) {
				        	
    						echo $this->session->set_flashdata('msg','falied-change-image');
    						redirect('backend/profil');
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
					        $id = $this->input->post('id');
							$post = $this->profil_setting_model->single_entry($id);
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
							

							$ajax_data['user_name'] = $this->input->post('user_name');
							$ajax_data['user_email'] = $this->input->post('user_email');

							if ($this->profil_setting_model->update_entry($id, $ajax_data)) {
								$data = $this->profil_setting_model->get_detail_profil($id)->result();
        						echo json_encode($data);
							} else {
								$data = $this->profil_setting_model->get_detail_profil($id)->result();
        						echo json_encode($data);
							}
						} else {
							$ajax_data['user_name'] = $this->input->post('user_name');
							$ajax_data['user_email'] = $this->input->post('user_email');
							$ajax_data['user_password'] = MD5($this->input->post('password'));
							
							if ($this->profil_setting_model->update_entry($id, $ajax_data)) {
								$data = $this->profil_setting_model->get_detail_profil($id)->result();
        						echo json_encode($data);
							} else {
								$data = $this->profil_setting_model->get_detail_profil($id)->result();
        						echo json_encode($data);
							}
						}

    	
    	
    }
   
    

	
	


}