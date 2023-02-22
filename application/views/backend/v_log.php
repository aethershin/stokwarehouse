
<div class="page-content">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    <section id="input-validation">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
            <div class="card-body">
                <!-- FILTER -->
                <p class="text-subtitle text-muted">Filter Data</p>
                        <form id="form-filter">
                            <div class="row">
                        <?php if($this->session->userdata('access')=='1'):?>     
                            <div class="col-12 col-md-8">
                                <select class="form-select ket" name="id_user_pengeluaran" id="ket" style="width:100%" required>
                                    <option value="">[Pilih Keterangan]</option>
                                    
                                        <option value="Produksi Barang">Produksi Barang</option>
                                        <option value="Tambah Konsumen">Tambah Konsumen</option>

                                        <option value="Transaksi Cash">Transaksi Cash</option>
                                        <option value="Transaksi Cicil">Transaksi Cicil</option>
                                      
                                        <option value="Mengkonfirmasi Pembayaran Cicilan">Mengkonfirmasi Pembayaran Cicilan</option>
                                        <option value="Mengkonfirmasi Pembatalan Pembayaran Cicilan">Mengkonfirmasi Pembatalan Pembayaran Cicilan</option>
                                        
                                        <option value="Absen">Absen</option>
                                        <option value="Penambahan Stok Material">Penambahan Stok Material</option>

                                        <option value="Material Rusak">Material Rusak</option>
                                        <option value="Pengeluaran">Pengeluaran</option>
                                        <option value="Material">Material</option>
                                        <option value="Produk Ready Sale">Produk Ready Sale</option>

                                  
                                </select>
                            </div>
                        <?php else:?>
           
                        <?php endif;?>
                  
                            
                            <div class="col-12 col-md-4">
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <button type="button" id="btn-filter" class="btn btn-primary"><i class="bi bi-search"></i> Filter Data</button>&nbsp;&nbsp;
                                    <button type="button" id="btn-reset" class="btn btn-success"><i class="bi bi-bootstrap-reboot"></i> Refresh</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    <hr>
                <!-- FILTER -->
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0">
                    <thead>
                        <tr class="table-warning">
                           
                            <th>Keterangan</th>
                            <th>Icon</th>
                            <th>Tanggal</th>
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
    <script language="JavaScript" type="text/javascript" src="<?php echo base_url().'assets/js/pages/toastifycrud.js'?>"></script>
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
            "url": "<?php echo site_url('backend/log/get_ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.ket = $('#ket').val();
            }
        },


        "columnDefs": [
        { 
            "targets": [ 0 ], 
            "orderable": false, 
        },
        ],

    });
    $('#btn-filter').click(function(){ 
        table.ajax.reload();  
    });
    $('#btn-reset').click(function(){ 
        $('#form-filter')[0].reset();
        $("#ket").select2("destroy");
        $("#ket").select2({
                cache: false,
                theme: "bootstrap-5",
        });
        table.ajax.reload(); 
    });

            $("#ket").select2({
                cache: false,
                theme: "bootstrap-5",
            }); 
  

});
function reload_table()
{
    table.ajax.reload(null,false); 
}

</script>
</body>
</html>
