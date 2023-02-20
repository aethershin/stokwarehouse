
<div class="page-content">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-7 order-md-1 order-last" id="page-heading">
                <h4><?php echo $title; ?> <a href="javascript:void(0);" class="btn icon btn-sm btn-primary rekap"><i class="bi bi-clipboard-fill"></i> Rekap</a></h4>
                
            </div>
            <div class="col-12 col-md-5 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header float-start float-lg-end'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('backend/dashboard');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    


    <!-- Post Datatables -->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                   
            <div class="card-body">
                <div id="peringatan">
                <?php if($produksi_belum_selesai > 0):?> 

                        <div class="alert alert-light-warning color-warning alert-dismissible show fade clear-notif-warning">
                            <h5>Ada Bahan baku yang belum selesai di Proses, Tekan <span class="text-success">Proses Tambah Stok</span> dibawah untuk menyelesaikannya</h5>
                            <button type="button btn-sm" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> 
                    
                <?php else:?>

                <?php endif;?>
                </div>

                <?php $this->load->view("backend/modal/tambah_stock_bahan_modal.php") ?>
                
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
                                <th class="col-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <th colspan="3" style="text-align:right">Total:</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br/>
                <form id="form-tambahstokbahan">
                        <div class="col-12 col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control catatan" placeholder="Catatan *Opsional" name="catatan" id="catatan_produksi"></textarea>
                                <label for="floatingTextarea">Catatan *Opsional</label>
                            </div>
                        </div>
                        <br/>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control suplier" placeholder="Supplier" name="suplier" id="suplier"/>
                            </div>
                        </div>
                        <input type="hidden"  name="totalbiaya" class="totalbiaya"/>
                        <input type="hidden"  name="totaljumlah" class="totaljumlah"/>
                        <br/> 
                        <div class="col-12 col-md-12">
                            <div class="btn-group">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="prosestambahstokbahan" class="btn btn-success"><i class="bi bi-save"></i> Proses Tambah Stok</button>
                                
                            </div>
                        </div>
                    </form>
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
            $('#page-heading').on('click','.rekap',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_stok_bahan/";
            });


    table = $('#mytable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        "lengthChange": false,
        "paging": false,
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/tambah_stock_bahan/get_ajax_list')?>",
            "type": "POST",
            
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3,4 ], //first column
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

                    k.replace(/[\Rp, ,.]/g, '')*1 :

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
                
                'Total Jumlah :'+test2 +' Pcs'

            );
            $( api.column( 3 ).footer() )
            .html(
                
                'Rp. '+test +''

            );

       
        },

    });

   
   
    $("#bahan_baku").select2({
        cache: false,
        theme: "bootstrap-5",
    });
          
   
    $("#jumlah").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });


    
});
function reload_table()
{
    table.ajax.reload(null,false); 
}
    $(document).on("click", "#btnSave", function(e) {
        e.preventDefault();

        var bahan_baku = $('.bahan_baku').val();
        var jumlah = $('.jumlah').val();

            if (bahan_baku == "" || jumlah == 0) {
                alert_stok_kosong();
            } else {
      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/tambah_stock_bahan/add')?>",
                    data: {
                        bahan_baku: bahan_baku,jumlah:jumlah
                    },
                    dataType: "json",
                    success: function(response) {
                
                            if (response.res == "success") {
                                
                                alert_sukses_tambah();
                                reload_table();
                            } else if(response.res == "error") {
                                alert_stok_kosong();
                            } else if(response.res == "duplicate") {
                                $('#form')[0].reset();
                                $("#bahan_baku").select2("destroy");
                                $("#bahan_baku").select2({
                                        cache: false,
                                        theme: "bootstrap-5",
                                });
                                alert_duplicate_bahan();
                            } else {

                            }
                    },
                });
            }
           
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
                    url : "<?php echo site_url('backend/tambah_stock_bahan/delete')?>",
                    data: {
                        id: id,
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

    $(document).on("click", "#minus", function(e) {
        e.preventDefault();

        var add_stock_id = $(this).attr("value");

       
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/tambah_stock_bahan/minus')?>",
                    data: {
                        add_stock_id: add_stock_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                                reload_table();
                            } else if(response.res == "error") {
                                alert_stok_berlebihan();
                            } else {

                            }
                    },
                });
          
    });

    $(document).on("click", "#plus", function(e) {
        e.preventDefault();

        var add_stock_id = $(this).attr("value");

      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/tambah_stock_bahan/plus')?>",
                    data: {
                        add_stock_id: add_stock_id,
                    },
                    dataType: "json",
                    success: function(response) {
                
                            if (response.res == "success") {
                                reload_table();
                            } else if(response.res == "error") {
                                alert_stok_habis();
                            } else {

                            }
                    },
                });
           
    });


    $(document).on("click", "#prosestambahstokbahan", function(e) {
        e.preventDefault();

        var catatan = $('.catatan').val();
        var totalbiaya = $('.totalbiaya').val();
        var totaljumlah = $('.totaljumlah').val();
        var suplier = $('.suplier').val();

            if (totalbiaya == "" || totaljumlah == "" || totaljumlah == 0 || suplier == "") {
                alert_stok_kosong();
            } else {


                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/tambah_stock_bahan/prosestambahstokbahan')?>",
                    data: {
                        catatan: catatan,totalbiaya: totalbiaya,totaljumlah:totaljumlah, suplier:suplier
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Ditambah!",
                                "Stock Berhasil ditambah.",
                                "success"
                            );
                            $('#form')[0].reset();
                            $("#bahan_baku").select2("destroy");
                            $("#bahan_baku").select2({
                                    cache: false,
                                    theme: "bootstrap-5",
                            });
                            $("#peringatan").addClass("d-none");
                            reload_table();

                        }
                    },
                });
            }
          
    });
</script>

</body>
</html>
