<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - <?php echo $site_title; ?></title>
        <!------- HEAD --------->
            <?php $this->load->view("backend/_partials/head.php") ?>
            <link href="<?php echo base_url().'assets/css/bootstrap.css'?>" rel="stylesheet" type="text/css"/>
            <link href="<?php echo base_url('assets/css/main/appfront.css')?>" rel="stylesheet">
            <link href="<?php echo base_url().'assets/css/main/app-dark.css'?>" rel="stylesheet"/>
        <!------- HEAD --------->
        <style>
        #hidden_div {
            display: none;
        }
    
        </style>
</head>
<body>
<div id="app">
<div id="main" class="layout-horizontal">
<header class="mb-5">
    <div class="header-top">
        <div class="container">
          

                        
                   
        <div class="header-top-right">

                     
                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
        </div>
        </div>
    </div>
        <nav class="main-navbar">
            <div class="container">
                <ul>
                    
                    <li class="menu-item <?php echo $this->uri->segment(2) == 'dashboard' ? 'active': '' ?>">
                        <a href="<?php echo site_url('backend/dashboard');?>" class='menu-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $this->uri->segment(2) == 'absensi' ? 'active': '' ?>">
                        <a href="<?php echo site_url('backend/absensi');?>" class='menu-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Absensi</span>
                        </a>
                    </li>
            <!-- MENU KHUSUS ADMIN -->
                <?php if($this->session->userdata('access')=='1'):?>  
                    <li class="menu-item <?php echo $this->uri->segment(2) == 'log' ? 'active': '' ?>">
                        <a href="<?php echo site_url('backend/log');?>" class='menu-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Log Aktivitas User</span>
                        </a>
                    </li>

                    <li class="menu-item  has-sub">
                        <a href="#" class='menu-link'>
                            <i class="bi bi-stack"></i>
                            <span>Master Data</span>
                        </a>
                            <div class="submenu ">
                                <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                <div class="submenu-group-wrapper">
                                    <ul class="submenu-group">
                                        
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'konsumen' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/konsumen');?>" class='submenu-link'>Konsumen</a>
                                        </li>

                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'kategori' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/kategori');?>">Kategori</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'satuan' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/satuan');?>">Satuan</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'jenis_harga' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/jenis_harga');?>">Jenis Harga</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'warehouse' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/warehouse');?>">Warehouse</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'jenis_cicilan' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/jenis_cicilan');?>">Jenis Cicilan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </li>

                    <li class="menu-item  has-sub">
                        <a href="#" class='menu-link'>
                            <i class="bi bi-files"></i>
                            <span>Rekap Data</span>
                        </a>
                            <div class="submenu ">
                                <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                <div class="submenu-group-wrapper">
                                    <ul class="submenu-group">
                                        
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'rekap_stok_bahan' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/rekap_stok_bahan');?>">Rekap Stok Bahan Masuk</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'rekap_tim_produksi' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/rekap_tim_produksi');?>">Rekap Tim Produksi</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'rekap_surat_jalan' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/rekap_surat_jalan');?>">Rekap Surat Jalan</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'rekap_nota_transaksi_konsumen' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/rekap_nota_transaksi_konsumen');?>">Rekap Nota Transaksi Konsumen</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                    </li>
                    <li class="menu-item  has-sub">
                        <a href="#" class='menu-link'>
                            <i class="bi bi-stack"></i>
                            <span>Pengolahan Data</span>
                        </a>
                            <div class="submenu ">
                                <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                <div class="submenu-group-wrapper">
                                    <ul class="submenu-group">
                                        
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'pengeluaran' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/pengeluaran');?>" class='submenu-link'>Pengeluaran</a>
                                        </li>
                                        
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'tambah_stock_bahan' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/tambah_stock_bahan');?>">Tambah Stock Bahan</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'produksi_barang' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/produksi_barang');?>">Produksi Barang</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'surat_jalan' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/surat_jalan');?>">Surat Jalan</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'retur_barang_ekspedisi' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/retur_barang_ekspedisi');?>">Retur Barang Ekspedisi</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'transaksi' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/transaksi');?>">Transaksi</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'download_rekap' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/download_rekap');?>">Download Rekap</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'diagram_dan_statistik' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/diagram_dan_statistik');?>">Diagram dan Statistik</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'backupdata' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/backupdata');?>">Backup Data</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'detail_website' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/detail_website');?>" class='submenu-link'>Detail Website</a>
                                        </li>
                                        
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'profil' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/profil');?>">Profil Setting</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'users' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/users');?>">Users Karyawan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </li>
            <!-- END MENU KHUSUS ADMIN -->

            <!-- MENU KHUSUS EKSPEDISI -->
  
            <?php elseif($this->session->userdata('access')=='3'):?>
                <li class="menu-item  has-sub">
                        <a href="#" class='menu-link'>
                            <i class="bi bi-stack"></i>
                            <span>Ekspedisi Menu</span>
                        </a>
                            <div class="submenu ">
                                <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                <div class="submenu-group-wrapper">
                                    <ul class="submenu-group">
                                        
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'konsumen' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/konsumen');?>" class='submenu-link'>Konsumen</a>
                                        </li>
                                        
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'transaksi' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/transaksi');?>">Transaksi</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'rekap_nota_transaksi_konsumen' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/rekap_nota_transaksi_konsumen');?>">Rekap Nota Transaksi Konsumen</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'pengeluaran' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/pengeluaran');?>">Pengeluaran</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'retur_barang_ekspedisi' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/retur_barang_ekspedisi');?>">Retur Barang Ekspedisi</a>
                                        </li>
                                        <li class="submenu-item <?php echo $this->uri->segment(2) == 'profil' ? 'active': '' ?>">
                                            <a href="<?php echo site_url('backend/profil');?>">Profil</a>
                                        </li>
                                        
                                        
                                    </ul>
                                </div>
                            </div>
                    </li>






            <?php else:?>
            <!-- END MENU KHUSUS EKSPEDISI -->  
            <?php endif;?>

                    <?php if($this->session->userdata('level') == "1"){    ?>
                        <li class="menu-item">
                            <a href="<?php echo site_url('logout');?>" class='menu-link'>
                                <i class="bi bi-arrow-left"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="menu-item">
                            <a href="<?php echo site_url('logout_user');?>" class='menu-link'>
                                <i class="bi bi-arrow-left"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    <?php } ?>
                    
                    
                </ul>
            </div>
        </nav>
</header>
</div>
