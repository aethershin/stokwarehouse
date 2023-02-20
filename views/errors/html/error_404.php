<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eror 404</title>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/main/app.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/pages/error.css'?>">
    <link rel="shortcut icon" href="<?php echo base_url().'assets/images/logo/favicon.svg'?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url().'assets/images/logo/favicon.png'?>" type="image/png">
</head>

<body>
    <div id="error">
        

<div class="error-page container">
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="<?php echo base_url().'assets/images/error-404.svg'?>" alt="Not Found">
            <h1 class="error-title">NOT FOUND</h1>
            <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
            <a href="<?php echo site_url($link);?>" class="btn btn-lg btn-outline-primary mt-3"><?php echo $keterangan; ?></a>
        </div>
    </div>
</div>


    </div>
</body>

</html>
