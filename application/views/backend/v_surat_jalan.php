
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
                            <h5>Ada Produk yang belum selesai di Proses, Tekan <span class="text-success"> Buat Surat Jalan</span> dibawah untuk menyelesaikannya</h5>
                            <button type="button btn-sm" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> 
                    
                <?php else:?>

                <?php endif;?>
                </div>
                        
                <?php $this->load->view("backend/modal/surat_jalan_modal.php") ?>
                
                <br/><br/>
              
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="col-4">Nama Produk</th>
                                <th class="col-4">Jumlah</th>
                              
                                <th class="col-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <th colspan="2" style="text-align:right"></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br/>
                <form id="form-tambahstokbahan">
                    <div class="row">
                           
                        <div class="col-12 col-md-12">
                            <div class="form-floating">

                                <textarea class="form-control catatan" placeholder="Catatan *Opsional" name="catatan" id="catatan_produksi"></textarea>
                                <label for="floatingTextarea">Catatan *Opsional</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                                <label for="valid-state">Diserahkan</label>
                                <select class="form-select diserahkan" name="diserahkan" id="diserahkan" style="width:100%" required>
                                    <option value="">[Pilih Karyawan]</option>
                                    <?php foreach ($karyawan->result() as $row) : ?>
                                        <option value="<?php echo $row->user_name;?>"><?php echo $row->user_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="valid-state">Penerima</label>
                                <select class="form-select penerima" name="penerima" id="penerima" style="width:100%" required>
                                    <option value="">[Pilih Karyawan]</option>
                                    <?php foreach ($karyawan->result() as $row) : ?>
                                        <option value="<?php echo $row->user_name;?>"><?php echo $row->user_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="valid-state">Diketahui</label>
                                <select class="form-select diketahui" name="diketahui" id="diketahui" style="width:100%" required>
                                    <option value="">[Pilih Karyawan]</option>
                                    <?php foreach ($karyawan->result() as $row) : ?>
                                        <option value="<?php echo $row->user_name;?>"><?php echo $row->user_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                     
                       
                    </div>   
                    
               
                        <input type="hidden"  name="totaljumlah" class="totaljumlah"/>
                  
                        <div class="col-12 col-md-12 mt-3">
                            <div class="btn-group">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="prosessuratjalan" class="btn btn-success"><i class="bi bi-save"></i> Buat Surat Jalan</button>
                                
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
    
            $('#page-heading').on('click','.rekap',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_surat_jalan/";
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
            "url": "<?php echo site_url('backend/surat_jalan/get_ajax_list')?>",
            "type": "POST",
            
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3 ], //first column
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
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            
           
            // Update footer
          
            $('.totaljumlah').val(total);
            
         
            $( api.column( 2 ).footer() )
            .html(
                
                'Total Jumlah :'+total

            );
            

       
        },

    });

   
   
    $("#bahan_baku,#diserahkan,#penerima,#diketahui").select2({
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
                alert_transaksi_kosong();
            } else {
      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/surat_jalan/add')?>",
                    data: {
                        bahan_baku: bahan_baku,jumlah: jumlah
                    },
                    dataType: "json",
                    success: function(response) {
                
                            if (response.res == "success") {
                                
                                alert_sukses_tambah_transaksi();
                                reload_table();
                            } else if(response.res == "error") {
                                alert_stok_kosong_transaksi();
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
                    url : "<?php echo site_url('backend/surat_jalan/delete')?>",
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

    $(document).on("click", "#minus", function(e) {
        e.preventDefault();

        var ls_surat_jalan_id = $(this).attr("value");

       
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/surat_jalan/minus')?>",
                    data: {
                        ls_surat_jalan_id: ls_surat_jalan_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                                reload_table();
                            } else if(response.res == "error") {
                                alert_stok_berlebihan_transaksi();
                            } else {

                            }
                    },
                });
          
    });

    $(document).on("click", "#plus", function(e) {
        e.preventDefault();

        var ls_surat_jalan_id = $(this).attr("value");

      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/surat_jalan/plus')?>",
                    data: {
                        ls_surat_jalan_id: ls_surat_jalan_id,
                    },
                    dataType: "json",
                    success: function(response) {
                
                            if (response.res == "success") {
                                reload_table();
                            } else if(response.res == "stok_habis") {
                                alert_stok_habis_transaksi();
                            } else {

                            }
                    },
                });
           
    });


    $(document).on("click", "#prosessuratjalan", function(e) {
        e.preventDefault();
        var catatan = $('.catatan').val();
        var totaljumlah = $('.totaljumlah').val();

        var diserahkan = $('.diserahkan').val();
        var penerima = $('.penerima').val();
        var diketahui = $('.diketahui').val();
            if (totaljumlah == "" || totaljumlah == 0 || diserahkan == "" || penerima == "" || diketahui == "") {
                alert_form_sj_kosong();
            } else {


                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/surat_jalan/prosessuratjalan')?>",
                    data: {
                        catatan: catatan,totaljumlah:totaljumlah, diserahkan:diserahkan, penerima:penerima, diketahui:diketahui
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Ditambah!",
                                "Surat Jalan Berhasil dibuat.",
                                "success"
                            );
                            $('#form-tambahstokbahan')[0].reset();
                            $("#bahan_baku,#diserahkan,#penerima,#diketahui").select2("destroy");
                            $("#bahan_baku,#diserahkan,#penerima,#diketahui").select2({
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
