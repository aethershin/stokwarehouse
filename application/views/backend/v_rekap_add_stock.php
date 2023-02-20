<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-7 order-md-1 order-last" id="page-heading">
                <h4><?php echo $title; ?> <a href="javascript:void(0);" class="btn icon btn-sm btn-primary tambah"><i class="bi bi-clipboard2-plus-fill"></i> Tambah Stok Bahan</a></h4>
                
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
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">

            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordered m-0 p-0 text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Jumlah</th>
                            <th>Riwayat Bahan Masuk</th>
                            <th>Penanggung Jawab</th>
                            <th>Biaya dikeluarkan</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>

                            <th colspan="5" style="text-align:right">Total Biaya dikeluarkan:</th>
                            <th></th>
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
    $('#page-heading').on('click','.tambah',function(){
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/tambah_stock_bahan/";
            });
    //datatables
    table = $('#mytable').DataTable({ 

        "processing": true,
        "serverSide": true,
        "searching": false,
        "order": [], 

        "ajax": {
            "url": "<?php echo site_url('backend/rekap_stok_bahan/get_ajax_list')?>",
            "type": "POST",
            "data": function (data) {
                
                
                
                
            },
        },


        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4,5,6 ], 
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
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var test = (pageTotal).toLocaleString(undefined, 
                    { minimumFractionDigits: 0 }
                );
            // Update footer
            $( api.column( 5 ).footer() ).html(
                
                'Rp. '+test +' dari ('+totalsemua+')'

            );

       
        },

    });
            $('#mytable').on('click','.detail_tambah',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_stok_bahan/detail/"+id+"";
            });
            $('#mytable').on('click','.edit_rekap',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_stok_bahan/edit/"+id+"";
            });
            $('#mytable').on('click','.d-nota',function(){
                var id = $(this).data('id');
                var site_url = '<?php echo site_url();?>';
                window.location.href = site_url+"backend/rekap_stok_bahan/nota_pdf/"+id+"";
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

</script>

</body>
</html>
