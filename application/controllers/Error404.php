<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Description of Controller
*
* @author https://aethershin.com
*/
class Error404 extends CI_Controller {
	function __construct(){
		parent::__construct();
		
	}
	function index(){
		if($this->session->userdata('logged') !=TRUE){
            
            $x['keterangan'] = 'Homepage';
            $x['link'] = 'login_user';
        } else {
        	$x['keterangan'] = 'Dashboard';
        	$x['link'] = 'backend/dashboard';
        }
		$this->load->view('errors/html/error_404',$x);
	}

	
}