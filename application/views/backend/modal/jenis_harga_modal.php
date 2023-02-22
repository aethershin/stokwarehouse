
<!-- MODAL -->

<!-- Add Update Modal -->
<div class="modal fade text-left" id="modal_form_jharga" tabindex="-1" role="dialog"
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
                            $attributes = array('class' => 'form-horizontal', 'id' => 'formjharga');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>   
                        <div class="row">
                            <input type="hidden" class="id" name="id"/> 
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    
                                    <input type="text" name="nama" class="form-control nama" id="nama" placeholder="Nama Jenis Harga" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    
                                    <input type="number" name="harga" class="form-control harga" id="harga" placeholder="Harga" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="valid-state">Kategori</label>
                                    <select class="form-select kategori_stock" name="kategori_stock" id="kategori_stock" style="width:100%" required>
                                        <?php foreach ($produksi->result() as $row) : ?>
                                            <option value="<?php echo $row->kode_stock;?>"><?php echo $row->nama_stock;?></option>
                                        <?php endforeach;?>
                                    </select>
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
                        <button type="submit" class="btn btn-success ml-1 btnSave" id="btnSave" onclick="addjharga()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- Add Update Modal -->
<!-- END MODAL -->