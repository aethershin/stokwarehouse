<?php
class Dashboard extends CI_Controller{
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
		$this->load->model('backend/Dashboard_model', 'dashboard_model');
		$this->load->model('backend/Download_data_model','download_data_model');
		$this->load->model('Site_model','site_model');
		
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->library('upload');
	}
	function index(){

		

		$site = $this->site_model->get_site_data()->row_array();
        $data['site_title'] = $site['site_title'];
        $data['site_favicon'] = $site['site_favicon'];
        $data['images'] = $site['images'];
        $data['title'] = 'Dashboard';
        
		if($this->session->userdata('access')=='1') {
			if($this->session->userdata('access') != "1"){
				$url=base_url('login_user');
	            redirect($url);
			};
			// Riwayat Transaksi
			$laporan = $this->dashboard_model->laporan_statistics();
			foreach($laporan as $result4){
	            $tgllaporan[] = 'Tgl '.$result4->tgl;
	            $valuelaporan[] = (float) $result4->totals;
	        }
	        $data['tgllaporan'] = json_encode($tgllaporan);
	        $data['valuelaporan'] = json_encode($valuelaporan);
			// Riwayat Transaksi
	        // Stok Produksi
			$produksi = $this->download_data_model->stock_produksi_statistics();
			foreach($produksi as $result2){
	            $namestokproduksi[] = $result2->stk; 
	            $valuestokproduksi[] = (float) $result2->jumlah;
	        }
	        $data['namestokproduksi'] = json_encode($namestokproduksi);
	        $data['valuestokproduksi'] = json_encode($valuestokproduksi);
			// Stok Produksi
			
			$produksihariini_count = $this->dashboard_model->count_produksihariini();
				$row = $produksihariini_count->row_array();
				$data['produksihariini'] = $row['produksihariini_count'];
			$transaksihariini_count = $this->dashboard_model->count_transaksihariini();
				$row = $transaksihariini_count->row_array();
				$data['transaksihariini'] = $row['transaksihariini_count'];

			$transaksi_count2 = $this->dashboard_model->transaksi_count2();
				$row = $transaksi_count2->row_array();
				$data['total_transaksi'] = $row['transaksi'];
			// Perhitungan Laba
			$biayaproduksi_count = $this->dashboard_model->count_biayaproduksi();
				$row = $biayaproduksi_count->row_array();
				$biayaproduksi = $row['biayaproduksi_count'];	
				$data['biaya_produksi'] = $row['biayaproduksi_count'];
	        $pendapatan_kotor_count = $this->dashboard_model->pendapatan_kotor_count();
				$row = $pendapatan_kotor_count->row_array();
				$pendapatan_kotor = $row['pendapatan_kotor'];
				$data['pendapatan_kotor'] = $row['pendapatan_kotor'];
			$pengeluaran_count = $this->dashboard_model->count_pengeluaran();
				$row = $pengeluaran_count->row_array();
				$pengeluaran = $row['pengeluaran_count'];
				$data['pengeluaran'] = $row['pengeluaran_count'];
				$data['pendapatan_bersih'] = $pendapatan_kotor-$biayaproduksi-$pengeluaran;
			
				$this->load->view('backend/menu',$data);
        		$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_dashboard',$data);
		} else {
			
			
	        $data['title'] = 'Dashboard';
	        	$this->load->view('backend/menu',$data);
        		$this->load->view('backend/_partials/templatejs');
			$this->load->view('backend/v_dashboard_karyawan',$data);
		}
		
		
		
	}
	function get_data(){
        $data = $this->dashboard_model->get_all_transaksi_list()->result();
        echo json_encode($data);
    }
   	

}