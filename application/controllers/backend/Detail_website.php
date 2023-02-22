<?php
class Detail_website extends CI_Controller{
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
		$this->load->model('backend/Detail_website_model','detail_website_model');
		$this->load->model('Site_model','site_model');
		$this->load->library('upload');
		$this->load->helper('text');
	}

	function index(){
		
		$site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_favicon'] = $site['site_favicon'];
        $data['images'] = $site['images'];
		$data['title'] = 'Detail Website';
		$this->load->view('backend/menu',$data);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_detail_website',$data);
		
	}
	function get_detail_website(){
		
        $data = $this->detail_website_model->get_detail_website()->result();
        echo json_encode($data);
    }

    function change(){
		
		$config['upload_path'] = APPPATH . '../assets/images/logo/';
	    $config['allowed_types'] = 'jpg|png|jpeg|webp';
	    $config['encrypt_name'] = TRUE;
	    $this->upload->initialize($config);
	       	if(isset($_FILES['user_photo']['name'])){
	       		
	       		if ($this->upload->do_upload('user_photo')){
		            $filefotoheader = $this->upload->data();
		            $bg_header=$filefotoheader['file_name'];
		        } 
		        $id = $this->input->post('id');
				$post = $this->detail_website_model->single_entry($id);
				unlink(APPPATH . '../assets/images/logo/' . $post->images);
				$ajax_data['images'] = $bg_header; 
			}
			if(isset($_FILES['img_favicon']['name'])){

		        if ($this->upload->do_upload('img_favicon')){
		            $filefotofavicon = $this->upload->data();
		            $bg_favicon=$filefotofavicon['file_name'];
		        }
		        $id = $this->input->post('id');
				$post = $this->detail_website_model->single_entry($id);
				unlink(APPPATH . '../assets/images/logo/' . $post->site_favicon);
				$ajax_data['site_favicon'] = $bg_favicon; 
			}
			$id = $this->input->post('id');
			$ajax_data['site_title'] = $this->input->post('site_title');
			$ajax_data['email'] = $this->input->post('email');
			$ajax_data['site_deskripsi'] = $this->input->post('site_deskripsi');
			$ajax_data['notelp'] = $this->input->post('notelp');
			$ajax_data['nama_kontak'] = $this->input->post('nama_kontak');
			$ajax_data['facebook'] = $this->input->post('facebook');
			$ajax_data['instagram'] = $this->input->post('instagram');
			$ajax_data['youtube'] = $this->input->post('youtube');
			$ajax_data['telegram'] = $this->input->post('telegram');
			$ajax_data['alamat_universitas'] = $this->input->post('alamat_universitas');


			if ($this->detail_website_model->update_entry($id, $ajax_data)) {
				$data = $this->detail_website_model->get_detail_website()->result();
				echo json_encode($data);
			} else {
				$data = $this->detail_website_model->get_detail_website()->result();
				echo json_encode($data);
			}
	}

    
	
    

	
	


}