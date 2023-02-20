
<div class="page-content">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    
    


    <!-- Post Datatables -->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                   
            <div class="card-body">

                
                <div class="btn-group mb-3  float-end" role="group" aria-label="Basic example">
                <a class="btn icon btn-sm btn-success" id="btn-validate-import" onclick="add_person()"><i class="bi bi-plus"></i></a>

                </div>
                <br/><br/>
                <div class="table-responsive">
                    <table id="mytable" class="table mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Poto Profil</th>
                            <th class="col-4">Email</th>
                            <th class="col-2">Nama</th>
                            <th class="col-2">Tipe Akun</th>
                            <th class="col-2">Status</th>
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

var save_method; //for save method string
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

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/users/get_ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
              
            }
        },

        //Set column definition initialisation properties.

        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4,5,6 ],
            "orderable": false, //set not orderable
        },
        ],

    });
   
          


            
            
    

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("#nama").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    $("#user_photo").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    $("#email").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    $("#formselectvalidate").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    $("#password").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    $("#conf_pass").change(function(){
        $(this).parent().parent().removeClass('help-block text-danger');
        $(this).next().empty();
    });
    let dataTable = new simpleDatatables.DataTable(
        document.getElementById("mytable")
    );
});



function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.show_edit').empty(); // clear error class
    $('.show_img').empty(); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Users Admin'); // Set Title to Bootstrap modal title bg-success 
    $("#level").select2({
        dropdownParent: $("#modal_form"),
        cache: false,
        theme: "bootstrap-5",
    });
   
}
            
function edit_person(user_id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Edit Users Admin'); // Set title to Bootstrap modal title
    $('.show_edit').text('*Kosongkan Form Gambar dan Password jika tidak ingin menggantinya'); // Set title to Bootstrap modal title
    
    var base_url = '<?php echo base_url(); ?>';
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('backend/users/ajax_edit/')?>/" + user_id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            
                $('[name="id"]').val(data.user_id);
                $('[name="email"]').val(data.user_email);
                $('[name="nama"]').val(data.user_name);
                $(".show_img").html('<img src="'+base_url+'assets/images/profilusers/'+data.user_photo+'" width="150" height="150" class="rounded img-thumbnail">');
                $('[name="old_image"]').val(data.user_photo);
                $("#level").select2({
                    dropdownParent: $("#modal_form"),
                    cache: false,
                    theme: "bootstrap-5",
                }).val(data.user_level).trigger("change");

                $('#modal_form').modal('hide'); // show bootstrap modal
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function proc()
{
    // ADD PROCESS
    var id = $(".id").val();
    var nama = $(".nama").val();
    var email = $(".email").val();
    var password = $(".password").val();
    var conf_pass = $(".conf_pass").val();
    var level = $(".level").val();
    var user_photo = $("#user_photo")[0].files[0];
    
    var fd = new FormData();    
    fd.append("id", id);
    fd.append("nama", nama);
    fd.append("email", email);
    fd.append("password", password);
    fd.append("conf_pass", conf_pass);
    fd.append("level", level);
    fd.append("user_photo", user_photo);
    // ADD PROCESS

    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('backend/users/add')?>";
    } else {
        url = "<?php echo site_url('backend/users/edit')?>";
    }

    // ajax adding data to database
    $.ajax({
        type: "POST",
        url : url,
        data: fd,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                toastify_success();
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                   
                }
            }
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });

}




    $(document).on("click", "#del", function(e) {
        e.preventDefault();

        var user_id = $(this).attr("value");

        Swal.fire({
            title: "Apakah kamu yakin ingin menghapus User ini?",
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
                    url : "<?php echo site_url('backend/users/delete')?>",
                    data: {
                        user_id: user_id,
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


    $(document).on("click", "#lock", function(e) {
        e.preventDefault();

        var user_id = $(this).attr("value");

        Swal.fire({
            title: "Lock/ Unlock Akun ini ?",
            text: "Akun yang di lock tidak akan bisa login sampai Akun di unlock kembali!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Proses!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/users/lock')?>",
                    data: {
                        user_id: user_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Success!",
                                "Proses berhasil dilakukan.",
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
