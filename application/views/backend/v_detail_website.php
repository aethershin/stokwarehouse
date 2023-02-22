

    <!-- validations start -->
    <section id="input-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    

                    <div class="card-body">
                        <div class="row" id="basic-form">
                            <div class="divider">
                                <div class="divider-text"><?php echo $title; ?></div>
                            </div>
                            <div class="col-12 text-center">
                                <div  class="show_img"></div>
                                
                                <div class="form-group">
                                    <label for="formFileSm" class="form-label">Upload Header Image </label>
                                    <b>(*jpg,png,jpeg,webp dan ukuran maks 2mb)</b>
                                    <input type="file" class="form-control form-control-sm" id="user_photo" name="user_photo" accept=".jpg,.jpeg,.png,.webp" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="valid-state">Nama Website</label>
                                <input type="text" class="form-control detail_site_title" name="site_title"  placeholder="Nama Website">
                                
                            </div>
                            <div class="col-sm-6">
                                <label for="invalid-state">Email</label>
                                <input type="text" class="form-control detail_email" name="email" 
                                    placeholder="Email">
                                
                            </div>
                            <div class="col-sm-6">
                                <label for="invalid-state">Nama Kontak</label>
                                <input type="text" class="form-control detail_nama_kontak" name="nama_kontak" 
                                    placeholder="Nama Kontak">
                                
                            </div>
                            <div class="col-sm-6">
                                <label for="invalid-state">Nomor Telepon</label>
                                <input type="text" class="form-control detail_notelp" name="notelp" 
                                    placeholder="No. Telp">
                                
                            </div>
                            <div class="col-sm-12 mt-4 mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control detail_site_deskripsi" placeholder="Masukkan Deskripsi Website" name="site_deskripsi"></textarea>
                                    <label for="floatingTextarea">Deskripsi Website</label>
                                </div>
                            </div>    
                            

                            <div class="col-sm-12 mt-4 mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control detail_alamat_universitas" placeholder="Masukkan Detail Alamat" name="alamat_universitas"></textarea>
                                    <label for="floatingTextarea">Alamat Lengkap</label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <div  class="show_img_favicon"></div>
                                
                                <div class="form-group">
                                    <label for="formFileSm" class="form-label">Upload Favicon Image </label>
                                    <b>(*jpg,png,jpeg,webp dan ukuran maks 2mb)</b>
                                    <input type="file" class="form-control form-control-sm" id="img_favicon" name="img_favicon" accept=".jpg,.jpeg,.png,.webp" />
                                </div>
                            </div>
                        <!------------------------------------------------------------------------------------------------>
                            <div class="divider">
                                <div class="divider-text">Link Social Media</div>
                            </div>
                            <div class="col-sm-6">
                                <label for="valid-state">Facebook</label>
                                <input type="text" class="form-control detail_facebook" name="facebook"  placeholder="Link Facebook">
                                
                            </div>

                            <div class="col-sm-6">
                                <label for="valid-state">Instagram</label>
                                <input type="text" class="form-control detail_instagram" name="instagram"  placeholder="Link Instagram">
                                
                            </div>
                            <div class="col-sm-6">
                                <label for="valid-state">Youtube</label>
                                <input type="text" class="form-control detail_youtube" name="youtube"  placeholder="Link Youtube">
                                
                            </div>

                            <div class="col-sm-6">
                                <label for="valid-state">Telegram</label>
                                <input type="text" class="form-control detail_telegram" name="telegram"  placeholder="Link Telegram">
                                
                            </div>


                            

                            <div class="col-md-12 col-12 mt-4">
                                <input type="hidden" name="id" class="id">
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
            show_detail();
            
                    
            function show_detail(){
                
               
                var base_url = '<?php echo base_url(); ?>';
            // FUNCTION Tampil Detail Account
                $.ajax({

                    url   : '<?php echo site_url("backend/detail_website/get_detail_website");?>',
                    
                    type  : 'GET',
                    async : true,
                    dataType : 'json',
                    success : function(data){
                        var html = '';
                        var i;
                        
                        for(i=0; i<data.length; i++){
                            id = data[i].detail_website_id;
                            site_title = data[i].site_title;
                            email = data[i].email;
                            site_deskripsi = data[i].site_deskripsi;
                            nama_kontak = data[i].nama_kontak;
                            notelp = data[i].notelp;
                            facebook = data[i].facebook;
                            instagram = data[i].instagram;
                            youtube = data[i].youtube;
                            telegram = data[i].telegram;
                            alamat_universitas = data[i].alamat_universitas;
                            images = data[i].images;
                            site_favicon = data[i].site_favicon;
                            
                            
                        } 
                        $('.id').val(id);
                        $('.detail_site_title').val(site_title);
                        $('.detail_email').val(email);
                        $('.detail_site_deskripsi').val(site_deskripsi);
                        $('.detail_notelp').val(notelp);
                        $('.detail_nama_kontak').val(nama_kontak);
                        $('.detail_facebook').val(facebook);
                        $('.detail_instagram').val(instagram);
                        $('.detail_youtube').val(youtube);
                        $('.detail_telegram').val(telegram);
                        $('.detail_alamat_universitas').val(alamat_universitas);
                        $(".show_img").html('<img src="'+base_url+'assets/images/logo/'+images+'" width="150" height="150" class="rounded img-thumbnail">');
                        $(".show_img_favicon").html('<img src="'+base_url+'assets/images/logo/'+site_favicon+'" width="50" height="50">');

                        

                    }
                });
            
            // END FUNCTION Tampil Detail Account
        }

            
            ///////////////////////// Function Change Rule Jenis AKun Biasa
            
            $('.btn-ubah').on('click', (e) =>{
                var id = $('.id').val();
                var site_title = $('.detail_site_title').val();
                var email = $('.detail_email').val();
                var site_deskripsi = $('.detail_site_deskripsi').val();
                var notelp = $('.detail_notelp').val();
                var nama_kontak = $('.detail_nama_kontak').val();
                var facebook = $('.detail_facebook').val();
                var instagram = $('.detail_instagram').val();
                var youtube = $('.detail_youtube').val();
                var telegram = $('.detail_telegram').val();
                var alamat_universitas = $('.detail_alamat_universitas').val();
                var user_photo = $("#user_photo")[0].files[0];
                var img_favicon = $("#img_favicon")[0].files[0];
                var validEmailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                var validPhoneRegex = /^(\+62|62|0)8[1-9][0-9]{6,9}$/;
                var validLinkRegex = /^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/;
                var fd = new FormData();    
                fd.append("id", id);
                fd.append("site_title", site_title);
                fd.append("email", email);
                fd.append("site_deskripsi", site_deskripsi);
                fd.append("notelp", notelp);
                fd.append("nama_kontak", nama_kontak);
                fd.append("facebook", facebook);
                fd.append("instagram", instagram);
                fd.append("youtube", youtube);
                fd.append("telegram", telegram);
                fd.append("alamat_universitas", alamat_universitas);
                fd.append("user_photo", user_photo);
                fd.append("img_favicon", img_favicon);
				fd.append("<?php echo $this->security->get_csrf_token_name(); ?>", '<?php echo
$this->security->get_csrf_hash(); ?>');

            if (id == "" || site_title == "" || email == "" || site_deskripsi == "" || notelp == "" || nama_kontak == "" || facebook == "" || instagram == "" || youtube == "" || telegram == "" || alamat_universitas == "") {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Form tidak boleh kosong'
                            })
            } else if (!notelp.match(validPhoneRegex)) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Nomor Telp Tidak Valid *(061)123-4567* / 0611234567'
                            })
            } else if (!email.match(validEmailRegex)) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Email harus format : abc@gmail.com'
                            })
            } else if (!facebook.match(validLinkRegex)) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Link Facebook Tidak Valid'
                            })
            } else if (!instagram.match(validLinkRegex)) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Link Instagram Tidak Valid'
                            })
            } else if (!youtube.match(validLinkRegex)) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Link Youtube Tidak Valid'
                            })
            } else if (!telegram.match(validLinkRegex)) {
                            Swal.fire({
                                icon: "warning",
                                title: "Alert",
                                text: 'Link Telegram Tidak Valid'
                            })
            } else {
                            
                $.ajax({
                    url    : '<?php echo site_url("backend/detail_website/change");?>',
                    method : 'POST',
                    data   : fd,
                    type  : 'GET',
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success : function(data){
                        
                        var i;
                        
                        for(i=0; i<data.length; i++){
                            id = data[i].detail_website_id;
                            site_title = data[i].site_title;
                            email = data[i].email;
                            site_deskripsi = data[i].site_deskripsi;
                            notelp = data[i].notelp;
                            nama_kontak = data[i].nama_kontak;
                            facebook = data[i].facebook;
                            instagram = data[i].instagram;
                            youtube = data[i].youtube;
                            telegram = data[i].telegram;
                            alamat_universitas = data[i].alamat_universitas;
                            images = data[i].images;
                            site_favicon = data[i].site_favicon;
                            
                        } 
                        $('.id').val(id);
                        $('.detail_site_title').val(site_title);
                        $('.detail_email').val(email);
                        $('.detail_site_deskripsi').val(site_deskripsi);
                        $('.detail_notelp').val(notelp);
                        $('.detail_nama_kontak').val(nama_kontak);
                        $('.detail_facebook').val(facebook);
                        $('.detail_instagram').val(instagram);
                        $('.detail_youtube').val(youtube);
                        $('.detail_telegram').val(telegram);
                        $('.detail_alamat_universitas').val(alamat_universitas);
                        location.reload(true);
                        $(".show_img").html('<img src="'+base_url+'assets/images/logo/'+images+'" width="150" height="150" class="rounded img-thumbnail">');
                        $(".show_img_favicon").html('<img src="'+base_url+'assets/images/logo/'+site_favicon+'" width="50" height="50">');
                        
                        
                        
                        

                    }
                });  
            }
            });
            ///////////////////////// End Function Change Rule Jenis AKun Biasa
            


        });
    </script>

</body>

</html>
