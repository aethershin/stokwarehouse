
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
                            <h5>Ada Produksi yang belum selesai, Tekan <span class="text-success">Produksi Barang</span> dibawah untuk menyelesaikan Produksi</h5>
                            <button type="button btn-sm" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> 
                    
                <?php else:?>

                <?php endif;?>
                </div>

                <!-- FILTER -->
                    <p class="text-subtitle text-muted">Jenis Produksi</p>
                        <form id="form-filter">
                            <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <select class="form-select nama_produksi" name="nama_produksi" id="nama_produksi" style="width:100%" required>
                                        <option value="" >[Pilih Jenis Produksi]</option>
                                        <?php foreach ($produksi->result() as $row) : ?>
                                            <option value="<?php echo $row->id_stock;?>"><?php echo $row->nama_stock;?> | <?php echo $row->stock;?> <?php echo $row->nama_satuan;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    
                                    <input type="number" name="jumlah_produksi" class="form-control jumlah_produksi" id="jumlah_produksi" placeholder="Jumlah Produksi" required>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control catatan_produksi" placeholder="Catatan Produksi *Opsional" name="catatan_produksi"></textarea>
                                    <label for="floatingTextarea">Catatan Produksi *Opsional</label>
                                </div>
                            </div>
                            
                            
                            </div>
                        
                    <hr>
<!-- FILTER -->
                
                <div class="btn-group mb-3  float-end" role="group" aria-label="Basic example">
                <a class="btn icon btn-sm btn-success" id="btn-validate-import" onclick="add_produksi()"><i class="bi bi-plus"></i></a></i></a>&nbsp;&nbsp;

                </div>
                <br/><br/>
                <h5>List Material</h5>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                    <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="col-6">Nama Material</th>
                                    <th>Jumlah</th>
                                    
                                    <th class="col-2">Biaya Dikeluarkan</th>
                                    <th class="col-3">Aksi</th>
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
                </div>
                        <input type="hidden"  name="totalbiaya" class="totalbiaya"/> 
                        <div class="col-12 col-md-4">
                            <div class="btn-group mb-3">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="prosesproduksi" class="btn btn-success"><i class="bi bi-save"></i> Porduksi Barang</button>
                                
                            </div>
                        </div>
                    </form>
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
var csfrData = {};
csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo
$this->security->get_csrf_hash(); ?>';
$.ajaxSetup({
data: csfrData
});
$(document).ready(function() {
   

    //datatables
            $('#page-heading').on('click','.rekap',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_tim_produksi/";
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
            "url": "<?php echo site_url('backend/produksi_barang/get_ajax_list')?>",
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

   
   
    $("#nama_produksi").select2({
        cache: false,
        theme: "bootstrap-5",
    });
          
   
    $("#jumlah").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });


    
});



function add_produksi()
{
   
    save_method = 'add';
    $('#formproduksi')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form_produksi').modal('show'); 
    $('.modal-title').text('Gunakan Material'); 
    $("#bahan_baku").select2({
        dropdownParent: $("#modal_form_produksi"),
        cache: false,
        theme: "bootstrap-5",
    });
   
}
 

function reload_table()
{
    table.ajax.reload(null,false); 
}

function addproduksi()
{
    
  

    $('#btnSave').text('saving...'); 
    $('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('backend/produksi_barang/add')?>";
    } else {
        url = "<?php echo site_url('backend/produksi_barang/edit')?>";
    }

    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formproduksi').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {
                toastify_success();
                $('#modal_form_produksi').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                    $("#bahan_baku").select2({
                        dropdownParent: $("#modal_form_produksi"),
                        cache: false,
                        theme: "bootstrap-5",
                    });
                    
                }
            }
            $('#btnSave').text('Save'); 
            $('#btnSave').attr('disabled',false); 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Save'); 
            $('#btnSave').attr('disabled',false); 

        }
    });

}


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
                    url : "<?php echo site_url('backend/produksi_barang/delete')?>",
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

        var id = $(this).attr("value");

       
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/produksi_barang/minus')?>",
                    data: {
                        id: id,
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

        var id = $(this).attr("value");

      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/produksi_barang/plus')?>",
                    data: {
                        id: id,
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


    $(document).on("click", "#prosesproduksi", function(e) {
        e.preventDefault();
       
        var nama_produksi = $('.nama_produksi').val();
        var jumlah_produksi = $('.jumlah_produksi').val();
        var catatan_produksi = $('.catatan_produksi').val();
        var totalbiaya = $('.totalbiaya').val();

            if (nama_produksi == "" || jumlah_produksi == "" || totalbiaya == 0) {
                alert_rencana_produksi();
            } else {


                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/produksi_barang/prosesproduksi')?>",
                    data: {
                        nama_produksi: nama_produksi,jumlah_produksi: jumlah_produksi,totalbiaya: totalbiaya,catatan_produksi: catatan_produksi
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Ditambah!",
                                "Produksi berhasil ditambah.",
                                "success"
                            );
                            $('#form-filter')[0].reset();
                            $("#nama_produksi").select2("destroy");
                            $("#nama_produksi").select2({
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
