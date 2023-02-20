<?php
class Dashboard_model extends CI_Model{
    
    
    
    function laporan_statistics(){
        date_default_timezone_set('Asia/Jakarta');
        $bulan =date('m');
        
        $this->db->select("tbl_rekap_cash.*,SUM(IF(DATE_FORMAT(tgl_cash,'%d'), total_cash, 0)) AS totals,DATE_FORMAT(tgl_cash,'%d') AS tgl");
        $this->db->from('tbl_rekap_cash');
       
        $this->db->where ( 'month(tgl_cash)', $bulan);
        $this->db->group_by('date(tgl_cash)');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
    

    function count_all_visitors(){
        $query = $this->db->count_all('tbl_visitors');
        return $query;
    }
    function count_galon() {
            $query = $this->db->query("SELECT SUM(stock) AS galon FROM tbl_stock_produksi WHERE id_stock='2'");
            return $query;
    }
    function count_botol1500() {
            $query = $this->db->query("SELECT SUM(stock) AS botol1500 FROM tbl_stock_produksi WHERE id_stock='5'");
            return $query;
    }
    function count_botol600() {
            $query = $this->db->query("SELECT SUM(stock) AS botol600 FROM tbl_stock_produksi WHERE id_stock='4'");
            return $query;
    }
    function count_botol330() {
            $query = $this->db->query("SELECT SUM(stock) AS botol330 FROM tbl_stock_produksi WHERE id_stock='3'");
            return $query;
    }
    function count_cup() {
            $query = $this->db->query("SELECT SUM(stock) AS cup FROM tbl_stock_produksi WHERE id_stock='1'");
            return $query;
    }
    
    function count_mozilla_visitors(){
        $query = $this->db->query("SELECT COUNT(*) mozilla_visitor FROM tbl_visitors WHERE visit_platform='Firefox'");
        return $query;
    }
    function count_safari_visitors(){
        $query = $this->db->query("SELECT COUNT(*) safari_visitor FROM tbl_visitors WHERE visit_platform='Safari'");
        return $query;
    }
    function count_opera_visitors(){
        $query = $this->db->query("SELECT COUNT(*) opera_visitor FROM tbl_visitors WHERE visit_platform='Opera'");
        return $query;
    }
    function count_karyawan2(){
            $query = $this->db->query("SELECT COUNT(*) karyawan_count FROM tbl_user");
            return $query;
    }
    function count_produksihariini(){
        $query = $this->db->query("SELECT SUM(produksi_selesai_jumlah) AS produksihariini_count FROM tbl_produksi_selesai WHERE 
            MONTH(produksi_selesai_tgl)=MONTH(NOW())");
        return $query;
    }
    function count_transaksihariini(){
        $query = $this->db->query("SELECT SUM(jumlah_pembelian) AS transaksihariini_count FROM tbl_list_transaksi WHERE 
            MONTH(tgl_transaksi)=MONTH(NOW())");
        return $query;
    }

 
    function transaksi_count2() {
            $query = $this->db->query("SELECT SUM(total_cash) AS transaksi FROM tbl_rekap_cash WHERE DAY(tgl_cash)=DAY(NOW())");
            return $query;
    }
    function count_pengeluaran() {
            $query = $this->db->query("SELECT SUM(biaya_pengeluaran) AS pengeluaran_count FROM tbl_pengeluaran WHERE 
            MONTH(tgl_pengeluaran)=MONTH(NOW())");
            return $query;
    }
    function count_biayaproduksi() {
            $query = $this->db->query("SELECT SUM(produksi_selesai_biaya) AS biayaproduksi_count FROM tbl_produksi_selesai WHERE 
            MONTH(produksi_selesai_tgl)=MONTH(NOW())");
            return $query;
    }
    function pendapatan_kotor_count() {
            $query = $this->db->query("SELECT SUM(total_belanja) AS pendapatan_kotor FROM tbl_list_transaksi WHERE 
            MONTH(tgl_transaksi)=MONTH(NOW())");
            return $query;
    }
   

    
    
}