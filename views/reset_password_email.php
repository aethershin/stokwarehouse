<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | <?php echo $site_title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo base_url('assets/images/logo/'.$site_icon)?>" type="image/x-icon">
    <link href="<?php echo base_url('assets/css/main/app.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/pages/auth.css')?>" rel="stylesheet">

        <meta name="description" content="<?php echo $site_deskripsi; ?>"/>
        <meta property="og:locale" content="id_ID" />
        <meta property="og:type" content="registration" />
        <meta property="og:title" content="<?php echo $title; ?>" />
        <meta property="og:description" content="<?php echo $site_deskripsi; ?>" />
        <meta property="og:site_name" content="<?php echo $site_title; ?>" />
        <meta name="twitter:description" content="<?php echo $site_deskripsi; ?>" />
        <meta name="twitter:title" content="<?php echo $title; ?>" />
        <meta name="twitter:site" content="<?php echo $site_title; ?>" />

</head>

<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle mb-5 display-4">Masukkan Email Terdaftar</p>

            
            <?php 
                echo form_open('login_user/validate');
            ?>
                <?php echo $this->session->flashdata('msg');?>

                <div class="form-group position-relative has-icon-left mb-4">
                    <?php echo $form_username; ?>
                    
                    <div class="form-control-icon">
                        <i class="bi bi-google"></i>
                    </div>
                </div>
        
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim</button>
            <?php
                echo form_close();
            ?>
           
            <div class="text-center mt-5 text-lg fs-4">
               
                <p><a class="font-bold" href="<?php echo site_url('login_user')?>">Kembali Login</a></p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">
            
        </div>
    </div>
</div>

    </div>

</body>
    <script src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/app.js'?>"></script>
</html>
