
<div class="page-heading">
 
    <!------- breadcrumb --------->
    <div class="page-title">
        <div class="row"  id="getback">
            <div class="col-12 col-md-6 order-md-1 order-last">
                
                <h3><a href="javascript:void()" class="back" data-id="<?php echo $id_cus; ?>"><i class="bi bi-chevron-left"></i></a> <?php echo $title; ?> </h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header float-start float-lg-end'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('backend/dashboard');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void()" class="back" data-id="<?php echo $id_cus; ?>">Detail Riwayat</a></li>
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
                                    Nota Transaksi : 
                                </td>
                                <td>
                                    <b><?php echo $id; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Konsumen :
                                </td>
                                <td>
                                    <b><?php echo $nama; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jenis Transaksi :
                                </td>
                                <td>
                                    <b><?php echo $jenis_transaksi; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Total Transaksi :
                                </td>
                                <td>
                                    <b><?php echo $showtotal_belanja; ?></b>
                                </td>
                            </tr>
                        <?php if($jenis_transaksi=='Cicil'):?>
                            <tr>
                                <td>
                                    Tenor :
                                </td>
                                <td>
                                    <b><?php echo $tenorbulan; ?> <a href="javascript:void(0);" class="btn icon btn-sm btn-primary bayar_cicilan"><i class="bi bi-cash"></i> Bayar Cicilan</a></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Cicilan :
                                </td>
                                <td>
                                    <b><?php echo $showcicilan; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Telah Dibayar :
                                </td>
                                <td>
                                    <b><?php echo $showtelah_dibayar; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sebanyak :
                                </td>
                                <td>
                                    <b><?php echo $jumlah_telah_dibayar; ?>x</b>
                                </td>
                            </tr>
                            <?php if($telah_dibayar<=0):?>
                                <tr>
                                    <td>
                                        Terakhir dicicil :
                                    </td>
                                    <td>
                                        <b>-</b>
                                    </td>
                                </tr>
                            <?php elseif($telah_dibayar>0):?>
                            
                                <tr>
                                    <td>
                                        Terakhir dicicil :
                                    </td>
                                    <td>
                                        <b><?php echo $tgl_update_bayar; ?></b>
                                    </td>
                                </tr>
                            <?php else:?>
                            <?php endif;?>
                        
                        <?php elseif($jenis_transaksi=='Cicilan Lunas'):?>
                            <tr>
                                <td>
                                    Telah Lunas pada tanggal :
                                </td>
                                <td>
                                    <b><?php echo $tgl_ubah; ?></b>
                                </td>
                            </tr>
                        <?php else:?>
                        <?php endif;?>
                            <tr>
                                <td>
                                    Catatan :
                                </td>
                                <td>
                                    <b><?php echo $catatan; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Riwayat Transaksi :
                                </td>
                                <td>
                                    <b><?php echo $tgl_transaksi; ?></b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    Ekspedisi :
                                </td>
                                <td>
                                    <b><?php echo $karyawan; ?></b>
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
                                <th class="col-6">Nama Produk</th>
                                <th>Jumlah</th>
                                <th class="col-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <th colspan="1" style="text-align:right">Total:</th>
                                <th></th>
                                <th></th>
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
var csfrData = {};
csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo
$this->security->get_csrf_hash(); ?>';
$.ajaxSetup({
data: csfrData
});
$(document).ready(function() {
  
    //datatables
            $('#input-validation').on('click','.bayar_cicilan',function(){
                var id = "<?php echo $id; ?>";
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/bayar_cicilan/"+id+"";
            });

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
            "url": "<?php echo site_url('backend/rekap_nota_transaksi_konsumen/get_ajax_list_detail')?>",
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
                .column( 2 )
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
            $('.totaljumlah').val(total);
            
            

            $('.kettotal').html('<p><b>Total yang harus dibayar : <u>Rp.'+test+'</u></b></p>');
            
            $( api.column( 3 ).footer() )
            .html(
                
                'Rp. '+test +''

            );

       
        },

    });

    $('#getback').on('click','.back',function(){
        var ids = $(this).data('id'); 
        var site_url = '<?php echo site_url();?>';
        window.location.href = site_url+"backend/konsumen/detail/"+ids+"";
    });
 
    
});

</script>

</body>
</html>
