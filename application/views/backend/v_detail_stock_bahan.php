
<div class="page-content">
    <!------- breadcrumb --------->
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                
                <h3><a href="<?php echo site_url('backend/rekap_stok_bahan');?>"><i class="bi bi-chevron-left"></i></a> <?php echo $title; ?></h3>
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
                   
            <div class="card-body">
                <div id="peringatan">
                
                </div>
                    <table class="table table-borderless">
                            <tr>
                                <td>
                                    Nota :
                                </td>
                                <td>
                                    <b><?php echo $id; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Supplier :
                                </td>
                                <td>
                                    <b><?php echo $suplier; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Penerima :
                                </td>
                                <td>
                                    <b><?php echo $user_name; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Catatan* :
                                </td>
                                <td>
                                    <b><?php echo $catatan; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Riwayat Bahan Masuk :
                                </td>
                                <td>
                                    <b><?php echo $tgl_penambahan; ?></b>
                                </td>
                            </tr>
                            
                        </table>
                
                <br/><br/>
                <h5>List Bahan Baku</h5>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="col-4">Nama Bahun Baku</th>
                                <th>Jumlah</th>
                                <th class="col-4">Biaya Dikeluarkan</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <th colspan="3" style="text-align:right">Total:</th>
                                <th></th>
                                
                            </tr>
                        </tfoot>
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
            "url": "<?php echo site_url('backend/rekap_stok_bahan/get_ajax_list_detail')?>",
            "type": "POST",
            "data":{id:id},
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3 ], //first column
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
            var intVal2 = function ( k ) {
                return typeof k === 'string' ?

                    k.replace(/[\ , ,.]/g, '')*1 :

                    typeof k === 'number' ?
                        k : 0;
            };
 
            // Total over all pages
            
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal2(a) + intVal2(b);
                }, 0 );
 
            // Total over this page
            
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var test = (pageTotal).toLocaleString(undefined, 
                    { minimumFractionDigits: 0 });
            var test2 = (total).toLocaleString(undefined, 
                    { minimumFractionDigits: 0 });
            // Update footer
            $('.totalbiaya').val(pageTotal);
            $('.totaljumlah').val(total);
            $( api.column( 2 ).footer() )
            .html(
                
                'Total Jumlah :'+test2 +' Pcs '

            );
            $( api.column( 3 ).footer() )
            .html(
                
                'Rp. '+test +''

            );

       
        },

    });

   
  

    
});

</script>

</body>
</html>
