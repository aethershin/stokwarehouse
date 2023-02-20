
<div class="page-content">
    <!------- breadcrumb --------->
        <?php $this->load->view("backend/_partials/breadcrumb.php") ?>
    <!------- breadcrumb --------->
    <section id="input-validation">
        
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class=" col-12 col-md-6 mt-2">
                                <div class="list-group">   
                                    <div class="list-group-item list-group">
                                        <form action="<?php echo base_url().'backend/download_rekap/download_excel_rekap_setoran'?>" method="post">
                                            <div class="form-group">
                                                <label for="basicInput">Dari</label>
                                                <input  type="date" name="dari" class="form-control dari" id="dari" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="basicInput">Sampai</label>
                                                <input  type="date" name="sampai" class="form-control sampai" id="sampai" required>
                                            </div>
                                            <button type="submit" class="btn icon icon-left btn-primary"><i class="bi bi-download"></i> Excel Rekap Setoran</button>
                                        
                                        </form>
                                    </div>
                                </div>  
                            </div>  
                            <div class=" col-12 col-md-6 mt-2">
                                <div class="list-group">   
                                    <div class="list-group-item list-group">
                                        <form action="<?php echo base_url().'backend/download_rekap/download_excel_rekap_nota'?>" method="post">
                                            <div class="form-group">
                                                <label for="basicInput">Dari</label>
                                                <input  type="date" name="dari" class="form-control dari" id="dari" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="basicInput">Sampai</label>
                                                <input  type="date" name="sampai" class="form-control sampai" id="sampai" required>
                                            </div>
                                            <button type="submit" class="btn icon icon-left btn-primary"><i class="bi bi-download"></i> Excel Rekap Nota</button>
                                        
                                        </form>
                                    </div>
                                </div>  
                            </div>
                            <div class=" col-12 col-md-6 mt-2">
                                <div class="list-group">   
                                    <div class="list-group-item list-group">
                                        <form action="<?php echo base_url().'backend/download_rekap/download_excel_rekap_pengeluaran'?>" method="post">
                                            <div class="form-group">
                                                <label for="basicInput">Dari</label>
                                                <input  type="date" name="dari" class="form-control dari" id="dari" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="basicInput">Sampai</label>
                                                <input  type="date" name="sampai" class="form-control sampai" id="sampai" required>
                                            </div>
                                            <button type="submit" class="btn icon icon-left btn-primary"><i class="bi bi-download"></i> Excel Rekap Pengeluaran</button>
                                        
                                        </form>
                                    </div>
                                </div>  
                            </div> 
                            
                            <div class=" col-12 col-md-6 mt-2">
                                <div class="list-group">   
                                    <div class="list-group-item list-group">
                                        <form action="<?php echo base_url().'backend/download_rekap/download_excel_rekap_tim_produksi'?>" method="post">
                                            <div class="form-group">
                                                <label for="basicInput">Dari</label>
                                                <input  type="date" name="dari" class="form-control dari" id="dari" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="basicInput">Sampai</label>
                                                <input  type="date" name="sampai" class="form-control sampai" id="sampai" required>
                                            </div>
                                            <button type="submit" class="btn icon icon-left btn-primary"><i class="bi bi-download"></i> Excel Rekap Tim Produksi</button>
                                        
                                        </form>
                                    </div>
                                </div>  
                            </div>
                            <div class=" col-12 col-md-6 mt-2">
                                <div class="list-group">   
                                    <div class="list-group-item list-group">
                                        <form action="<?php echo base_url().'backend/download_rekap/download_excel_rekap_tambah_stok'?>" method="post">
                                            <div class="form-group">
                                                <label for="basicInput">Dari</label>
                                                <input  type="date" name="dari" class="form-control dari" id="dari" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="basicInput">Sampai</label>
                                                <input  type="date" name="sampai" class="form-control sampai" id="sampai" required>
                                            </div>
                                            <button type="submit" class="btn icon icon-left btn-primary"><i class="bi bi-download"></i> Excel Rekap Tambah Stok Warehouse</button>
                                        
                                        </form>
                                    </div>
                                </div>  
                            </div>   
                            <div class=" col-12 col-md-6 mt-2">
                                <div class="list-group">   
                                    <div class="list-group-item list-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <form action="<?php echo base_url().'backend/download_rekap/download_excel_rekap_stok_bahan_warehouse'?>" method="post">
                                                    
                                                    <button type="submit" class="btn icon icon-left btn-primary"><i class="bi bi-download"></i> Excel Rekap Stok Bahan Warehouse</button>
                                                
                                                </form>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <form action="<?php echo base_url().'backend/download_rekap/download_excel_rekap_stok_produk_ready_sale'?>" method="post">
                                                    
                                                    <button type="submit" class="btn icon icon-left btn-primary"><i class="bi bi-download"></i> Excel Rekap Stok Produk Ready Sale</button>
                                                
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div> 
                        </div>
                    </div>
                </div>
          
    </section>
</div>
        <!------- FOOTER --------->
            <?php $this->load->view("backend/_partials/footer.php") ?>
        <!------- FOOTER --------->
        </div>
    </div>

<!------- TOASTIFY JS --------->
    <?php $this->load->view("backend/_partials/toastify.php") ?>
 
<!------- TOASTIFY JS --------->

</body>
</html>
