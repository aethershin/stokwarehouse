
<div class="page-content">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    
    


    <!-- validations start -->
    <section id="input-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    

                    <div class="card-body">
                        <div class="row" id="basic-form">
                            <div class="divider">
                                <div class="divider-text">Detil Akun</div>
                            </div>
                            <div class="col-12 col-md-3 text-center">
                                <div  class="show_img"></div>
                                
                                <div class="form-group">
                                    <label for="formFileSm" class="form-label">Upload New Image </label>
                                    <b>(*jpg,png,jpeg,webp dan ukuran maks 5mb)</b>
                                    <input type="file" class="form-control form-control-sm" id="user_photo" name="user_photo" accept=".jpg,.jpeg,.png,.webp" />
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="valid-state">Nama Lengkap</label>
                                <input type="text" class="form-control user_name" name="user_name"  placeholder="Nama Lengkap">
                                <br/>
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="password" name="password" class="form-control password" id="password" placeholder="New Password" required>
                                        <span class="help-block text-danger"></span>
                                        <div class="form-control-icon">
                                            <i class="bi bi-lock"></i>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-check form-check-xd d-flex align-items-end">
                                    <input class="form-check-input me-2" type="checkbox" onclick="showPass()" id="flexCheckDefault">
                                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                        Show Password
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="invalid-state">Email</label>
                                <input type="email" class="form-control user_email" name="user_email" 
                                    placeholder="Email">
                                <br/>
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="password" name="conf_pass" class="form-control conf_pass" id="conf_pass" placeholder="Konfirmasi New Password" required>
                                        <span class="help-block text-danger"></span>
                                        <div class="form-control-icon">
                                            <i class="bi bi-lock"></i>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-check form-check-xd d-flex align-items-end">
                                    <input class="form-check-input me-2" type="checkbox" onclick="showConfPass()" id="flexCheckDefault">
                                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                        Show Password
                                    </label>
                                </div>
                                <script>
                                function showPass() {
                                    var x = document.getElementById("password");
                                    if (x.type === "password") {
                                        x.type = "text";
                                    } else {
                                        x.type = "password";
                                    }
                                }
                                function showConfPass() {
                                    var x = document.getElementById("conf_pass");
                                    if (x.type === "password") {
                                        x.type = "text";
                                    } else {
                                        x.type = "password";
                                    }
                                } 
                                </script>
                            </div>

                                 
                                
                                


                            

                            <div class="col-md-12 col-12 mt-4">
                                <input type="hidden" name="id" class="id" value="<?php echo $this->session->userdata('id'); ?>">
                                <button id="success" class="btn btn-outline-success btn-lg btn-block btn-ubah">Update</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- validations end -->

    
</div>

        <!------- FOOTER --------->
            <?php $this->load->view("backend/_partials/footer.php") ?>
            <?php $this->load->view("backend/_partials/toastify.php"); ?>
        <!------- FOOTER --------->
        </div>
    </div>

    



    <script>
       var table;
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
                        var i;
                        
                        for(i=0; i<data.length; i++){
                            user_name = data[i].user_name;
                            user_email = data[i].user_email;
                            user_photo = data[i].user_photo;
                            
                            
                        } 
                        $('.user_name').val(user_name);
                        $('.user_email').val(user_email);
                        $(".show_img").html('<img src="'+base_url+'assets/images/profilusers/'+user_photo+'" width="150" height="150" class="rounded img-thumbnail">');
                    }
                });
            
            // END FUNCTION Tampil Detail Account
        }
        
            
            ///////////////////////// Function Change Rule Jenis AKun Biasa
        
            
           
            $('.btn-ubah').on('click', (e) =>{
                var id = $('.id').val();
                var user_name = $('.user_name').val();
                var user_email = $('.user_email').val();
                var password = $(".password").val();
                var conf_pass = $(".conf_pass").val();
                var user_photo = $("#user_photo")[0].files[0];
                var validEmailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

                var fd = new FormData();    
                fd.append("id", id);
                fd.append("user_name", user_name);
                fd.append("user_email", user_email);
                fd.append("password", password);
                fd.append("conf_pass", conf_pass);
                fd.append("user_photo", user_photo);
                fd.append("<?php echo $this->security->get_csrf_token_name(); ?>", '<?php echo
$this->security->get_csrf_hash(); ?>');
              
            if (id == "" || user_name == "" || user_email == "") {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Form tidak boleh kosong'
                            })
            } else if (!user_email.match(validEmailRegex)) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Email harus format : abc@gmail.com'
                            })
            } else if (password != conf_pass) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Konfirmasi Password tidak sama'
                            })
            } else {
                            
                $.ajax({
                    url    : '<?php echo site_url("backend/profil/change");?>',
                    method : 'POST',
                    data   : fd,
                    type  : 'GET',
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success : function(data){
                        
                        var i;
                        
                        for(i=0; i<data.length; i++){
                            user_name = data[i].user_name;
                            user_email = data[i].user_email;
                            user_photo = data[i].user_photo;

                            
                        } 
                            
                        $('.user_name').val(user_name);
                        $('.user_email').val(user_email);
                        location.reload(true);
                        $(".show_img").html('<img src="'+base_url+'assets/images/profilusers/'+user_photo+'" width="150" height="150" class="rounded img-thumbnail">');
                       
                        
                        

                    }
                });  
            }
            });
            ///////////////////////// End Function Change Rule Jenis AKun Biasa
            


        });
    </script>

</body>

</html>
