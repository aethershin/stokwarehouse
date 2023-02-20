
<!-- MODAL -->
        <!-- Add Records Modal -->
        <div class="modal fade text-left" id="modal_form_produksi" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
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
                            $attributes = array('class' => 'form-horizontal', 'id' => 'formproduksi');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>    
                        <div class="form-body">
                        <div class="row">
                            
                            
                            <input type="hidden"  name="id" class="id"/> 
                                
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="valid-state">Material</label>
                                    <select class="form-select bahan_baku" name="bahan_baku" id="bahan_baku" style="width:100%"  required>
                                        <option value="" >[Pilih Material]</option>
                                        <?php foreach ($bbaku->result() as $row) : ?>
                                            <option value="<?php echo $row->id_stock;?>"><?php echo $row->nama_stock;?> | <?php echo $row->stock;?> <?php echo $row->nama_satuan;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <span class="help-block text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="bahan_baku_alert" class="form-control bahan_baku_alert" id="bahan_baku_alert">
                                    <span class="help-block text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="valid-state">Jumlah Material</label>
                                    <input type="number" name="jumlah" class="form-control jumlah" id="jumlah" placeholder="Jumlah Material" required>
                                    
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
                        <button type="submit" class="btn btn-success ml-1 btnSave" id="btnSave" onclick="addproduksi()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Records Modal -->



<!-- END MODAL -->