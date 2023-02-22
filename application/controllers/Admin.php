<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Description of Controller
*
* @author https://aethershin.com
*/
class Admin extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('backend/Login_model','login_model');
        
        $this->load->model('Site_model','site_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        error_reporting(0);
	}

	function index(){
        
        $data['form_username'] = form_input('','','name="username_cgtv_122021" id="username_cgtv_122021" class="form-control form-control-xl" placeholder="Email"');
        $data['form_password'] = form_password('','','name="password_cgtv_122021" id="inputPassword1" class="form-control form-control-xl" placeholder="Password"');
        $site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['title'] = 'Login Admin Stok Warehouse';
        $data['site_icon'] = $site['site_favicon'];
		$this->load->view('backend/v_login',$data);
        
	}

	function auth(){
        $this->form_validation->set_rules('username_cgtv_122021', 'Username', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('password_cgtv_122021', 'Password', 'trim|required|max_length[25]|xss_clean');
        
        
        if ($this->form_validation->run() == FALSE){
            $url=base_url('admin');
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Email atau Password Salah.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect($url);
        }else{
            $username_cgtv_122021=str_replace("'", "", htmlspecialchars($this->input->post('username_cgtv_122021',TRUE),ENT_QUOTES));
            $password_cgtv_122021=str_replace("'", "", htmlspecialchars($this->input->post('password_cgtv_122021',TRUE),ENT_QUOTES));

            $validate_us=$this->login_model->validasi_username($username_cgtv_122021);
            if($validate_us->num_rows() > 0){
                $validate_ps=$this->login_model->validasi_password($username_cgtv_122021,$password_cgtv_122021);
             	if($validate_ps->num_rows() > 0){
                    $validate_ca=$this->login_model->validasi_aktif($username_cgtv_122021,$password_cgtv_122021);
                    if($validate_ca->num_rows() > 0){
                    $this->session->set_userdata('logged',TRUE);
                 	$this->session->set_userdata('user',$u);
                 	$x = $validate_ps->row_array();

                 	if($x['user_level']=='1'){ //Administrator
                    	$this->session->set_userdata('access','1');
                    	$id=$x['user_id'];
                    	$name=$x['user_name'];
                        $level=$x['user_level'];
    					
                        $user_photo=$x['user_photo'];
                    	$this->session->set_userdata('id',$id);
                    	$this->session->set_userdata('name',$name);
                        $this->session->set_userdata('level',$level);
    					
                        $this->session->set_userdata('user_photo',$user_photo);
                    	redirect('backend/dashboard');
                   
                    
                 	}else{ 
                     	$url=base_url('admin');
                        echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Anda tidak diizinkan Login disini.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        redirect($url);
                 	}
                    }else{
                        $url=base_url('admin');
                        echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Akun ini dinonaktifkan.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        redirect($url);
                    }	
                }else{
                    $url=base_url('admin');
                    echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Password Salah.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    redirect($url);
                }

            }else{
            	$url=base_url('admin');
                echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Username Salah.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect($url);
            }
        }

    }
       
    function logout(){
        $this->session->sess_destroy();
        $url=base_url('admin');
        redirect($url);
    }
	
}
