<?php
class Log extends CI_Controller{
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
		$this->load->model('backend/Log_model','log_model');
		$this->load->model('Site_model','site_model');
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('tanggal');
	}

	public function index(){
		$site = $this->site_model->get_site_data()->row_array();
        $x['site_title'] = $site['site_title'];
        $x['site_favicon'] = $site['site_favicon'];
        $x['images'] = $site['images'];
		$x['title'] = 'Log Aktivitas User';
		$this->load->view('backend/menu',$x);
		$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_log',$x);
	}
	public function get_ajax_list()
	{
		$list = $this->log_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $d) {
			$ket = $d->ket;

			$row = array();
			if(stripos($ket, 'Produksi Barang') !== FALSE){
				$icon = '<i class="bi bi-puzzle"></i>';
			} else if(stripos($ket, 'Tambah Konsumen') !== FALSE) {
				$icon = '<i class="bi bi-person-plus-fill"></i>';
			} else if(stripos($ket, 'Transaksi Cash') !== FALSE) {
				$icon = '<i class="bi bi-cash-coin"></i>';
			} else if(stripos($ket, 'Transaksi Cicil') !== FALSE) {
				$icon = '<i class="bi bi-cart-check"></i>';
			} else if(stripos($ket, 'Transaksi Titip') !== FALSE) {
				$icon = '<i class="bi bi-box"></i>';
			} else if(stripos($ket, 'Mengkonfirmasi Pembayaran Cicilan') !== FALSE) {
				$icon = '<i class="bi bi-coin"></i>';
			} else if(stripos($ket, 'Melakukan Setor Pembayaran Titip') !== FALSE) {
				$icon = '<i class="bi bi-coin"></i>';
			} else if(stripos($ket, 'Absen') !== FALSE) {
				$icon = '<i class="bi bi-person-check-fill"></i>';
			} else if(stripos($ket, 'Penambahan Stock Material') !== FALSE) {
				$icon = '<i class="bi bi-graph-up"></i>';
			} else if(stripos($ket, 'Material Rusak') !== FALSE) {
				$icon = '<i class="bi bi-puzzle"></i>';
			} else if(stripos($ket, 'Pengeluaran') !== FALSE) {
				$icon = '<i class="bi bi-cash-coin"></i>';
			} else if(stripos($ket, 'Material') !== FALSE) {
				$icon = '<i class="bi bi-box"></i>';
			} else if(stripos($ket, 'Stok Bahan') !== FALSE) {
				$icon = '<i class="bi bi-box"></i>';
			} else if(stripos($ket, 'Membuat Surat jalan') !== FALSE) {
				$icon = '<i class="bi bi-files"></i>';
			} else if(stripos($ket, 'Mengkonfirmasi Pembatalan Pembayaran Cicilan') !== FALSE) {
				$icon = '<i class="bi bi-recycle"></i>';
			} else if(stripos($ket, 'Edit Produk Ready Sale') !== FALSE) {
				$icon = '<i class="bi bi-box"></i>';
			} else if(stripos($ket, 'Pembatalan Nota Transaksi') !== FALSE) {
				$icon = '<i class="bi bi-trash"></i>';
			} else {
				$icon = '<i class="bi bi-gear"></i>';
			}
			$row[] = $d->ket;
			$row[] = $icon;
			$row[] = format_indo(date($d->tgl_log));
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->log_model->count_all(),
						"recordsFiltered" => $this->log_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	


}