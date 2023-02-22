
<div class="page-heading">
    <!------- breadcrumb --------->
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                
                <h3><a href="<?php echo site_url('backend/konsumen');?>"><i class="bi bi-chevron-left"></i></a> <?php echo $title; ?></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header float-start float-lg-end'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('backend/dashboard');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo site_url('backend/konsumen');?>">Konsumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!------- breadcrumb --------->
    
    


    <!-- Post Datatables -->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                   
            <div class="card-body">
                <div id="peringatan">
                
                </div>
                    <table class="table table-borderless m-0 p-0 text-sm">
                            <tr>
                                <td>
                                    <code>ID Konsumen :</code>
                                   
                                </td>
                                <td>

                                    <b><?php echo $id_cus; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <code>Nama :</code>
                                </td>
                                <td>
                                    <b><?php echo $name; ?></b>
                                </td>
                            </tr>
                           
                            
                            <tr>
                                <td>
                                    <code>Total Hutang :</code>
                                </td>
                                <td>
                                    <b><?php echo $hutangshow; ?></b>
                                </td>
                            </tr>
     
                            
                        </table>
                        <div class="col-12 col-md-12">
                                <div class="card">
                                <div class="card-body">
                                    <h4>Diagram Pembelian Produk</h4>
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
                                                    <div id="chart-pembelian-produk"></div>
                                                </div>
                                               
                                            </div>
                                
                                    </div>
                                </div>
                            </div>

                            
                <br/><br/>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="col-1">Nota</th>
                                <th class="col-2">Tenor Cicilan</th>
                                
                                <th class="col-2">Tagihan</th>
                                <th class="col-1">Dibayar</th>
                                
                                
                                <th class="col-3">Jatuh Tempo</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                       
                    </table>
                </div>  
                </div>
                    
                </div>
            </div>

                            
                        
        </div>
    </section>
    <!-- Post Datatables END -->

    
</div>

        <!------- FOOTER --------->
            <?php $this->load->view("backend/_partials/footer.php") ?>
        <!------- FOOTER --------->
        </div>
    </div>


<!------- TOASTIFY JS --------->
    <?php $this->load->view("backend/_partials/toastify.php") ?>
  <script src="<?php echo base_url().'assets/extensions/apexcharts/apexcharts.min.js'?>"></script>
<!------- TOASTIFY JS --------->
<script type="application/javascript">

var save_method; 
var table;
var csfrData = {};
csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo
$this->security->get_csrf_hash(); ?>';
$.ajaxSetup({
data: csfrData
});
$(document).ready(function() {
  
    //datatables
    
    var id="<?php echo $id; ?>";

    table = $('#mytable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        "lengthChange": false,
        "paging": false,
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/konsumen/get_ajax_list_cicil')?>",
            "type": "POST",
            "data":{id:id},
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3,4 ], //first column
                "orderable": false, //set not orderable
            },
            
        ],

        

    });

    $('#mytable').on('click','.detail',function(){
        var id = $(this).data('id');
        var site_url = '<?php echo site_url();?>';
        window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/detailnota/"+id+"";
    });

        var optionsPembelianProduk = {
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
                name: 'Pembelian Produk (Kotak/ Pcs)',
                data: <?php echo $valuespembelian;?>,
            }],
            colors: '#435ebe',
            xaxis: {
                categories: <?php echo $namesproduk;?>,
            },
        }
        var chartPembelianProduk = new ApexCharts(
            document.querySelector("#chart-pembelian-produk"),
            optionsPembelianProduk
        );
        chartPembelianProduk.render();
    
});


  
</script>


</body>
</html>
