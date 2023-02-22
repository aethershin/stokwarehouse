
<div class="page-content">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-7 order-md-1 order-last" id="page-heading">
                <h4><?php echo $title; ?> <a href="javascript:void(0);" class="btn icon btn-sm btn-primary buat"><i class="bi bi-files"></i> Buat Surat Jalan</a></h4>
                
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
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">

            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0 text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Surat Jalan</th>
                            <th>Total Jumlah</th>
                            <th>Riwayat Ekspedisi</th>
                            <th>Diinput Oleh</th>
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
var csfrData = {};
csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo
$this->security->get_csrf_hash(); ?>';
$.ajaxSetup({
data: csfrData
});
$(document).ready(function() {
            $('#page-heading').on('click','.buat',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/surat_jalan/";
            });
    //datatables
    table = $('#mytable').DataTable({ 

        "processing": true,
        "serverSide": true,
       
        "order": [], 

        "ajax": {
            "url": "<?php echo site_url('backend/rekap_surat_jalan/get_ajax_list')?>",
            "type": "POST",
            "data": function (data) {
                
                
                
                
            },
        },


        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4,5 ], 
            "orderable": false, 
        },
        ],
        

    });
            $('#mytable').on('click','.detail',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_surat_jalan/detail/"+id+"";
            });
            $('#mytable').on('click','.d-nota',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_surat_jalan/nota_pdf/"+id+"";
            });
      
    $("#nama_produksi").select2({
        cache: false,
        theme: "bootstrap-5",
    });
    $('#btn-filter').click(function(){ 
        reload_table(); 
    });
    $('#btn-reset').click(function(){ 
        $('#form-filter')[0].reset();
        $("#nama_produksi").select2("destroy");
        $("#nama_produksi").select2({
                cache: false,
                theme: "bootstrap-5",
        });
        reload_table();
    });        
    
    

});

function reload_table()
{
    table.ajax.reload(null,false); 
}

$(document).on("click", "#del", function(e) {
        e.preventDefault();

        var id = $(this).attr("value");
        Swal.fire({
            title: "Apakah kamu yakin ingin membatalkan Surat Jalan ini?",
            text: "Data ini akan di batalkan secara Permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/rekap_surat_jalan/delete')?>",
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

</script>

</body>
</html>
