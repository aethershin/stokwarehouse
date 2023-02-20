
<div class="page-heading">
 
    <!------- breadcrumb --------->
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                
                <h3><a href="<?php echo site_url('backend/rekap_nota_transaksi_konsumen');?>"><i class="bi bi-chevron-left"></i></a> <?php echo $title; ?></h3>
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
                                <?php if($this->session->userdata('level')==1):?>  
                                    <th class="col-6">Aksi</th>
                                <?php else:?>
                                <!-- END MENU KHUSUS SUPIR -->  
                                <?php endif;?>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <?php if($this->session->userdata('level')==1):?>  
                                    <th colspan="1" style="text-align:right">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                <?php else:?>
                                    <th colspan="1" style="text-align:right">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    
                                <?php endif;?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br/>
                <code><i>*Hapus terlebih dahulu List Produk jika ingin membatalkan Transaksi</i></code>
                <?php if($this->session->userdata('level')==1):?>  
                    <form id="form-pembatalan">
                            <input type="hidden"  name="id_nota" class="id_nota" value="<?php echo $id; ?>"/>
                            <div class="btn-group float-end">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="prosespembatalannota" class="btn btn-danger"><i class="bi bi-trash"></i> Batalkan Transaksi</button>
                                
                            </div>
                    </form> 
                <?php else:?>
     
                <?php endif;?>
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
            
            
            

            $('.kettotal').html('<p><b>Total yang harus dibayar : <u>Rp.'+test+'</u></b></p>');
            
            $( api.column( 3 ).footer() )
            .html(
                
                'Rp. '+test +''

            );

       
        },

    });


    $(document).on("click", "#del", function(e) {
        e.preventDefault();

        var id = $(this).attr("value");
        Swal.fire({
            title: "Apakah kamu yakin ingin menghapus Data ini?",
            text: "Data ini akan di hapus secara Permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/rekap_nota_transaksi_konsumen/delete')?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Deleted!",
                                "Data berhasil dihapus.",
                                "success"
                            );
                            
                            
                            reload_table();
                        }
                    },
                });
            }
        });
    });
    
    $(document).on("click", "#prosespembatalannota", function(e) {
        e.preventDefault();
        var id_nota = $('.id_nota').val();
        
        
        if(total == 0) {

           
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/rekap_nota_transaksi_konsumen/prosespembatalannota')?>",
                    data: {
                        id_nota: id_nota
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            
                            var site_url = '<?php echo site_url();?>';
                            
                            window.location = site_url+"backend/rekap_nota_transaksi_konsumen/";
                        }
                    },
                });
        } else {
            alert_gagal_pembatalan();
        }


          
    });
 
    
});
function reload_table()
{
    table.ajax.reload(null,false); 
}
</script>

</body>
</html>
