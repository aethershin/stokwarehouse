<?php
class Diagram_dan_statistik extends CI_Controller{
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
		$this->load->model('backend/Download_data_model','download_data_model');
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
		$x['title'] = 'Diagram dan Statistik';

			// Riwayat Transaksi Cash Harian
			$laporan = $this->download_data_model->laporan_statistics();
			foreach($laporan as $result4){
	            $tgllaporan[] = 'Tgl '.$result4->tgl;
	            $valuelaporan[] = (float) $result4->totals;
	        }
	        $x['tgllaporan'] = json_encode($tgllaporan);
	        $x['valuelaporan'] = json_encode($valuelaporan);
			// Riwayat Transaksi Cash Harian


			// Riwayat Transaksi Cash Bulanan
			$laporanbulanan = $this->download_data_model->laporan_statistics_bulanan();
			foreach($laporanbulanan as $result5){
	            $tgllaporanbulanan[] = 'Bulan '.$result5->tgl;
	            $valuelaporanbulanan[] = (float) $result5->totals;
	        }
	        $x['tgllaporanbulanan'] = json_encode($tgllaporanbulanan);
	        $x['valuelaporanbulanan'] = json_encode($valuelaporanbulanan);
			// Riwayat Transaksi Cash Bulanan


			// Riwayat Transaksi Nota Harian
			$laporan_nota = $this->download_data_model->laporan_statistics_nota();
			foreach($laporan_nota as $result6){
	            $tgllaporan_nota[] = 'Tgl '.$result6->tgl;
	            $valuelaporan_nota[] = (float) $result6->totals;
	            $jumlahlaporan_nota[] = (float) $result6->jumlah;
	        }
	        $x['tgllaporan_nota'] = json_encode($tgllaporan_nota);
	        $x['jumlahlaporan_nota'] = json_encode($jumlahlaporan_nota);
	        $x['valuelaporan_nota'] = json_encode($valuelaporan_nota);
			// Riwayat Transaksi Nota Harian


			// Riwayat Transaksi Nota Bulanan
			$laporanbulanan_nota = $this->download_data_model->laporan_statistics_bulanan_nota();
			foreach($laporanbulanan_nota as $result7){
	            $tgllaporanbulanan_nota[] = 'Bulan '.$result7->tgl;
	            $valuelaporanbulanan_nota[] = (float) $result7->totals;
	            $jumlahlaporanbulanan_nota[] = (float) $result7->jumlah;
	        }
	        $x['tgllaporanbulanan_nota'] = json_encode($tgllaporanbulanan_nota);
	        $x['jumlahlaporanbulanan_nota'] = json_encode($jumlahlaporanbulanan_nota);
	        $x['valuelaporanbulanan_nota'] = json_encode($valuelaporanbulanan_nota);
			// Riwayat Transaksi Nota Bulanan


	        // Riwayat Pengeluaran Harian
			$pengeluaranharian = $this->download_data_model->pengeluaran_statistics();
			foreach($pengeluaranharian as $result8){
	            $tglpengeluaran[] = 'Tgl '.$result8->tgl;
	            $valuepengeluaran[] = (float) $result8->totals;
	        }
	        $x['tglpengeluaran'] = json_encode($tglpengeluaran);
	        $x['valuepengeluaran'] = json_encode($valuepengeluaran);
			// Riwayat Pengeluaran Harian

			// Riwayat Pengeluaran Bulanan
			$pengeluaranharian = $this->download_data_model->pengeluaran_bulanan_statistics();
			foreach($pengeluaranharian as $result9){
	            $tglpengeluaranbulanan[] = 'Bulan '.$result9->tgl;
	            $valuepengeluaranbulanan[] = (float) $result9->totals;
	        }
	        $x['tglpengeluaranbulanan'] = json_encode($tglpengeluaranbulanan);
	        $x['valuepengeluaranbulanan'] = json_encode($valuepengeluaranbulanan);
			// Riwayat Pengeluaran Bulanan

			// Stok Bahan
			$stokbahan = $this->download_data_model->stock_statistics();
			foreach($stokbahan as $result){
	            $namestok[] = $result->stk; 
	            $valuestok[] = (float) $result->jumlah;
	        }
	        $x['namestok'] = json_encode($namestok);
	        $x['valuestok'] = json_encode($valuestok);
			// Stok Bahan

			// Stok Produksi
			$produksi = $this->download_data_model->stock_produksi_statistics();
			foreach($produksi as $result2){
	            $namestokproduksi[] = $result2->stk; 
	            $valuestokproduksi[] = (float) $result2->jumlah;
	        }
	        $x['namestokproduksi'] = json_encode($namestokproduksi);
	        $x['valuestokproduksi'] = json_encode($valuestokproduksi);
			// Stok Produksi

			// Riwayat Produksi
			$riwayatproduksi = $this->download_data_model->riwayat_produksi_statistics();
			foreach($riwayatproduksi as $result3){
	            $tglriwayatproduksi[] = 'Tgl '.$result3->tgl;
	            $valueriwayatproduksi[] = (float) $result3->totals;

	            $jumlahriwayatproduksi[] = (float) $result3->jumlah;
	        }
	        $x['tglriwayatproduksi'] = json_encode($tglriwayatproduksi);
	        $x['jumlahriwayatproduksi'] = json_encode($jumlahriwayatproduksi);
	        $x['valueriwayatproduksi'] = json_encode($valueriwayatproduksi);
			// Riwayat Produksi


			// Riwayat Tambah
			$riwayattambahstok = $this->download_data_model->riwayat_tambah_stok_statistics();
			foreach($riwayattambahstok as $result11){
	            $tglriwayattambah[] = 'Tgl '.$result11->tgl;
	            $valueriwayattambah[] = (float) $result11->totals;
	            $jumlahriwayattambah[] = (float) $result11->jumlah;
	        }
	        $x['tglriwayattambah'] = json_encode($tglriwayattambah);
	        $x['jumlahriwayattambah'] = json_encode($jumlahriwayattambah);
	        $x['valueriwayattambah'] = json_encode($valueriwayattambah);
			// Riwayat Tambah



	        $stock_count = $this->download_data_model->stock_count();
			$row = $stock_count->row_array();
			$x['stock_today'] = $row['stock_today'];

			$nilai_saham_count = $this->download_data_model->nilai_saham_count();
			$row = $nilai_saham_count->row_array();
			$x['total_nilai_saham'] = $row['nilai_saham_count'];

			$stock_produksi_count = $this->download_data_model->stock_produksi_count();
			$row = $stock_produksi_count->row_array();
			$x['stock_produksi_today'] = $row['stock_produksi_today'];

			$stock_produksi_riwayat_count = $this->download_data_model->stock_produksi_riwayat_count();
			$row = $stock_produksi_riwayat_count->row_array();
			$x['stock_produksi_riwayat'] = $row['stock_produksi_riwayat'];

			$stock_produksi_biaya = $this->download_data_model->stock_produksi_riwayat_biaya();
			$row = $stock_produksi_biaya->row_array();
			$x['stock_produksi_biaya'] = $row['stock_produksi_biaya'];

			$jumlah_riwayat_tambah_stock = $this->download_data_model->jumlah_riwayat_tambah_stock();
			$row = $jumlah_riwayat_tambah_stock->row_array();
			$x['jumlah_riwayat_tambah_stock'] = $row['jumlahs'];

			$biaya_riwayat_tambah_stock = $this->download_data_model->biaya_riwayat_tambah_stock();
			$row = $biaya_riwayat_tambah_stock->row_array();
			$x['biaya_riwayat_tambah_stock'] = $row['biayas'];


			$transaksi_count2 = $this->download_data_model->transaksi_count_harian();
			$row = $transaksi_count2->row_array();
			$x['total_transaksi_harian'] = $row['transaksi'];

			$transaksi_bulanan = $this->download_data_model->transaksi_count_bulanan();
			$row = $transaksi_bulanan->row_array();
			$x['total_transaksi_bulanan'] = $row['transaksi'];

			$transaksi_count = $this->download_data_model->transaksi_count();
			$row = $transaksi_count->row_array();
			$x['total_nota_jumlah'] = $row['jumlah'];

			$transaksi_count2 = $this->download_data_model->transaksi_count2();
			$row = $transaksi_count2->row_array();
			$x['total_nota_transaksi'] = $row['transaksi'];


			$transaksi_count3 = $this->download_data_model->transaksi_count3();
			$row = $transaksi_count3->row_array();
			$x['total_nota_jumlah_bulanan'] = $row['jumlah'];

			$transaksi_count4 = $this->download_data_model->transaksi_count4();
			$row = $transaksi_count4->row_array();
			$x['total_nota_transaksi_bulanan'] = $row['transaksi'];

			$pengeluaran_count = $this->download_data_model->pengeluaran_count_harian();
			$row = $pengeluaran_count->row_array();
			$x['total_pengeluaran_harian'] = $row['transaksi'];

			$pengeluaran_bulanan = $this->download_data_model->pengeluaran_count_bulanan();
			$row = $pengeluaran_bulanan->row_array();
			$x['total_pengeluaran_bulanan'] = $row['transaksi'];

			$this->load->view('backend/menu',$x);
			$this->load->view('backend/_partials/templatejs');
		$this->load->view('backend/v_diagram_dan_statistik',$x);
	}
	

}