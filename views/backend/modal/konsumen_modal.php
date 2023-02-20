
<!-- MODAL -->
        <!-- Add Records Modal -->
        <div class="modal fade text-left" id="modal_form_konsumen" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title white" id="myModalLabel120">
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body formkonsumen">
                    
                    <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => 'formkonsumen');
                        echo form_open($this->uri->uri_string(), $attributes);
                    ?>    
                        <div class="form-body">
                        <div class="row">
                            
                            <input type="hidden"  name="id" class="id"/> 
                                   
                        
                           
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="valid-state">Nama Konsumen</label>
                                    <input type="text" name="nama" class="form-control nama" id="nama" placeholder="Nama Konsumen">
                                    <span class="help-block text-danger"></span>
                                </div>
                                
                                <div class="form-floating">
                                    <textarea class="form-control alamat" placeholder="Masukkan Detail Alamat" name="alamat" id="alamat"></textarea>
                                    <span class="help-block text-danger"></span>
                                    <label for="floatingTextarea">Alamat Lengkap</label>

                                </div>
                                <div class="form-group">
                                    <label for="valid-state">No HP</label>
                                    <input type="number" name="nohp" class="form-control nohp" id="nohp" placeholder="No HP">
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
                        <div class="show_record"></div>
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-sm-none"></i>Cancel</button>
                        <button type="submit" class="btn btn-success ml-1 btnSave" id="btnSave" onclick="addkonsumen()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Records Modal -->

<!-- Import Modal -->
                                <form id="add-row-form" action="<?php echo site_url('backend/konsumen/import');?>" method="post" enctype="multipart/form-data">
                                        <div class="modal fade text-left" id="import" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel120" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-titles white" id="myModalLabel120">Import dari Excel
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5> Format Import
                                                        
                                                        <a href="javascript:void(0);" class="btn icon btn-sm btn-primary download-excel"><i class="bi bi-download"></i></a>
                                                        </h5>
                                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Aturan</button>
                                                        <div class="collapse" id="collapseExample">
                                                        1. Format dalam bentuk (xls,xlsx).<br/>
                                                        2. Nama, Alamat, No HP Wajib Isi.<br/>
                                                        3. No. HP Diawali dengan 62...<br/>
                                                        </div>

                                                        <br/><br/>
                                                   
                                                    <div class="col-12">
                                                        <fieldset>
                                                            <div class="input-group">
                                                                <input type="file" name="fileExcel" class="form-control fileExcel"   accept=".xls,.xlsx" required>
                                                                
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                                                                                
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-sm-none"></i>Cancel</button>
                                                        <button type="submit" class="btn btn-success ml-1 btn-import" id="btn-import">
                                                            <i class="bx bx-check d-sm-none"></i>Import</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
<!-- Import Modal -->


<!-- END MODAL -->