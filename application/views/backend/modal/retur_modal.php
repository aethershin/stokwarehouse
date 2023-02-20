
<!-- MODAL -->
        <!-- Add Records Modal -->
     
                    <div class="modal-body form">
                  
                        <?php
                            $attributes = array('class' => 'form-horizontal', 'id' => 'form');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>    
                        <div class="form-body">
                        <div class="row">
                            
                          
                        
                            
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label> Produk </label>
                                    <select class="form-select bahan_baku" style="width:100%" name="bahan_baku" id="bahan_baku"></select>
                                    <input type="hidden" name="bahan_baku_alert" class="form-control bahan_baku_alert" id="bahan_baku_alert">
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                          
                            <div class="col-12 col-md-4">
            
                                <div class="form-group">
                                    <label for="valid-state">Jumlah *Pcs/ Kotak</label>
                                    <input type="number" name="jumlah" class="form-control jumlah" id="jumlah" placeholder="Jumlah" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="valid-state">Surat Jalan</label>
                                    <select class="form-select kode_surat_jalan" name="kode_surat_jalan" id="kode_surat_jalan" style="width:100%" required>
                                        <option value="" >[Pilih Kode Surat Jalan]</option>
                                        <?php foreach ($ksuratjalan->result() as $row) : ?>
                                            <option value="<?php echo $row->kode_surat_jalan;?>"><?php echo $row->kode_surat_jalan;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    
                                </div>
                            </div>
                            
                            
                            
                            
                        </div>
                        </div>
                        <?php
                            echo form_close();
                        ?>
                    
                    <div class="modal-footer">
                        
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btnSave" class="btn btn-success btnSave"><i class="bi bi-save"></i> Retur</button>
                        
                    </div>
                    </div>


<!-- FILTER -->
            
                    <hr>
<!-- FILTER -->
<!-- END MODAL -->