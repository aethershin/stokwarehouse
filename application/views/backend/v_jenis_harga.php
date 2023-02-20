
<div class="page-content">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
            <div class="card-body">
                
                <a class="btn icon btn-sm btn-success float-end" onclick="add_jharga()"><i class="bi bi-plus"></i></a></i></a>&nbsp;&nbsp;
                <br/><br/>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jenis Harga</th>
                            <th>Kategori</th>
                            <th>Jenis Harga</th>
                            <th>Aksi</th>
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
    table = $('#mytable').DataTable({ 

        "processing": true,
        "serverSide": true,
        "order": [], 

        "ajax": {
            "url": "<?php echo site_url('backend/jenis_harga/get_ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
               
              
            }
        },


        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4 ], 
            "orderable": false, 
        },
        ],

    });
    
            
    
    let dataTable = new simpleDatatables.DataTable(
                document.getElementById("mytable")
            );
    $("#nama").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("#harga").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    

});



function add_jharga()
{
    save_method = 'add';
    $('#formjharga')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form_jharga').modal('show');
    $('.modal-title').text('Tambah Jenis Harga');
    $("#kategori_stock").select2({
        dropdownParent: $("#modal_form_jharga"),
        cache: false,
        theme: "bootstrap-5",
    });
}
            
function edit_jharga(kode_jharga)
{
    save_method = 'update';
    $('#formjharga')[0].reset();
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form_jharga').modal('show'); 
    $('.modal-title').text('Edit Jenis Harga'); 
    
    $.ajax({
        url : "<?php echo site_url('backend/jenis_harga/ajax_edit/')?>/" + kode_jharga,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

                
                $("#kategori_stock").select2({
                    dropdownParent: $("#modal_form_jharga"),
                    cache: false,
                    theme: "bootstrap-5",
                }).val(data.kategori_jenis).trigger("change");
                $('[name="id"]').val(data.kode_jharga);
                $('[name="nama"]').val(data.nama_jenis_harga);
                $('[name="harga"]').val(data.jenis_harga);
                $('#modal_form_jharga').modal('hide'); 
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

function addjharga()
{
    

    $('#btnSave').text('saving...'); 
    $('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('backend/jenis_harga/add')?>";
    } else {
        url = "<?php echo site_url('backend/jenis_harga/edit')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#formjharga').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {
                toastify_success();
                $('#modal_form_jharga').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                   
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
            title: "Apakah kamu yakin ingin menghapus Jenis Harga ini?",
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
                    url : "<?php echo site_url('backend/jenis_harga/delete')?>",
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
