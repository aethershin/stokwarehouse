
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
                <div id="peringatan">
                <?php if($produksi_belum_selesai > 0):?> 

                        <div class="alert alert-light-warning color-warning alert-dismissible show fade clear-notif-warning">
                            <h5>Ada Produk yang belum selesai di Proses, Tekan <span class="text-success"> Input</span> dibawah untuk menyelesaikannya</h5>
                            <button type="button btn-sm" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> 
                    
                <?php else:?>

                <?php endif;?>
                </div>
                        
                <?php $this->load->view("backend/modal/retur_modal.php") ?>
                
                <br/><br/>
              
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="col-2">Kode Surat Jalan</th>
                                <th class="col-2">Nama Produk</th>
                                <th>Jumlah</th>
                                <th class="col-4">Riwayat Retur</th>
                                <th>Aksi</th>
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

$(document).ready(function() {
  
    //datatables
    


    table = $('#mytable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        "lengthChange": false,
        "paging": false,
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('backend/retur_barang_ekspedisi/get_ajax_list')?>",
            "type": "POST",
            
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3,4 ], //first column
                "orderable": false, //set not orderable
            },
            
        ],

        

    });

   
   
    $("#bahan_baku,#diserahkan,#penerima,#diketahui,#kode_surat_jalan").select2({
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
        var kode_surat_jalan = $('.kode_surat_jalan').val();
      

            if (bahan_baku == "" || jumlah == 0 || kode_surat_jalan == "") {
                alert_retur_kosong();
            } else {
      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/retur_barang_ekspedisi/add')?>",
                    data: {
                        bahan_baku: bahan_baku,jumlah: jumlah, kode_surat_jalan: kode_surat_jalan
                    },
                    dataType: "json",
                    success: function(response) {
                
                            if (response.res == "success") {
                                
                                alert_sukses_tambah_transaksi();
                                reload_table();
                            } else if(response.res == "error") {
                                alert_retur_kosong();
                            } else if(response.res == "duplicate") {
                                
                                alert_duplicate_produk_transaksi();
                            } else if(response.res == "stok_habis") {
                                
                                alert_stok_habis_transaksi();
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
                    url : "<?php echo site_url('backend/retur_barang_ekspedisi/delete')?>",
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

<script>
        var urlProduk = "<?php echo base_url('databasejson/produk.json')?>";
      


        function clearOptions(id) {
            console.log("on clearOptions :" + id);

            //$('#' + id).val(null);
            $('#' + id).empty().trigger('change');
        }

        console.log('Load Produk...');
        $.getJSON(urlProduk, function (res) {

            res = $.map(res, function (obj) {
                obj.text = obj.nama
                return obj;
            });

            data = [{
                id: "",
                nama: "[Pilih Produk]",
                text: "[Pilih Produk]"
            }].concat(res);

          
            $("#bahan_baku").select2({
                cache: false,
                theme: "bootstrap-5",
                data: data
            })
        });

       

        
    </script>
</body>
</html>
