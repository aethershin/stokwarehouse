
<div class="page-content">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="card-header">
                                <div class="col-12">
                                <h5>Total Setoran Harian :<?php echo "Rp. " . number_format($total_transaksi_harian, 0, "", ","); ?></h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="linelaporankeuangan"></div>
                            </div>
                            
                             
                                
                        </div>
                    </div>
                
                    </div>
                </div>
            
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                            <div class="row">
                                <div class="card-header">
                                    <div class="col-12">
                                        <h5>Total Setoran Bulanan :<?php echo "Rp. " . number_format($total_transaksi_bulanan, 0, "", ","); ?></h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="linelaporankeuanganbulanan"></div>
                                </div>
                               
                                
                            </div>
                
                    </div>
                </div>
            </div>
            <!-------------------------------------------------------------------------->
            <div class="col-12 col-md-12">
                <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="col-12">
                            <h4>Transaksi Nota Harian</h4>
                        </div>
                    </div>
                   
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5>Total Transaksi Nota Harian :<?php echo "Rp. " . number_format($total_nota_transaksi, 0, "", ","); ?></h5>
                                    
                                </div>
                                <div class="col-12">
                                    <div id="linelaporankeuangan_nota"></div>
                                </div>
                               
                             
                                
                            </div>
                
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="col-12">
                            <h4>Transaksi Nota Bulanan</h4>
                        </div>
                    </div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5>Total Transaksi Nota Bulanan :<?php echo "Rp. " . number_format($total_nota_transaksi_bulanan, 0, "", ","); ?></h5>
                                    
                                </div>
                                <div class="col-12">
                                    <div id="linelaporankeuanganbulanan_nota"></div>
                                </div>
                               
                                
                            </div>
                
                    </div>
                </div>
            </div>
            <!-------------------------------------------------------------------------->
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="card-header">
                                <div class="col-12">
                                <h5>Total Rekap Pengeluaran Harian :<?php echo "Rp. " . number_format($total_pengeluaran_harian, 0, "", ","); ?></h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="linelaporanpengeluaran"></div>
                            </div>
                           
                             
                                
                        </div>
                    </div>
                
                    </div>
                </div>
            
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                            <div class="row">
                                <div class="card-header">
                                    <div class="col-12">
                                        <h5>Total Rekap Pengeluaran Bulanan :<?php echo "Rp. " . number_format($total_pengeluaran_bulanan, 0, "", ","); ?></h5>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="linelaporanpengeluaranbulanan"></div>
                                </div>
                               
                                
                            </div>
                
                    </div>
                </div>
            </div>
            <!-------------------------------------------------------------------------->

            <div class="col-12 col-md-12">
                <div class="card">
                <div class="card-body">
                    <h4>Diagram Warehouse</h4>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5>Stok : <?php echo $stock_today; ?> Pcs</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5>Nilai Saham :<?php echo "Rp. " . number_format($total_nilai_saham, 0, "", ","); ?></h5>
                                    
                                </div>
                                <div class="col-12">
                                    <div id="chart-stok"></div>
                                </div>
                                
                                
                            </div>
                
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                <div class="card-body">
                    <h4>Diagram Tim Produksi</h4>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5>Stok Produksi :<?php echo $stock_produksi_today; ?> Kotak/ Pcs</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                </div>
                                <div class="col-12">
                                    <div id="chart-data-produksi"></div>
                                </div>
                               
                            </div>
                
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="card">
                <div class="card-body">
                    <h4>Diagram Tambah Warehouse</h4>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>

                                        <h5>Jumlah :<?php echo $jumlah_riwayat_tambah_stock; ?> Pcs</h5>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5>Modal :<?php echo "Rp. " . number_format($biaya_riwayat_tambah_stock, 0, "", ","); ?></h5>
                                </div>
                                <div class="col-12">
                                    <div id="linetambahstokbahan"></div>
                                </div>
                                
                                
                                
                            </div>
                
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="card">
                <div class="card-body">
                    <h4>Diagram Produksi</h4>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5>Jumlah :<?php echo $stock_produksi_riwayat; ?> Kotak/ Pcs</h5>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5>Biaya :<?php echo "Rp. " . number_format($stock_produksi_biaya, 0, "", ","); ?></h5>
                                </div>
                                <div class="col-12">
                                    <div id="lineproduksi"></div>
                                </div>
                               
                                
                                
                            </div>
                
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</div>
        <!------- FOOTER --------->
            <?php $this->load->view("backend/_partials/footer.php") ?>
        <!------- FOOTER --------->
        </div>
    </div>

    <script src="<?php echo base_url().'assets/extensions/apexcharts/apexcharts.min.js'?>"></script>

<!------- TOASTIFY JS --------->
    <?php $this->load->view("backend/_partials/toastify.php") ?>
  
<!------- TOASTIFY JS --------->

<script type="application/javascript">

    $(document).ready(function() {
        var LaporanChart = {
        chart: {
            type: "area",
        },
            
        series: [
            
            {

              name: "Total (Rp)",
              data: <?php echo $valuelaporan;?>,

            },
           
        ],
            
        stroke: {
            curve: "smooth",
        },
            
        xaxis: {

            categories: <?php echo $tgllaporan;?>,
        },
          
                  
               
    }
    
    var LaporanChartBulanan = {
        chart: {
            type: "area",
        },
            
        series: [
            
            {

              name: "Total (Rp)",
              data: <?php echo $valuelaporanbulanan;?>,

            },
           
        ],
            
        stroke: {
            curve: "smooth",
        },
            
        xaxis: {

            categories: <?php echo $tgllaporanbulanan;?>,
        },
          
                  
               
    }
    var LaporanChartNota = {
        chart: {
            type: "area",
        },
            
        series: [
            
            {

              name: "Total (Rp)",
              data: <?php echo $valuelaporan_nota;?>,

            },
            {
                name:"Jumlah (Kotak/ Pcs)",
                data:<?php echo $jumlahlaporan_nota; ?>,
            }
        ],
            
        stroke: {
            curve: "smooth",
        },
            
        xaxis: {

            categories: <?php echo $tgllaporan_nota;?>,
        },
          
                  
               
    }
    
    var LaporanChartBulananNota = {
        chart: {
            type: "area",
        },
            
        series: [
            
            {

              name: "Total (Rp)",
              data: <?php echo $valuelaporanbulanan_nota;?>,

            },
            {
                name:"Jumlah (Kotak/ Pcs)",
                data:<?php echo $jumlahlaporanbulanan_nota; ?>,
            }
        ],
            
        stroke: {
            curve: "smooth",
        },
            
        xaxis: {

            categories: <?php echo $tgllaporanbulanan_nota;?>,
        },
          
                  
               
    }

    var LaporanPengeluaranChart = {
        chart: {
            type: "area",
        },
            
        series: [
            
            {

              name: "Total (Rp)",
              data: <?php echo $valuepengeluaran;?>,

            },
           
        ],
            
        stroke: {
            curve: "smooth",
        },
            
        xaxis: {

            categories: <?php echo $tglpengeluaran;?>,
        },
          
                  
               
    }
    
    var LaporanPengeluaranBulananChart = {
        chart: {
            type: "area",
        },
            
        series: [
            
            {

              name: "Total (Rp)",
              data: <?php echo $valuepengeluaranbulanan;?>,

            },
           
        ],
            
        stroke: {
            curve: "smooth",
        },
            
        xaxis: {

            categories: <?php echo $tglpengeluaranbulanan;?>,
        },
          
                  
               
    }


        var optionsStok = {
            annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled:false
            },
            chart: {
                type: 'bar',
                height: 300
            },
            fill: {
                opacity:1
            },
            plotOptions: {
            },
            series: [{
                name: 'Stok (Pcs)',
                data: <?php echo $valuestok;?>
            }],
            colors: '#435ebe',
            xaxis: {
                categories: <?php echo $namestok;?>,
            },
        }


        var optionsStokProduksi = {
              annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled:false
            },
            chart: {
                type: 'bar',
                height: 300
            },
            fill: {
                opacity:1
            },
            plotOptions: {
            },
            series: [{
                name: 'Stok Produksi (Kotak/ Pcs)',
                data: <?php echo $valuestokproduksi;?>,
            }],
            colors: '#435ebe',
            xaxis: {
                categories: <?php echo $namestokproduksi;?>,
            },
        }
        var produksiChart = {
          chart: {
            type: "area",
          },
            
          series: [

            {

              name: "Biaya",
              data: <?php echo $valueriwayatproduksi;?>,

            },
            {
                name:"Jumlah (Kotak/ Pcs)",
                data:<?php echo $jumlahriwayatproduksi; ?>,
            }
          ],
            
            stroke: {
                curve: "smooth",
            },

          xaxis: {

            categories: <?php echo $tglriwayatproduksi;?>,
          },
          
                  
               
        }
        var TambahStokChart = {
          chart: {
            type: "area",
          },
            
          series: [
            
            {

              name: "Biaya",
              data: <?php echo $valueriwayattambah;?>,

            },
            {
                name:"Jumlah (Pcs)",
                data:<?php echo $jumlahriwayattambah; ?>,
            }
          ],
            
            stroke: {
                curve: "smooth",
            },
            
          xaxis: {

            categories: <?php echo $tglriwayattambah;?>,
          },
          
                  
               
        }

        var transaksi = new ApexCharts(document.querySelector("#linelaporankeuangan"), LaporanChart);
        var transaksibulanan = new ApexCharts(document.querySelector("#linelaporankeuanganbulanan"), LaporanChartBulanan);
        var transaksiNota = new ApexCharts(document.querySelector("#linelaporankeuangan_nota"), LaporanChartNota);
        var transaksibulananNota = new ApexCharts(document.querySelector("#linelaporankeuanganbulanan_nota"), LaporanChartBulananNota);

        var pengeluaran = new ApexCharts(document.querySelector("#linelaporanpengeluaran"), LaporanPengeluaranChart);
        var pengeluaranbulanan = new ApexCharts(document.querySelector("#linelaporanpengeluaranbulanan"), LaporanPengeluaranBulananChart);

        var line = new ApexCharts(document.querySelector("#lineproduksi"), produksiChart);
        var line2 = new ApexCharts(document.querySelector("#linetambahstokbahan"), TambahStokChart);
        
        transaksi.render();
        transaksibulanan.render();
        transaksiNota.render();
        transaksibulananNota.render();
        pengeluaran.render();
        pengeluaranbulanan.render();
        line.render();
        line2.render();
        var chartStok = new ApexCharts(
            document.querySelector("#chart-stok"),
            optionsStok
        );
        chartStok.render();

        var chartStokProduksi = new ApexCharts(
            document.querySelector("#chart-data-produksi"),
            optionsStokProduksi
        );
        chartStokProduksi.render();
    });
</script>

</body>
</html>
