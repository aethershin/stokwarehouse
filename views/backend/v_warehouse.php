        
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3 class="namepage"><?php echo $title; ?></h3>
                
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header float-start float-lg-end'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('backend/dashboard');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
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
                                        <a id="btn-filter5" href="#home2"><h6 class="text-muted font-semibold"><b><i class="bi bi-eye">Click</i> Product Ready Sale</b></h6></a>
                                    </ul>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
              
                
                    
                
            
        </div>
        
    </section>
           
   
    
<section id="input-validation">
   <div class="row">     
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                
            </div>
            <!-- ISI -->
            <div class="fade" id="home2" role="tabpanel" aria-labelledby="home2">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                       
                        
                        <div class="btn-group mb-3  float-end" role="group" aria-label="Basic example">
                            <a class="btn icon btn-sm btn-success btn-add" id="btn-add" onclick="add_stock()"><i class="bi bi-plus"></i></a>

                            
                        </div>
                <br/><br/>

                            <div class="table-responsive">
                                <table id="mytable" class="table table-bordered mb-0 text-sm">
                                    <thead>
                                        <tr>  
                                        
                                            <th class="col-4">Nama</th>
                                            <th class="col-4">Harga Beli</th>
                                            <th class="col-2">Stok</th>
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
            <!-- ISI -->

            
        </div> 
    </div>            
</section>
    

    
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
        "language": {                
            "infoFiltered": ""
        },
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/warehouse/get_ajax_list')?>",
            "type": "POST",
            "data": function (data) {
               data.kategori_material1 = $('#kategori_material1').val();
            },

        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3 ], //first column
                "orderable": false, //set not orderable
            },
            
        ],

        

    });
    
    
    $('#btn-filter1').click(function(){ 
        var kat1 = 'Material Packing';
        var kategori_material1 = $('#kategori_material1').val(kat1);
        var warehouse = 'Warehouse';
        $('.namepage').html(warehouse+' '+kat1);
     
        $('.stock').hide(); 
        
        reload_table(); 
    });

    $('#btn-filter2').click(function(){ 
        var kat2 = 'Material Fittings';
        var kategori_material1 = $('#kategori_material1').val(kat2);
        var warehouse = 'Warehouse';
        $('.namepage').html(warehouse+' '+kat2);
      
        $('.stock').hide(); 
        reload_table(); 
    });
    $('#btn-filter3').click(function(){ 
        var kat3 = 'Material Alat';
        var kategori_material1 = $('#kategori_material1').val(kat3);
        var warehouse = 'Warehouse';
        $('.namepage').html(warehouse+' '+kat3);
       
        $('.stock').show(); 
        reload_table(); 
    });
    $('#btn-filter4').click(function(){ 
        var kat4 = 'Material Product';
        var kategori_material1 = $('#kategori_material1').val(kat4);
        var warehouse = 'Warehouse';
        $('.namepage').html(warehouse+' '+kat4);
        
        $('.stock').hide(); 
        reload_table(); 
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
    $("#harga_beli").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
   
    $("#stock_minimal").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    
});



function add_stock()
{
    save_method = 'add';
    $('#formstock')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.show_record').empty(); 
    $('.help-block').empty(); 
    $('#modal_form_stock').modal('show'); 
    $('.show_img').empty(); 
    $(".aeth").hide(); 
    $('.modal-title').text('Tambah Material');
    $("#kategori_stock,#satuan_stock").select2({
        dropdownParent: $("#modal_form_stock"),
        cache: false,
        theme: "bootstrap-5",
    });
    
    var jas = $('#kategori_material1').val();
    $(".modal-body #kategori_material").val(jas);
    
    
}
       
function edit_stock(id_stock)
{
    save_method = 'update';
    $('#formstock')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form_stock').modal('show'); 
    $(".aeth").show(); 
    $('.modal-title').text('Edit Material'); 
    
    
    var base_url = '<?php echo base_url(); ?>';
   
    $.ajax({
        url : "<?php echo site_url('backend/warehouse/ajax_edit/')?>/" + id_stock,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
                $('#modal_form_stock').on('click','.aeth',function(){
                    var id_qr = data.kode_stock;
                    var site_url = '<?php echo site_url();?>';
                    window.location.href = site_url+"backend/warehouse/download_qr/"+id_qr+"";
                });
            
                $('[name="id"]').val(data.id_stock);
                $('[name="nama_stock"]').val(data.nama_stock);
                $('[name="harga_beli"]').val(data.harga_beli);
                
                $('[name="stock_minimal"]').val(data.stock_minimal);
                $('[name="kategori_material"]').val(data.kategori_material);
                
                $(".show_img").html('<img src="'+base_url+'assets/images/qrcode/'+data.kode_stock+'.png" width="150" height="150" class="rounded img-thumbnail">');
                
                $(".show_record").html('<code>Last Update: '+data.tgl_ubah+' | </code><code>'+data.user_name+'</code>');

                $("#kategori_stock").select2({
                    dropdownParent: $("#modal_form_stock"),
                    cache: false,
                    theme: "bootstrap-5",
                }).val(data.kategori_stock).trigger("change");
                $("#satuan_stock").select2({
                    dropdownParent: $("#modal_form_stock"),
                    cache: false,
                    theme: "bootstrap-5",
                }).val(data.satuan_stock).trigger("change");
                
               

                $('#modal_form_stock').modal('hide'); 
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

function addstock()
{
    
    

    $('#btnSave').text('saving...'); 
    $('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('backend/warehouse/add')?>";
    } else {
        url = "<?php echo site_url('backend/warehouse/edit')?>";
    }

    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formstock').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {
                toastify_success();
                $('#modal_form_stock').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                    $("#kategori_stock,#satuan_stock").select2({
                        dropdownParent: $("#modal_form_stock"),
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
                    url : "<?php echo site_url('backend/warehouse/delete')?>",
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


// PRODUKSI


</script>

</body>
</html>
