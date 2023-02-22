<?php
class Backupdata extends CI_Controller{
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
		
		$this->load->model('Site_model','site_model');
		$this->load->helper('text');
		$this->load->helper('url');
	}

	public function index(){
		$this->load->dbutil();

		$prefs = array(     
		    'format'      => 'zip',             
		    'filename'    => 'my_db_backup.sql'
		    );


		$backup =& $this->dbutil->backup($prefs); 
		date_default_timezone_set('Asia/Jakarta');
		$db_name = 'backup-on-'. date("Y-m-d_|_H-i-a") .'.zip';
		$save = 'pathtobkfolder/'.$db_name;

		$this->load->helper('file');
		write_file($save, $backup); 


		$this->load->helper('download');
		force_download($db_name, $backup);
	}
	

}