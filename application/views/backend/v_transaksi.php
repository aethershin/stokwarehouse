
<div class="content-wrapper container">
    


    <!-- Post Datatables -->
    
        
            <div class="card">
                <div id="peringatan">
                <?php if($produksi_belum_selesai > 0):?> 

                        <div class="alert alert-light-warning color-warning alert-dismissible show fade clear-notif-warning">
                            <h5>Ada Produk yang belum selesai di Proses, Tekan <span class="text-success">Proses Transaksi</span> dibawah untuk menyelesaikannya</h5>
                            <button type="button btn-sm" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> 
                    
                <?php else:?>

                <?php endif;?>
                </div>
                <div class="row">
                    <div class=" col-12 col-md-8">
                        <div class="list-group">   
                            <div class="list-group-item list-group">
                                <?php $this->load->view("backend/modal/transaksi_modal.php") ?>
                            </div>
                        </div>
                    </div>
                    <div class=" col-12 col-md-4">
                        <div class="list-group">   
                            <div class="list-group-item list-group">
                                <form id="form-tambahstokbahan">
                                    <div class="row">
                                            
                                        <div class="col-12 col-md-12">
                                            <div class="form-floating">

                                                <textarea class="form-control catatan" placeholder="Catatan *Opsional" name="catatan" id="catatan_produksi"></textarea>
                                                <label for="floatingTextarea">Catatan *Opsional</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="valid-state">Jenis Transaksi</label>
                                                        <select class="form-select jtransaksi" name="jtransaksi" id="jtransaksi" style="width:100%" onchange="showDiv('hidden_div', this)" required>
                                                                <option value="" >[Pilih Jenis Transaksi]</option>
                                                            
                                                                <option value="1">Cash</option>
                                                                <option value="2">Cicil</option>
                                                                
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="hidden_div">
                                                    <div class="col-12 col-md-12">
                                                        
                                                        <div class="form-group">
                                                            <label for="valid-state">Tenor</label>
                                                            <select class="form-select tenor" name="tenor" id="tenor" style="width:100%"  required>

                                                                <option value="">[Pilih Tenor]</option>
                                                                <?php foreach ($jcicilan->result() as $row) : ?>
                                                                    <option value="<?php echo $row->id_jenis_cicilan;?>"><?php echo $row->nama_cicilan;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="col-12 col-md-12">
                                                <div class="kettotal float-end"></div>
                                            </div>
                                        </div>
                                            <input type="hidden"  name="totalbiaya" class="totalbiaya"/>
                                            <input type="hidden"  name="totaljumlah" class="totaljumlah"/>
                                  
                                        <div class="col-12 col-md-12">
                                            <div class="btn-group">
                                                <button type="button" id="prosestransaksikonsumen" class="btn btn-success"><i class="bi bi-save"></i> Proses Transaksi</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="list-group"> 
                        <div class="table-responsive">
                            <table id="mytable" class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th class="col-5">Nama Produk</th>
                                        <th class="col-1">Jumlah</th>
                                        <th class="col-3">Total</th>
                                        <th class="col-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                
                
               
                    
              
           

                            
                        
            </div>

            <!------- FOOTER --------->
            <?php $this->load->view("backend/_partials/footer.php") ?>
        <!------- FOOTER --------->
        
   
</div>
    <!-- Post Datatables END -->

    

    
        
        </div>
    </div>
<script src="<?php echo base_url().'assets/js/pages/horizontal-layout.js'?>"></script>

<!------- TOASTIFY JS --------->
    <?php $this->load->view("backend/_partials/toastify.php") ?>
    
<!------- TOASTIFY JS --------->
<script type="application/javascript">
        function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 2 ? 'block' : 'none';
}
</script>


<script type="text/javascript">

var save_method; 
var table;

$(document).ready(function() {
  
    //datatables
            $('#page-heading').on('click','.rekap',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/";
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
            "url": "<?php echo site_url('backend/transaksi/get_ajax_list')?>",
            "type": "POST",
            
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0,1,2,3], //first column
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
            var intVal2 = function ( k ) {
                return typeof k === 'string' ?

                    k.replace(/[^\d+$]/g, '')*1 :

                    typeof k === 'number' ?
                        k : 0;
            };
            // Total over all pages
            
            total = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal2(a) + intVal2(b);
                }, 0 );
 
            // Total over this page
            
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var test = (pageTotal).toLocaleString(undefined, 
                    { minimumFractionDigits: 0 }
                );
            // Update footer
            $('.totalbiaya').val(pageTotal);
            $('.totaljumlah').val(total);
            
            

            $('.kettotal').html('<h5><b>TOTAL : <u>Rp.'+test+'</u></b></h5>');
            $('.dibayar').html('<h5><b>DIBAYAR : <u>Rp.'+test+'</u></b></h5>');
            $( api.column( 3 ).footer() )
            .html(
                
                'Rp. '+test +''

            );

       
        },

    });

   
   
    $("#bahan_baku,#konsumen,#jtransaksi,#tenor,#jharga").select2({
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
        var konsumen = $('.konsumen').val();
        var bahan_baku = $('.bahan_baku').val();
        var jumlah = $('.jumlah').val();
        var jharga = $('.jharga').val();

            if (konsumen == "" || bahan_baku == "" || jumlah == 0 || jharga == "") {
                alert_transaksi_kosong();
            } else {
      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/transaksi/add')?>",
                    data: {
                        bahan_baku: bahan_baku,jumlah: jumlah,konsumen: konsumen,jharga: jharga
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
                    url : "<?php echo site_url('backend/transaksi/delete')?>",
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

        var transaksi_id = $(this).attr("value");

       
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/transaksi/minus')?>",
                    data: {
                        transaksi_id: transaksi_id,
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

        var transaksi_id = $(this).attr("value");

      
                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/transaksi/plus')?>",
                    data: {
                        transaksi_id: transaksi_id,
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


    $(document).on("click", "#prosestransaksikonsumen", function(e) {
        e.preventDefault();
        var konsumen = $('.konsumen').val();
        
        var jtransaksi = $('.jtransaksi').val();
        var catatan = $('.catatan').val();
        var totalbiaya = $('.totalbiaya').val();
        var totaljumlah = $('.totaljumlah').val();
        var tenor = $('.tenor').val();
       
            if (totalbiaya == "" || totaljumlah == "" || totaljumlah == 0 || konsumen == "" || jtransaksi == "") {
                alert_form_transaksi_kosong();
            } else {


                $.ajax({
                    type: "post",
                    url : "<?php echo site_url('backend/transaksi/prosestransaksikonsumen')?>",
                    data: {
                        catatan: catatan,totalbiaya: totalbiaya,totaljumlah:totaljumlah, konsumen: konsumen, jtransaksi: jtransaksi, tenor: tenor
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.res == "success") {
                            Swal.fire(
                                "Ditambah!",
                                "Transaksi Berhasil dilakukan.",
                                "success"
                            );
                            $('#form-tambahstokbahan')[0].reset();
                            $("#bahan_baku,#jtransaksi,#konsumen,#tenor").select2("destroy");
                            $("#bahan_baku,#jtransaksi,#konsumen,#tenor").select2({
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
        var urlJenisHarga = "<?php echo base_url('databasejson/jenisharga/')?>";


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

        var selectProduk = $('#bahan_baku');
        $(selectProduk).change(function () {
            var value = $(selectProduk).val();
            clearOptions('jharga');

            if (value) {
                console.log("on change selectProduk");

                var text = $('#bahan_baku :selected').text();
                console.log("value = " + value + " / " + "text = " + text);

                console.log('Load Jenis Harga di '+text+'...')
                $.getJSON(urlJenisHarga + value + ".json", function(res) {

                    res = $.map(res, function (obj) {
                        obj.text = obj.nama+' ('+obj.harga+' )'
                        return obj;
                    });

                    data = [{
                        id: "",
                        nama: "[Pilih Jenis Harga]",
                        text: "[Pilih Jenis Harga]"
                    }].concat(res);

                 
                    $("#jharga").select2({
                        cache: false,
                        theme: "bootstrap-5",
                        data: data
                    })
                })
            }
        });

        
    </script>
</body>
</html>
