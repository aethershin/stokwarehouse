
<!-- MODAL -->
        <!-- Add Records Modal -->
     
                    <div class="modal-body form">
                    
                        <?php
                            $attributes = array('class' => 'form-horizontal', 'id' => 'form');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>    
                        <div class="form-body">
                        <div class="row">
                            
                          
                        
                            
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="valid-state">Konsumen (Wajib diisi)</label>
                                    <select class="form-select konsumen" name="konsumen" id="konsumen" style="width:100%"  required>
                                        <option value="" >[Pilih Konsumen]</option>
                                        <?php foreach ($konsumen->result() as $row) : ?>
                                            <option value="<?php echo $row->id_konsumen;?>"><?php echo $row->nama;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
            
                                <div class="form-group">
                                    <label for="valid-state">Jumlah Galon *Pcs</label>
                                    <input type="number" name="jumlah" class="form-control jumlah" id="jumlah" placeholder="Jumlah" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <input type="hidden" name="jenis_galon" value="BHN-000000000017" id="jenis_galon" class="jenis_galon">
                            
                            
                            
                            
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