
<!-- MODAL -->

<!-- Add Update Modal -->
<div class="modal fade text-left" id="modal_form_pengeluaran" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        
                        <h3 class="modal-title white" id="myModalLabel120"></h3>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
            <div class="modal-body form">
                        
                        <?php
                            $attributes = array('class' => 'form-horizontal', 'id' => 'formpengeluaran');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>      
                        <div class="row">
                            <input type="hidden" class="id" name="id"/> 
                            <b class="text-center">(*jpg,png,jpeg,webp dan ukuran maks 5mb)</b>
                            <div class="col-12 col-md-12 text-center">
                                <div  class="show_img"></div>
                                <br/>
                                <div class="form-group">
                                    <label for="formFileSm" class="form-label">Unggah Foto Bukti Pengeluaran</label>
                                    <br/>
                                    
                                    <input type="file" class="form-control form-control-sm" id="picture_1" name="picture_1" accept=".jpg,.jpeg,.png,.webp" />

                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control ket" placeholder="Masukkan Keterangan Pengeluaran" name="ket" id="ket"></textarea>
                                    <label for="floatingTextarea">Masukkan Keterangan Pengeluaran</label>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div> 
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valid-state">Biaya <b>(Rp)</b></label>
                                    <input type="number" name="biaya" class="form-control biaya" id="biaya" placeholder="Biaya" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <?php
                            echo form_close();
                        ?>
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-sm-none"></i>Cancel</button>
                        <button type="submit" class="btn btn-success ml-1 btnSave" id="btnSave" onclick="addpengeluaran()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- Add Update Modal -->
<!-- END MODAL -->

