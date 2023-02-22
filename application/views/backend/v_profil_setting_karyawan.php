
<div class="page-heading">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    
    


    <!-- validations start -->
    <section id="input-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    

                    <div class="card-body">
                        <div class="row">
                            <p class="tgl_daftar"></p>
                            <div class="divider">
                                
                                <div class="divider-text">Detil Akun</div>
                            </div>
                            <div class="col-12 col-md-4 text-center">
                                <div class="row gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                    <div class="col-12 col-md-12">
                                        <a href="#">
                                            <div  class="show_img_pas_photo"></div>
                                            
                                        </a>
                                        
                                    </div>

                                </div>

                            
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="display_ket"></div>
                                
                            </div>
                           
                            
                        
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- validations end -->

    
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog"
aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered"
role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Pas Photo</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#Gallerycarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                       
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div  class="show_img_pas_photo_modal"></div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <!------- FOOTER --------->
            <?php $this->load->view("backend/_partials/footer.php") ?>
        <!------- FOOTER --------->
        </div>
    </div>

    



    <script>
    
        $(document).ready(function(){
            var csfrData = {};
csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo
$this->security->get_csrf_hash(); ?>';
$.ajaxSetup({
data: csfrData
});
            show_profil();
            
                      
            function show_profil(){
                
                
                var id ='<?php echo $this->session->userdata('id'); ?>';
                var base_url = '<?php echo base_url(); ?>';
            // FUNCTION Tampil Detail Account
                $.ajax({

                    url   : '<?php echo site_url("backend/profil/get_detail_profil");?>',
                    method : 'POST',
                    data   : {id: id},
                    type  : 'GET',
                    async : true,
                    dataType : 'json',
                    success : function(data){
                        var html = '';
                        var levels = '';
                        var ket_levels = '';
                        for(i=0; i<data.length; i++){
                            levels = data[i].user_level;
                            if (levels == 1) {
                                ket_levels = 'Admin';
                            } else if (levels == 2) {
                                ket_levels = 'Gudang';
                            } else if (levels == 3) {
                                ket_levels = 'Kasir Lapangan';
                            } else {
                                ket_levels = 'Unauthorized';
                            }
                            
                            
                            display_ket = '<table class="table table-borderless float-start w-75">'+
                            '<tr>'+
                                '<td><b>Nama</b></td><td> : </td><td>'+data[i].user_name+'</td>'+  
                            '</tr>'+
                            
                            '<tr>'+
                                '<td><b>Email</b></td><td> : </td><td>'+data[i].user_email+'</td>'+  
                            '</tr>'+
                            '<tr>'+
                                '<td><b>Tipe Akun</b></td><td> : </td><td>'+ket_levels+'</td>'+  
                            '</tr>'+

                            '</table>';
                            
                            picture_2 = data[i].user_photo;
                            
                            
                                    
                            
                        } 
                        
                      
                        $('.display_ket').html(display_ket);
                        $(".show_img_pas_photo").html('<img src="'+base_url+'assets/images/profilusers/'+picture_2+'"  class="w-100" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">');
                        $(".show_img_pas_photo_modal").html('<img src="'+base_url+'assets/images/profilusers/'+picture_2+'"  class="d-block w-100">');
                        

                        
                    }
                });
            
            // END FUNCTION Tampil Detail Account
        }
        
            


        });
    </script>

</body>

</html>
