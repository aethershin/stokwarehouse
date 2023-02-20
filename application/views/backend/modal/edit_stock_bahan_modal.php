
<!-- MODAL -->
        <!-- Add Records Modal -->
     
                    <div class="modal-body form">
                    
                    <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => 'form');
                        echo form_open($this->uri->uri_string(), $attributes);
                    ?>     
                        <div class="form-body">
                        <div class="row">
                            
                               
                           
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label for="valid-state">Bahan Baku</label>
                                    <select class="form-select bahan_baku" name="bahan_baku" id="bahan_baku" style="width:100%"  required>
                                        <option value="" >[Pilih Bahan Baku]</option>
                                        <?php foreach ($bbaku->result() as $row) : ?>
                                            <option value="<?php echo $row->id_stock;?>"><?php echo $row->nama_stock;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <input type="hidden" name="bahan_baku_alert" class="form-control bahan_baku_alert" id="bahan_baku_alert">
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
            
                                <div class="form-group">
                                    <label for="valid-state">Jumlah *Pcs</label>
                                    <input type="number" name="jumlah" class="form-control jumlah" id="jumlah" placeholder="Jumlah" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                        </div>
                    <?php
                        echo form_close();
                    ?>
                    
                    <div class="modal-footer">
                        
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btnSave" class="btn btn-success btnSave"><i class="bi bi-save"></i> Tambah</button>
                        
                    </div>
                    </div>


<!-- FILTER -->
            
                    <hr>
<!-- FILTER -->
<!-- END MODAL -->