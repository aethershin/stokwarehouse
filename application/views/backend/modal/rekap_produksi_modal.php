
<!-- MODAL -->
      

<!-- FILTER -->
                    <p class="text-subtitle text-muted">Filter Data</p>
                        <form id="form-filter">
                            <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control kode_produksi_selesai" id="kode_produksi_selesai" placeholder="Cari Kode Produksi">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <select class="form-select nama_produksi" name="nama_produksi" id="nama_produksi" style="width:100%" required>
                                        <option value="" >[Pilih Jenis Produksi]</option>
                                        <?php foreach ($produksi->result() as $row) : ?>
                                            <option value="<?php echo $row->id_stock;?>"><?php echo $row->nama_stock;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <select class="form-select produksi_selesai_user_id" name="produksi_selesai_user_id" id="produksi_selesai_user_id" style="width:100%" required>
                                        <option value="" >[Pilih Karyawan]</option>
                                        <?php foreach ($karyawan->result() as $row) : ?>
                                            <option value="<?php echo $row->user_id;?>"><?php echo $row->user_name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4">
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <button type="button" id="btn-filter" class="btn btn-primary"><i class="bi bi-search"></i> Filter Data</button>&nbsp;&nbsp;
                                    <button type="button" id="btn-reset" class="btn btn-success"><i class="bi bi-bootstrap-reboot"></i> Refresh</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    <hr>
<!-- FILTER -->

<!-- END MODAL -->