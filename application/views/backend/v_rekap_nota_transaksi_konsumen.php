
<div class="page-content">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-7 order-md-1 order-last" id="page-heading">
                <h4><?php echo $title; ?> <a href="javascript:void(0);" class="btn icon btn-sm btn-primary buat"><i class="bi bi-basket-fill"></i> Transaksi</a></h4>
                
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
                <p class="text-subtitle text-muted">Filter Data</p>
                        <form id="form-filter">
                            <div class="row">
                            
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="kode_transaksi" placeholder="Cari Nota">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    
                                    <select class="form-select id_konsumen_transaksi" name="id_konsumen_transaksi" id="id_konsumen_transaksi" style="width:100%"  required>
                                        <option value="" >[Pilih Konsumen]</option>
                                        <?php foreach ($konsumen->result() as $row) : ?>
                                            <option value="<?php echo $row->id_konsumen;?>"><?php echo $row->nama;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    
                                    <select class="form-select jenis_transaksi" name="jenis_transaksi" id="jenis_transaksi" style="width:100%"  required>
                                        <option value="" >[Pilih Jenis Transaksi]</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Cicil">Cicil</option>
                                        
                                        
                                        
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="col-12 col-md-6">
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <button type="button" id="btn-filter" class="btn btn-primary"><i class="bi bi-search"></i> Filter Data</button>&nbsp;&nbsp;
                                    <button type="button" id="btn-reset" class="btn btn-success"><i class="bi bi-bootstrap-reboot"></i> Refresh</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    <hr>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered mb-0 text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Nama Konsumen</th>
                            <th>Jenis Transaksi</th>
                            <th>Riwayat Transaksi</th>
                            
                            <th>Total Transaksi</th>
                            <th>Dibayar</th>
                            
                            
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>

                            <th colspan="6" style="text-align:right">Total Dibayar:</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
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
            $('#page-heading').on('click','.buat',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/transaksi/";
            });
    //datatables
    table = $('#mytable').DataTable({ 

        "processing": true,
        "serverSide": true,
        "searching": false,
        "order": [], 

        "ajax": {
            "url": "<?php echo site_url('backend/rekap_nota_transaksi_konsumen/get_ajax_list')?>",
            "type": "POST",
            "data": function (data) {
                data.kode_transaksi = $('#kode_transaksi').val();
                data.id_konsumen_transaksi = $('#id_konsumen_transaksi').val();
                data.jenis_transaksi = $('#jenis_transaksi').val();
                
                
                
            },
        },


        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4,5,6,7 ], 
            "orderable": false, 
        },
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var totalsemua = "<?php echo $all; ?>";
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?

                    i.replace(/[\Rp, ,.]/g, '')*1 :

                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var test = (pageTotal).toLocaleString(undefined, 
                    { minimumFractionDigits: 0 }
                );
            // Update footer
            $( api.column( 6 ).footer() ).html(
                
                'Rp. '+test +' dari ('+totalsemua+')'

            );

       
        },

    });
           
            $('#mytable').on('click','.detail',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/detail/"+id+"";
            });
            $('#mytable').on('click','.bayar_cicilan',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/bayar_cicilan/"+id+"";
            });
            $('#mytable').on('click','.transaksi_titip',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/transaksi_titip/"+id+"";
            });
            $('#mytable').on('click','.d-nota-a5',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/nota_pdf_a5/"+id+"";
            });
            $('#mytable').on('click','.d-nota-a7',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_nota_transaksi_konsumen/nota_pdf_a7/"+id+"";
            });
      
    $("#id_konsumen_transaksi,#jenis_transaksi").select2({
        cache: false,
        theme: "bootstrap-5",
    });
    $('#btn-filter').click(function(){ 
        reload_table(); 
    });
    $('#btn-reset').click(function(){ 
        $('#form-filter')[0].reset();
        $("#id_konsumen_transaksi,#jenis_transaksi").select2("destroy");
        $("#id_konsumen_transaksi,#jenis_transaksi").select2({
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

</script>

</body>
</html>
