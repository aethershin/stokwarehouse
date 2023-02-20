
<div class="page-content">
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
                   
            <div class="card-body">
               
                <div class="col-12 col-md-9 mb-3 float-start">
                    <a href="#" class="btn icon btn-sm btn-danger" id="cancelpaid" href="javascript:void()" value="<?php echo $id; ?>"><i class="bi bi-x"></i> Batalkan Konfirmasi Pembayaran</a>
                </div>

                <div class="col-12 col-md-3 float-end">
                    <a href="#" class="btn icon btn-sm btn-success" id="paid" href="javascript:void()" value="<?php echo $id; ?>"><i class="bi bi-check"></i> Konfirmasi Pembayaran</a>
                </div>
                <br/><br/><br/>
                
                        <table class="table table-borderless m-0 p-0 text-sm">
                            <tr>
                                <td>
                                    <code>ID Nota :</code>
                                   
                                </td>
                                <td>

                                    <b><?php echo $id; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <code>Nama :</code>
                                   
                                </td>
                                <td>

                                    <b><?php echo $nama; ?></b>
                                </td>
                            </tr>
                        </table>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                               
                                <th class="col-2">Tenor Cicilan</th>
                                
                                <th class="col-2">Tagihan</th>
                                <th class="col-1">Dibayar</th>
                                
                                
                                <th class="col-3">Nominal</th>
                                <th class="col-6">Terakhir di Bayar</th>
                                
                            </tr>
                        </thead>
                        <tbody>
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
        function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 2 ? 'block' : 'none';
}
</script>


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
            "url": "<?php echo site_url('backend/rekap_nota_transaksi_konsumen/get_ajax_list_cicil')?>",
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

       

    });

 
    
});
function reload_table()
{
    table.ajax.reload(null,false); 
}
    

    $(document).on("click", "#paid", function(e) {
        e.preventDefault();

        var id_notas = $(this).attr("value");
        Swal.fire({
            title: "Konfirmasi Pembayaran Cicilan ini?",
            text: "Dengan Mengklik Ya, maka anda sudah mengkonfirmasi Pembayaran Ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/rekap_nota_transaksi_konsumen/paid')?>",
                    data: {
                        id_notas: id_notas
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Berhasil!",
                                "Pembayaran Cicilan Berhasil dikonfirmasi.",
                                "success"
                            );
                            reload_table();
                        } else if (response.res == "error") {
                            Swal.fire(
                                "Gagal!",
                                "Pembayaran Cicilan sudah dilunasi.",
                                "error"
                            );
                            reload_table();
                        } else {

                        }
                    },
                });
            }
        });
    });


    $(document).on("click", "#cancelpaid", function(e) {
        e.preventDefault();

        var id_notas = $(this).attr("value");
        Swal.fire({
            title: "Konfirmasi PEMBATALAN Pembayaran Cicilan ini?",
            text: "Dengan Mengklik Ya, maka anda sudah mengkonfirmasi PEMBATALAN Pembayaran Ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/rekap_nota_transaksi_konsumen/cancelpaid')?>",
                    data: {
                        id_notas: id_notas
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Berhasil!",
                                "Pembayaran Cicilan Berhasil dibatalkan.",
                                "success"
                            );
                            reload_table();
                        } else if (response.res == "error") {
                            Swal.fire(
                                "Gagal!",
                                "Error Pembatalan.",
                                "error"
                            );
                            reload_table();
                        } else {

                        }
                    },
                });
            }
        });
    });

  
</script>

</body>
</html>
