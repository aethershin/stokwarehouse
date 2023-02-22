
<!-- MODAL -->
        <!-- Add Records Modal -->
        <div class="modal fade text-left" id="modal_form_titip" tabindex="-1" role="dialog"
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
                    <div class="modal-body form">
                    
                        <?php
                            $attributes = array('class' => 'form-horizontal', 'id' => 'formtitip');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>     
                        <div class="form-body">
                        <div class="row">
                            
                            <input type="hidden"  name="id" class="id"/> 
                            <input type="hidden"  name="totallaku" class="totallaku"/>     
                            <input type="hidden"  name="id_notas" class="id_notas" value="<?php echo $id; ?>" />    
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <div class="show_record"></div>
                                </div>
                                <div class="form-group">
                                    <label for="valid-state">Jumlah Laku</label>
                                    <input type="number" name="laku" class="form-control laku" id="laku" placeholder="Jumlah Laku" required>
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
                        
                        <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-sm-none"></i>Cancel</button>
                        <button type="submit" class="btn btn-success ml-1 btnSaveTitip" id="btnSaveTitip" onclick="proccesstitip()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Records Modal -->




<!-- END MODAL -->