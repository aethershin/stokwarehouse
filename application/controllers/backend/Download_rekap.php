<?php
class Download_rekap extends CI_Controller{
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
		$this->load->model('backend/Download_rekap_model','download_rekap_model');
		$this->load->model('Site_model','site_model');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->helper('tanggal');
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $x['site_title'] = $site['site_title'];
        $x['site_favicon'] = $site['site_favicon'];
        $x['images'] = $site['images'];
		$x['title'] = 'Download Rekap';
		$this->load->view('backend/menu',$x);
		
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_download_rekap',$x);
	}
	function download_excel_rekap_setoran() {
		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		$x['dari'] = $dari;
		$x['sampai'] = $sampai;
		$x['data'] = $this->download_rekap_model->get_all_excel_rekap_setoran($dari,$sampai);
		$this->load->view('backend/v_download_rekap_setoran',$x);
	}
	function download_excel_rekap_nota() {
		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		$x['dari'] = $dari;
		$x['sampai'] = $sampai;
		$x['data'] = $this->download_rekap_model->get_all_excel_rekap_nota($dari,$sampai);
		$this->load->view('backend/v_download_rekap_nota',$x);
	}
	function download_excel_rekap_pengeluaran() {
		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		$x['dari'] = $dari;
		$x['sampai'] = $sampai;
		$x['data'] = $this->download_rekap_model->get_all_excel_rekap_pengeluaran($dari,$sampai);
		$this->load->view('backend/v_download_rekap_pengeluaran',$x);
	}
	function download_excel_rekap_tim_produksi() {
		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		$x['dari'] = $dari;
		$x['sampai'] = $sampai;
		$x['data'] = $this->download_rekap_model->get_all_excel_rekap_tim_produksi($dari,$sampai);
		$this->load->view('backend/v_download_rekap_tim_produksi',$x);
	}
	function download_excel_rekap_tambah_stok() {
		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		$x['dari'] = $dari;
		$x['sampai'] = $sampai;
		$x['data'] = $this->download_rekap_model->get_all_excel_rekap_tambah_stok($dari,$sampai);
		$this->load->view('backend/v_download_rekap_tambah_stok',$x);
	}
	function download_excel_rekap_stok_bahan_warehouse() {
		$x['data'] = $this->download_rekap_model->get_all_excel_rekap_stok_bahan_warehouse();
		$this->load->view('backend/v_download_rekap_stok_bahan_warehouse',$x);
	}
	function download_excel_rekap_stok_produk_ready_sale() {
		$x['data'] = $this->download_rekap_model->get_all_excel_rekap_stok_produk_ready_sale();
		$this->load->view('backend/v_download_rekap_stok_produk_ready_sale',$x);
	}


}