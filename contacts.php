<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
?>
<!doctype html>
<html lang="it" class="theme-dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Negozio di vinili spaziale</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="images/site-icon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="has-navbar-fixed-top">
<?php
require 'navbar.php';
?>
<section class="section">
    <div class="wrapper">
        <div class="container has-text-centered p-6">
            <h1 class="title is-1 text-light">Contatti:</h1>
            <h5 class="title is-5 text-light">
                <span class="icon">
                    <i class="fas fa-envelope-open-text"></i>
                </span>
                : MonicaBellucci@gmail.com
            </h5>
            <h5 class="title is-5 text-light">
                <span class="icon">
                    <i class="fas fa-phone"></i>
                </span>
                : +370834933404
            </h5>
            <h5 class="title is-5 text-light">
            <h5 class="title is-5 text-light">
                <span class="icon">
                    <i class="fas fa-address-book"></i>
                </span>
                : Base Spaziale su Marte
            </h5>
        </div>
    </div>
</section>

<?php 
require 'footer.php'; 
?>
</body>
</html>
