
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <a href="#" class="btn icon btn-sm btn-primary" id="masuk" href="javascript:void()" value="<?php echo $id; ?>"><i class="bi bi-check"></i> Absen Masuk</a>
                    </div>

                    <div class="col-12 col-md-2 float-end">
                        <a href="#" class="btn icon btn-sm btn-danger" id="keluar" href="javascript:void()" value="<?php echo $id; ?>"><i class="bi bi-check"></i> Absen Pulang</a>
                    </div>
                
               
                </div>
                <br/><br/>
                <p class="text-subtitle text-muted">Filter Data</p>
                        <form id="form-filter">
                            <div class="row">
                        <?php if($this->session->userdata('access')=='1'):?>     
                            <div class="col-12 col-md-4">
                                <select class="form-select id_user_absensi" name="id_user_absensi" id="id_user_absensi" style="width:100%" required>
                                    <option value="">[Pilih Karyawan]</option>
                                    <?php foreach ($karyawan->result() as $row) : ?>
                                        <option value="<?php echo $row->user_id;?>"><?php echo $row->user_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        <?php else:?>
           
                        <?php endif;?>
                            <div class="col-12 col-md-4">
                                <select class="form-select kehadiran" name="kehadiran" id="kehadiran" style="width:100%" required>
                                    <option value="">[Pilih Keterangan]</option>
                                    <option value="Tepat Waktu">Tepat Waktu</option>
                                    <option value="Terlambat">Terlambat</option>
                                </select>
                            </div>
                            
                            
                            <div class="col-12 col-md-4">
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <button type="button" id="btn-filter" class="btn btn-primary"><i class="bi bi-search"></i> Filter Data</button>&nbsp;&nbsp;
                                    <button type="button" id="btn-reset" class="btn btn-success"><i class="bi bi-bootstrap-reboot"></i> Refresh</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    <hr>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Keterangan</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
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
        "searching": false,
        "order": [], 

        "ajax": {
            "url": "<?php echo site_url('backend/absensi/get_ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.id_user_absensi = $('#id_user_absensi').val();
                data.kehadiran = $('#kehadiran').val();
            }
        },


        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4 ], 
            "orderable": false, 
        },
        ],

    });
    
            
    $('#btn-filter').click(function(){ 
        table.ajax.reload();  
    });
    $('#btn-reset').click(function(){ 
        $('#form-filter')[0].reset();
        $("#id_user_absensi,#kehadiran").select2("destroy");
        $("#id_user_absensi,#kehadiran").select2({
                cache: false,
                theme: "bootstrap-5",
        });
        table.ajax.reload(); 
    });

            $("#id_user_absensi,#kehadiran").select2({
                cache: false,
                theme: "bootstrap-5",
            }); 
    let dataTable = new simpleDatatables.DataTable(
                document.getElementById("mytable")
            );
    $("#nama").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    

});



function reload_table()
{
    table.ajax.reload(null,false); 
}

    $(document).on("click", "#masuk", function(e) {
        e.preventDefault();

        var id = $(this).attr("value");
        Swal.fire({
            title: "Absen Masuk Hari Ini",
            text: "Klik YA, untuk Absen masuk Harian!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/absensi/masuk')?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Berhasil!",
                                "Anda Sudah Absen Masuk Hari ini!",
                                "success"
                            );
                            reload_table();
                        } else if (response.res == "errorduplicateabsen") {
                            Swal.fire(
                                "Gagal!",
                                "Anda Sudah mengklik Absen Masuk Harian!",
                                "error"
                            );
                            reload_table();
                        } else if (response.res == "errorbelumjamkerja") {
                            Swal.fire(
                                "Gagal!",
                                "Lakukan Absen pada jam 07:00 sampai 12:00!",
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

    $(document).on("click", "#keluar", function(e) {
        e.preventDefault();

        var id = $(this).attr("value");
        Swal.fire({
            title: "Absen Keluar Hari Ini",
            text: "Klik YA, untuk Absen Keluar Harian!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/absensi/keluar')?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Berhasil!",
                                "Anda Sudah Absen Keluar Hari ini!",
                                "success"
                            );
                            reload_table();
                        } else if (response.res == "errorduplicateabsen") {
                            Swal.fire(
                                "Gagal!",
                                "Anda Sudah mengklik Absen Keluar Harian!",
                                "error"
                            );
                            reload_table();
                        } else if (response.res == "errormasukdulu") {
                            Swal.fire(
                                "Gagal!",
                                "Anda Belum Absen Masuk, Silahkan Absen Masuk dahulu!",
                                "error"
                            );
                            reload_table();
                        } else if (response.res == "errorbelumjampulang") {
                            Swal.fire(
                                "Gagal!",
                                "Lakukan Absen Pulang pada jam 17:00 sampai 19:00!",
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
