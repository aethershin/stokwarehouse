<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Description of Controller
*
* @author https://aethershin.com
*/
class Login_user extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('backend/Login_user_model','login_user_model');
        $this->load->model('Site_model','site_model');
        $this->load->model('Visitor_model','visitor_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->visitor_model->count_visitor();
        error_reporting(0);
    }

    function index(){
        
        $data['form_username'] = form_input('','','name="username_cgtv_122021" class="form-control form-control-xl" placeholder="Email"');
        $data['form_password'] = form_password('','','name="password_cgtv_122021" id="inputPassword1" class="form-control form-control-xl" placeholder="Password"');

        $site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_deskripsi'] = $site['site_deskripsi'];
        $data['site_icon'] = $site['site_favicon'];
        $data['title'] = 'Login Karyawan';
        $this->load->view('backend/v_login_user',$data);
        
    }

    function auth(){
        $this->form_validation->set_rules('username_cgtv_122021', 'Username', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('password_cgtv_122021', 'Password', 'trim|required|max_length[25]|xss_clean');
        
        
        if ($this->form_validation->run() == FALSE){
            $url=base_url('login_user');
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Email atau Password Salah.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect($url);
        }else{
            $username_cgtv_122021=str_replace("'", "", htmlspecialchars($this->input->post('username_cgtv_122021',TRUE),ENT_QUOTES));
            $password_cgtv_122021=str_replace("'", "", htmlspecialchars($this->input->post('password_cgtv_122021',TRUE),ENT_QUOTES));

            $validate_us=$this->login_user_model->validasi_username($username_cgtv_122021);
            if($validate_us->num_rows() > 0){
                $validate_ps=$this->login_user_model->validasi_password($username_cgtv_122021,$password_cgtv_122021);
                if($validate_ps->num_rows() > 0){
                    $validate_ca=$this->login_user_model->validasi_aktif($username_cgtv_122021,$password_cgtv_122021);
                    if($validate_ca->num_rows() > 0){
                    $this->session->set_userdata('logged',TRUE);
                    $this->session->set_userdata('user',$u);
                    $x = $validate_ps->row_array();

                        if($x['user_level']=='2'){ //Peserta
                            $this->session->set_userdata('access','2');
                            $id=$x['user_id'];
                            $name=$x['user_name'];
                            $level=$x['user_level'];
                            $user_photo=$x['user_photo'];
                            $this->session->set_userdata('id',$id);
                            $this->session->set_userdata('name',$name);
                            $this->session->set_userdata('level',$level);
                            $this->session->set_userdata('user_photo',$user_photo);
                            redirect('backend/dashboard');

                        } else if ($x['user_level']=='3') {
                            $this->session->set_userdata('access','3');
                            $id=$x['user_id'];
                            $name=$x['user_name'];
                            $level=$x['user_level'];
                            $user_photo=$x['user_photo'];
                            $this->session->set_userdata('id',$id);
                            $this->session->set_userdata('name',$name);
                            $this->session->set_userdata('level',$level);
                            $this->session->set_userdata('user_photo',$user_photo);
                            redirect('backend/dashboard');
                        } else if ($x['user_level']=='4') {
                            $this->session->set_userdata('access','4');
                            $id=$x['user_id'];
                            $name=$x['user_name'];
                            $level=$x['user_level'];
                            $user_photo=$x['user_photo'];
                            $this->session->set_userdata('id',$id);
                            $this->session->set_userdata('name',$name);
                            $this->session->set_userdata('level',$level);
                            $this->session->set_userdata('user_photo',$user_photo);
                            redirect('backend/dashboard');
                        } else { 
                            $url=base_url('login_user');
                            echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Anda tidak diizinkan Login disini.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            redirect($url);
                        }
                    }else{
                        $url=base_url('login_user');
                        echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Akun ini belum diaktifkan.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        redirect($url);
                    }   
                }else{
                    $url=base_url('login_user');
                    echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Password Salah.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    redirect($url);
                }

            }else{
                $url=base_url('login_user');
                echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Username Salah.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect($url);
            }
        }
    }
    // RESET PASSWORD
    public function reset_password_email()
    {
        $site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_deskripsi'] = $site['site_deskripsi'];
        $data['site_icon'] = $site['site_favicon'];
        $data['title'] = 'Reset Password';
        
        $data['form_username'] = form_input('','','name="email" class="form-control form-control-xl" placeholder="Email" data-validate = "Valid email is required: ex@abc.xyz"');
        $this->load->view('reset_password_email',$data);
    } 
    
    public function validate()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $site = $this->site_model->get_site_data()->row_array();
            $data['site_title'] = $site['site_title'];
            $data['site_deskripsi'] = $site['site_deskripsi'];
            $data['site_icon'] = $site['site_favicon'];
            $data['title'] = 'Reset Password';
            $url=base_url('reset');
                echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Email Address belum diisi.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect($url);
        } else {
            $email = $this->input->post('email');
            $clean = $this->security->xss_clean($email);
            $userInfo = $this->login_user_model->getUserInfoByEmail($clean);

            if (!$userInfo) {
                $url=base_url('reset');
                echo $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible show fade">Email Address salah atau Akun belum Diaktifkan.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect($url);
            }

            //build token   

            

            
            
            
                            
                $this->load->library('email');
                $config = array();
                $config['charset'] = 'utf-8';
                $config['useragent'] = 'Codeigniter';
                $config['protocol']= "smtp";
                $config['mailtype']= "html";
                $config['smtp_host']= "facebook.com";// Isi Link Website Ex*(facebook.com)
                $config['smtp_port']= "587";
                $config['smtp_timeout']= "5";
                $config['smtp_user']= "teamadmin@facebook.com"; // isi dengan email Account
                $config['smtp_pass']= "@d1s1n1s3n4n9"; // isi dengan password kamu
                $config['crlf']="\r\n"; 
                $config['newline']="\r\n"; 
                $config['wordwrap'] = TRUE;
                //memanggil library email dan set konfigurasi untuk pengiriman email
                    
                $this->email->initialize($config);
                //konfigurasi pengiriman
                $this->email->from($config['smtp_user']);
                $this->email->to($this->input->post('email'));
                $this->email->subject("Reset your password");
                
            $token = $this->login_user_model->insertToken($userInfo->user_id);
            $qstring = $this->base64url_encode($token);
            $url = 'https://stokwarehouse.kayalamasu.com/login_user/reset_password/token/' . $qstring;
            $link = '<a href="' . $url . '">' . $url . '</a>';

            $message = '';
            $message .= '<strong><h2>ADMIN STOK WAREHOUSE</h2></strong><br>';
            $message .= '<strong><p>Klik Link Dibawah ini untuk reset Password anda.</p></strong><br>';
            $message .= '<strong>Mohon untuk tidak Menyebarkan Link Berikut kepada orang yang tidak dikenal</strong><br>';
            $message .= '<strong>Silakan klik link ini:</strong> ' . $link;
                
                $this->email->message($message);
                if($this->email->send())
                {
                    $this->session->set_flashdata('msg','<div class="alert alert-success">Email Berhasil dikirim, Silahkan Cek Email Anda</div>');
                    redirect('reset');
                }else
                {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert"> Gagal Mengirim Email</div>');
                    redirect('reset');
                }
        }
    }

    public function reset_password()
    {
        $token = $this->base64url_decode($this->uri->segment(4));
        $cleanToken = $this->security->xss_clean($token);

        $user_info = $this->login_user_model->isTokenValid($cleanToken); //either false or array();          

        if (!$user_info) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert"> Token Sudah Kadaluarsa, Silahkan Kirim Ulang</div>');
            redirect(site_url('reset'), 'refresh');
        }

        $data = array(
            'user_id' => $user_info->user_id,
            'nama' => $user_info->user_name,
            'email' => $user_info->user_email,
            'token' => $this->base64url_encode($token)
        );

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
        $site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_deskripsi'] = $site['site_deskripsi'];
        $data['site_icon'] = $site['site_favicon'];
        $data['title'] = 'Atur Ulang Password';
        $data['form_password'] = form_password('','','name="new_password" id="inputPassword1" class="form-control form-control-xl" placeholder="New Password"');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('reset_password', $data);
        } else {

            
        }
    }

    public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
    
    public function retype_password()
    {
        $site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_deskripsi'] = $site['site_deskripsi'];
        $data['site_icon'] = $site['site_favicon'];
        $data['title'] = 'Reset Password';
        
        $this->load->view('reset_password',$data);
    } 
    function change(){
        
            $user_id = $this->input->post('user_id');
            $new_password = htmlspecialchars($this->input->post('new_password',TRUE),ENT_QUOTES);
            
            
            $new_pass = md5($new_password);
            
                    $this->login_user_model->change_password($user_id,$new_pass);
                    $this->login_user_model->delete_token($user_id);
                    $this->session->set_flashdata('msg','<div class="alert alert-success">Password anda telah berubah, Silahkan Login Ulang</div>');
                    redirect('login_user');
                
        
    }
    // RESET PASSWORD

    function logout_user(){
        $this->session->sess_destroy();
        $url=base_url('login_user');
        redirect($url);
    }
    
}