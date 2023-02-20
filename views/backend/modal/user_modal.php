
<!-- MODAL -->
        <!-- Add Records Modal -->
        <div class="modal fade text-left" id="modal_form" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title white" id="myModalLabel120">Tambah User
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body form">
                    
                        <?php
                            $attributes = array('class' => 'form-horizontal', 'id' => 'form');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>      
                        <div class="form-body">
                        <div class="row">
                            <div class="col-12 col-md-3 text-center">
                                <div  class="show_img"></div>
                                <br/>
                                <div class="form-group">
                                    <input type="hidden"  name="id" class="id"/> 
                                    <label for="formFileSm" class="form-label">Upload New Image </label>
                                    <b>(*jpg,png,jpeg,webp dan ukuran maks 5mb)</b>
                                    <input type="file" class="form-control form-control-sm" id="user_photo" name="user_photo" accept=".jpg,.jpeg,.png,.webp" />

                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    
                                    <input type="text" name="nama" class="form-control nama" id="nama" placeholder="Nama">
                                    <span class="help-block text-danger"></span>
                                </div>
                                <div class="form-group">
                                   
                                    <input type="email" name="email" class="form-control email" id="email" placeholder="Email">
                                    <span class="help-block text-danger"></span>
                                </div>
                               
                                
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
                                <div class="form-group">
                                    <label for="valid-state">Tipe Akun</label>
                                    <select class="form-select level" name="level" id="level" style="width:100%" required>
                                            <option value="">[Pilih Tipe Akun]</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Warehouse</option>
                                            <option value="3">Ekspedisi</option>
                                            <option value="4">Karyawan</option>
                                    </select>
                                    <span class="help-block text-danger"></span>
                                </div>
                
                            </div>
                        </div>
                        </div>
                        <?php
                            echo form_close();
                        ?>
                    </div>
                    <div class="modal-footer">
                        <div class="show_edit"></div>
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-sm-none"></i>Cancel</button>
                        <button type="submit" class="btn btn-success ml-1 btnSave" id="btnSave" onclick="proc()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Records Modal -->


<!-- END MODAL -->