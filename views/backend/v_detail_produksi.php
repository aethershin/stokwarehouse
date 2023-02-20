
<div class="page-heading">
    <!------- breadcrumb --------->
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                
                <h3><a href="<?php echo site_url('backend/rekap_tim_produksi');?>"><i class="bi bi-chevron-left"></i></a> <?php echo $title; ?></h3>
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
                

                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    Kode Produksi :
                                </td>
                                <td>
                                    <b><?php echo $id; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nama Produksi :
                                </td>
                                <td>
                                    <b><?php echo $jenis; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jumlah Produksi :
                                </td>
                                <td>
                                    <b><?php echo $jumlah; ?> <?php echo $satuan; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Dikerjakan Oleh :
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
                                    Riwayat Produksi :
                                </td>
                                <td>
                                    <b><?php echo $tgl_produksi; ?></b>
                                </td>
                            </tr>
                            
                        </table>
                <br/><br/>
                <h5>List Material</h5>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                    <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="col-6">Nama Material</th>
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
                <h5>List Material Rusak</h5>
                <div class="table-responsive">
                    <table id="mytablerusak" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                    <th>No</th>
                                    <th class="col-4">Nama Material</th>
                                    <th class="col-6">Jumlah Kerugian</th>
                                    
                                    <th class="col-4">Total Kerugian</th>
 
                                </tr>
                        </thead>
                        <tbody>
                            <?php 
                                                
                                foreach ($datarusak->result() as $row):
                                    $no++;
                                    $jumlah_rusak += $row->jumlah_rusak;
                                    $biaya_dikeluarkan_rusak += $row->biaya_dikeluarkan_rusak;
                                    
                            ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $row->nama_stock;?></td>
                                    <td><?php echo number_format($row->jumlah_rusak, 0, "", ",").' '.$row->nama_satuan;?></td>
                                    <td><?php echo "Rp. " . number_format($row->biaya_dikeluarkan_rusak, 0, "", ",");?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>

                            <th>    </th>
                            <th>Total :</th>
                            <th><?php echo number_format($jumlah_rusak, 0, "", ","); ?></th>
                            <th><?php echo "Rp. " . number_format($biaya_dikeluarkan_rusak, 0, "", ","); ?></th>
                        </tr>
                    </tfoot>
                    </table>
                </div>


            </div>
                   
                </div>
            </div>

                            
                        
        </div>
    </section>
    <!-- Post Datatables END -->

    
</div>
    <input type="hidden" value="<?php echo base_url(); ?>" id="base_url">
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
    var jenis="<?php echo $jenis; ?>";
    $("#nama_produksi").select2({
        cache: false,
        theme: "bootstrap-5",
    }).val(jenis).trigger("change");
    table = $('#mytable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        "lengthChange": false,
        "paging": false,
        
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/rekap_tim_produksi/get_ajax_list_detail')?>",
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
 
            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var test = (pageTotal).toLocaleString(undefined, 
                    { minimumFractionDigits: 0 }
                );
            // Update footer
            $('.totalbiaya').val(pageTotal);
            $( api.column( 3 ).footer() ).html(
                
                'Rp. '+test +''

            );

       
        },

    });

   
    
});



</script>

</body>
</html>
