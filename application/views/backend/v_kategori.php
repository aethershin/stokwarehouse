
<div class="page-heading">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
            <div class="card-body">
                
                <a class="btn icon btn-sm btn-success float-end" onclick="add_kategori()"><i class="bi bi-plus"></i></a>
                <br/><br/>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
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

        "processing": true,
        "serverSide": true,
        "order": [], 

        "ajax": {
            "url": "<?php echo site_url('backend/kategori/get_ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.nama_kategori = $('#nama_kategori').val();
              
            }
        },


        "columnDefs": [
        { 
            "targets": [ 0 ], 
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
    

});



function add_kategori()
{
    save_method = 'add';
    $('#formkategori')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form_kategori').modal('show');
    $('.modal-title').text('Tambah Kategori');
   
}
            
function edit_kategori(id_kategori)
{
    save_method = 'update';
    $('#formkategori')[0].reset();
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form_kategori').modal('show'); 
    $('.modal-title').text('Edit Kategori'); 
    
    $.ajax({
        url : "<?php echo site_url('backend/kategori/ajax_edit/')?>/" + id_kategori,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            
                $('[name="id"]').val(data.id_kategori);
                $('[name="nama"]').val(data.nama_kategori);

                $('#modal_form_kategori').modal('hide'); 
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

function addkategori()
{
    

    $('#btnSave').text('saving...'); 
    $('#btnSave').attr('disabled',true); 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('backend/kategori/add')?>";
    } else {
        url = "<?php echo site_url('backend/kategori/edit')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#formkategori').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {
                toastify_success();
                $('#modal_form_kategori').modal('hide');
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
            title: "Apakah kamu yakin ingin menghapus Kategori ini?",
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
                    url : "<?php echo site_url('backend/kategori/delete')?>",
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
