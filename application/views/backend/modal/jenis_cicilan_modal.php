
<!-- MODAL -->

<!-- Add Update Modal -->
<div class="modal fade text-left" id="modal_form_jcicilan" tabindex="-1" role="dialog"
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
                            $attributes = array('class' => 'form-horizontal', 'id' => 'formjcicilan');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>   
                        <div class="row">
                            <input type="hidden" class="id" name="id"/> 
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    
                                    <input type="text" name="nama_cicilan" class="form-control nama_cicilan" id="nama_cicilan" placeholder="Nama Jenis Cicilan" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    
                                    <input type="text" name="jumlah_tenor" class="form-control jumlah_tenor" id="jumlah_tenor" placeholder="Jumlah Tenor" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <select class="form-select tenor" name="tenor" id="tenor" style="width:100%" required>
                                    <option value="Mingguan">Mingguan</option>
                                    <option value="Bulanan">Bulanan</option>
                                </select>
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
                        <button type="submit" class="btn btn-success ml-1 btnSave" id="btnSave" onclick="addjcicilan()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- Add Update Modal -->
<!-- END MODAL -->