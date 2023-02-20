
<div class="page-content">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    <section class="row">

        <div class="col-12 col-lg-9">
                   
            <div class="row">
                       
                        
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <form id="form-filter1"> 
                        <div class="card-body px-1 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                   
                                    <input type="hidden" id="kategori_material1">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <a  id="btn-filter1" data-bs-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true"><h6 class="text-muted font-semibold"><b><i class="bi bi-eye">Click</i> Material Packing</b></h6></a>
                                    </ul>
                                     
                                   
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            
             
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <form id="form-filter2"> 
                        <div class="card-body px-1 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="hidden" id="kategori_material1">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <a  id="btn-filter2"  data-bs-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true"><h6 class="text-muted font-semibold"><b><i class="bi bi-eye">Click</i> Material Fittings</b></h6></a>
                                    </ul>
                                   
                                
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            
            
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <form id="form-filter3"> 
                        <div class="card-body px-1 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="hidden" id="kategori_material1">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <a id="btn-filter3" data-bs-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true"><h6 class="text-muted font-semibold"><b><i class="bi bi-eye">Click</i> Material Alat</b></h6></a>
                                    </ul>
                                   
                                    
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <form id="form-filter4"> 
                        <div class="card-body px-1 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="hidden" id="kategori_material1">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <a id="btn-filter4" data-bs-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true"><h6 class="text-muted font-semibold"><b><i class="bi bi-eye">Click</i> Material Product</b></h6></a>
                                    </ul>
                                    
                                   
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
<!-- TEST -->
               
                
<!-- TEST -->
            </div>
           
           
        </div>
        <div class="col-6 col-lg-3 col-md-6">
           
                    <div class="card">
                        <form id="form-filter5"> 
                        <div class="card-body px-1 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="hidden" id="kategori_material1">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <a id="btn-filter5" href="javascript:void()"><h6 class="text-muted font-semibold"><b><i class="bi bi-eye">Click</i> Product Ready Sale</b></h6></a>
                                    </ul>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
              
                
                    
                
            
        </div>
        
    </section>
    


    <!-- Post Datatables -->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                   
            <div class="card-body">
               
                
                
                <div class="btn-group mb-3  float-end" role="group" aria-label="Basic example">
                <a class="btn icon btn-sm btn-success" id="btn-validate-import" onclick="add_stockproduksi()"><i class="bi bi-plus"></i></a>&nbsp;&nbsp;

                </div>
                <br/><br/>

                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0 text-sm">
                    <thead>
                        <tr>

                               
                                    
                                    <th class="col-4">Nama</th>
                                    <th class="col-4">Kategori</th>
                                    <th class="col-2">Stok</th>
                                    <th class="col-4">Nilai Saham</th>
                                    <th class="col-1">Aksi</th>
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
   
<!------- TOASTIFY JS --------->


<script type="application/javascript">

var save_method; 
var table;

$(document).ready(function() {
    

    //datatables
    table = $('#mytable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/warehouse_product_ready_sale/get_ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.nama_stock2 = $('#nama_stock2').val();
                data.kategori_stock2 = $('#kategori_stock2').val();
                data.switches = $('#switches').val();
                
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3 ], //first column
                "orderable": false, //set not orderable
            },
            
        ],

        

    });
    
    $("#kategori_stock2").select2({
            cache: false,
            theme: "bootstrap-5",
    });
    $('#btn-filter').click(function(){ 
        reload_table(); 
    });
    $('#btn-reset').click(function(){ 
        $('#form-filter')[0].reset();
        $("#kategori_stock2").select2("destroy");
        $("#kategori_stock2").select2({
                cache: false,
                theme: "bootstrap-5",
        });
        reload_table();
    });

            
    $('#btn-filter1').click(function(){ 
        var id = $(this).data('id');
        var site_url = '<?php echo site_url();?>';
        window.location.href = site_url+"backend/warehouse/"; 
    });

    $('#btn-filter2').click(function(){ 
        var id = $(this).data('id');
        var site_url = '<?php echo site_url();?>';
        window.location.href = site_url+"backend/warehouse/";
    });
    $('#btn-filter3').click(function(){ 
        var id = $(this).data('id');
        var site_url = '<?php echo site_url();?>';
        window.location.href = site_url+"backend/warehouse/";
    });
    $('#btn-filter4').click(function(){
        var id = $(this).data('id');
        var site_url = '<?php echo site_url();?>';
        window.location.href = site_url+"backend/warehouse/";
        
        
    });
    $('#btn-filter5').click(function(){ 
        var id = $(this).data('id');
        var site_url = '<?php echo site_url();?>';
        window.location.href = site_url+"backend/warehouse_product_ready_sale/";
    });


    $("#nama_stock").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    $("#image_stock").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
   
    $("#stock_minimal").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    
});



function add_stockproduksi()
{
    save_method = 'add';
    $('#formstockproduksi')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.show_record').empty(); 
    $('.help-block').empty(); 
    $(".aeth").hide(); 
    $('#modal_form_stockproduksi').modal('show'); 
    $('.show_img').empty(); // clear error class
    $('.modal-title').text('Tambah Produk Ready Sale'); 
    $("#kategori_stock,#satuan_stock").select2({
        dropdownParent: $("#modal_form_stockproduksi"),
        cache: false,
        theme: "bootstrap-5",
    });
}
            
function edit_stockproduksi(kode_stock)
{
    save_method = 'update';
    $('#formstockproduksi')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $(".aeth").show(); 
    $('#modal_form_stockproduksi').modal('show'); 
    $('.modal-title').text('Edit Produk Ready Sale'); 
    
    
    var base_url = '<?php echo base_url(); ?>';
   
    $.ajax({
        url : "<?php echo site_url('backend/warehouse_product_ready_sale/ajax_edit/')?>/" + kode_stock,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
                $('#modal_form_stockproduksi').on('click','.aeth',function(){
                    var id_qr = data.kode_stock;
                    var site_url = '<?php echo site_url();?>';
                    window.location.href = site_url+"backend/warehouse_product_ready_sale/download_qr/"+id_qr+"";
                });
            
                $('[name="id"]').val(data.kode_stock);
                $('[name="nama_stock"]').val(data.nama_stock);
                $('[name="stock_minimal"]').val(data.stock_minimal);
                $(".show_img").html('<img src="'+base_url+'assets/images/qrcode/'+data.kode_stock+'.png" width="150" height="150" class="rounded img-thumbnail">');

                
                
                $(".show_record").html('<code>Last Update: '+data.tgl_ubah+' | </code><code>'+data.user_name+'</code>');

                $("#kategori_stock").select2({
                    dropdownParent: $("#modal_form_stockproduksi"),
                    cache: false,
                    theme: "bootstrap-5",
                }).val(data.kategori_stock).trigger("change");
                $("#satuan_stock").select2({
                    dropdownParent: $("#modal_form_stockproduksi"),
                    cache: false,
                    theme: "bootstrap-5",
                }).val(data.satuan_stock).trigger("change");

                
               

                $('#modal_form_stockproduksi').modal('hide'); 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); 
}

function addstockproduksi()
{
    
   

    $('#btnSave').text('saving...'); 
    $('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('backend/warehouse_product_ready_sale/add')?>";
    } else {
        url = "<?php echo site_url('backend/warehouse_product_ready_sale/edit')?>";
    }

    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formstockproduksi').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {
                toastify_success();
                $('#modal_form_stockproduksi').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                    $("#kategori_stock,#satuan_stock").select2({
                        dropdownParent: $("#modal_form_stockproduksi"),
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
                    url : "<?php echo site_url('backend/warehouse_product_ready_sale/delete')?>",
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

</script>

</body>
</html>
