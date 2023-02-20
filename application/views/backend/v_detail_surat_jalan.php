
<div class="page-content">
 
    <!------- breadcrumb --------->
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                
                <h3><a href="<?php echo site_url('backend/rekap_surat_jalan');?>"><i class="bi bi-chevron-left"></i></a> <?php echo $title; ?></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header float-start float-lg-end'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('backend/dashboard');?>">Dashboard</a></li>
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
                   <table class="table table-borderless float-start w-75">
                            <tr>
                                <td>
                                    Kode Surat Jalan :
                                </td>
                                <td>
                                    <b><?php echo $id; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Diserahkan :
                                </td>
                                <td>
                                    <b><?php echo $diserahkan_sj; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Penerima :
                                </td>
                                <td>
                                    <b><?php echo $penerima_sj; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Diketahui :
                                </td>
                                <td>
                                    <b><?php echo $diketahui_sj; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Catatan :
                                </td>
                                <td>
                                    <b><?php echo $catatan_surat_jalan; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Riwayat Ekspedisi :
                                </td>
                                <td>
                                    <b><?php echo $tgl_ubah_surat_jalan; ?></b>
                                </td>
                            </tr>
                        </table>
                <br/><br/>
            <div class="card-body">
                        
              
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="col-4">Nama Produk</th>
                                <th class="col-4">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <th colspan="2" style="text-align:right"></th>
                                <th></th>
                               
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br/>
                <h5>List Produk Retur</h5>
                <div class="table-responsive">
                    <table id="mytableretur" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="col-4">Nama Produk Retur</th>
                                <th class="col-4">Jumlah Retur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                                
                                foreach ($dataretur->result() as $row):
                                    $no++;
                                    $totaljumlah += $row->retur_jumlah;
                                
                            ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $row->nama_stock;?></td>
                                    <td><?php echo $row->retur_jumlah;?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <br/>
                
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
            "url": "<?php echo site_url('backend/rekap_surat_jalan/get_ajax_list_detail')?>",
            "type": "POST",
            "data":{id:id},
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2 ], //first column
                "orderable": false, //set not orderable
            },
            
        ],

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?

                    i.replace(/[\Rp, ,.]/g, '')*1 :

                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            
           
            // Update footer
          
            $('.totaljumlah').val(total);
            
         
            $( api.column( 2 ).footer() )
            .html(
                
                'Total Jumlah :'+total

            );
            

       
        },

    });

   
 
    
});

</script>

</body>
</html>
