<div class="page-heading" id="page-heading">
    <h3><?php echo $title; ?></h3>
</div>
<div class="page-content">
    <section class="row">

        <div class="col-12 col-lg-9">
                        
            <div class="row">
                
                <div class="col-12 col-md-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="col-12">
                                <h5>Stok Produk Ready Sale</h5>
                            </div>
                        </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-primary" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="assets/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            
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

            
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            
                            <div class="row">
                                
                                <div class="col-12">
                                    <h5>Total Setoran Harian :<?php echo "Rp. " . number_format($total_transaksi, 0, "", ","); ?></h5>
                                </div>
                                <div class="col-12">
                                    <div id="linelaporankeuangan"></div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
                <div class="col-6 col-lg-3 col-md-6" id="lists">
                    
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <a  class="btn-produksi" href="javascript:void(0);" ><h6 class="text-muted font-semibold"><b> <i class="bi bi-eye"></i> Produksi Bulan Ini</b></h6></a>
                                    
                                    <h6 class="font-extrabold mb-0"><?php echo number_format($produksihariini);?> Kotak/Pcs</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <a  class="btn-transaksi" href="javascript:void(0);" ><h6 class="text-muted font-semibold"><b> <i class="bi bi-eye"></i> Produk Terjual Bulan ini</b></h6></a>
                                    
                                    <h6 class="font-extrabold mb-0"><?php echo number_format($transaksihariini);?> Kotak/Pcs</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <a  class="btn-transaksi" href="javascript:void(0);" ><h6 class="text-muted font-semibold"><b> <i class="bi bi-eye"></i> Pendapatan Kotor Bulan ini</b></h6></a>
                                    
                                    <h6 class="font-extrabold mb-0"><?php echo "Rp. " . number_format($pendapatan_kotor, 0, "", ","); ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <a  class="btn-produksi" href="javascript:void(0);" ><h6 class="text-muted font-semibold"><b> <i class="bi bi-eye"></i> Biaya Produksi Bulan ini</b></h6></a>
                                    
                                    <h6 class="font-extrabold mb-0"><?php echo "Rp. " . number_format($biaya_produksi, 0, "", ","); ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    
                                    <a  class="btn-pengeluaran" href="javascript:void(0);" ><h6 class="text-muted font-semibold"><b> <i class="bi bi-eye"></i> Pengeluaran Bulan ini</b></h6></a>
                                    <h6 class="font-extrabold mb-0"><?php echo "Rp. " . number_format($pengeluaran, 0, "", ","); ?></h6>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold"><b> Pendapatan Bersih Bulan ini</b></h6>
                                    
                                    <h6 class="font-extrabold mb-0"><?php echo "Rp. " . number_format($pendapatan_bersih, 0, "", ","); ?></h6>
                                    
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
<!------- TEMPLATE JS --------->
   
    <script language="JavaScript" type="application/javascript" src="<?php echo base_url().'assets/extensions/apexcharts/apexcharts.min.js'?>"></script>
<!------- TEMPLATE JS --------->
 



<script language="JavaScript" type="application/javascript">
        $(document).ready(function(){
            $('#page-heading').on('click','.download-panduan',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/dashboard/download";
            });

            $('#lists').on('click','.btn-produksi',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_tim_produksi";
            });
            $('#lists').on('click','.btn-transaksi',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen";
            });
            $('#lists').on('click','.btn-pengeluaran',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/pengeluaran";
            });

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
                name: 'Stok Produk Ready Sale',
                data: <?php echo $valuestokproduksi;?>,
            }],
            colors: '#435ebe',
            xaxis: {
                categories: <?php echo $namestokproduksi;?>,
            },
        }
var line = new ApexCharts(document.querySelector("#linelaporankeuangan"), LaporanChart);
line.render();
            var chartStokProduksi = new ApexCharts(
                document.querySelector("#chart-data-produksi"),
                optionsStokProduksi
            );
            chartStokProduksi.render();

        });
    </script>
   	
</body>

</html>
