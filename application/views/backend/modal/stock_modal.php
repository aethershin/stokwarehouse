
<!-- MODAL -->
        <!-- Add Records Modal -->
        <div class="modal fade text-left" id="modal_form_stock" tabindex="-1" role="dialog"
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
                            $attributes = array('class' => 'form-horizontal', 'id' => 'formstock');
                            echo form_open($this->uri->uri_string(), $attributes);
                        ?>     
                        <div class="form-body">
                        <div class="row">
                            <div class="col-12 col-md-3 text-center" >
                                <div  class="show_img"></div>
                                <a href="javascript:void(0);" class="btn icon btn-sm btn-primary aeth"><i class="bi bi-download"></i></a>
                            </div>
                            <input type="hidden"  name="id" class="id"/> 
                                
                           
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="valid-state">Nama Barang</label>
                                    <input type="text" name="nama_stock" class="form-control nama_stock" id="nama_stock" placeholder="Nama Barang">
                                    <span class="help-block text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="valid-state">Harga Beli <b>(Rp)</b></label>
                                    <input type="number" name="harga_beli" class="form-control harga_beli" id="harga_beli" placeholder="Harga Beli" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="valid-state">Kategori</label>
                                    <select class="form-select kategori_stock" name="kategori_stock" id="kategori_stock" style="width:100%" required>
                                        <?php foreach ($kategori->result() as $row) : ?>
                                            <option value="<?php echo $row->id_kategori;?>"><?php echo $row->nama_kategori;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <span class="help-block text-danger"></span>
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="valid-state">Satuan</label>
                                    <select class="form-select satuan_stock" name="satuan_stock" id="satuan_stock" style="width:100%" required>
                                        
                                        <?php foreach ($satuan->result() as $row) : ?>
                                            <option value="<?php echo $row->id_satuan;?>"><?php echo $row->nama_satuan;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <span class="help-block text-danger"></span>
                                </div>
                                
                                <input type="hidden" name="kategori_material" class="form-control kategori_material" id="kategori_material">
                                
                                
                                
                               
                                <div class="form-group">
                                    <label for="valid-state">Stock Minimal</label>
                                    <input type="number" name="stock_minimal" class="form-control stock_minimal" id="stock_minimal" placeholder="Stok Minimal" required>
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
                        <button type="submit" class="btn btn-success ml-1 btnSave" id="btnSave" onclick="addstock()">
                            <i class="bx bx-check d-sm-none"></i>Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Records Modal -->



<!-- FILTER -->
                   
<!-- FILTER -->

<!-- END MODAL -->