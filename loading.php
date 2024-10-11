<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loading.css">
    <link rel="icon" type="image/x-icon" href="images/site-icon.ico">
</head>
<?php
require 'navbar.php';
?>
<h1>Il nostro sito spedisce alla velocità della luce...! &#x2728;</h1>
<body>
    <div class="container">
        <div class="moon">
            <div class="crater c1"></div>
            <div class="crater c2"></div>
            <div class="crater c3"></div>
            <div class="crater c4"></div>
            <div class="crater c5"></div>
            <div class="shadow"></div>
            <div class="eye el"></div>
            <div class="eyel er"></div>
            <div class="mouth"></div>
            <div class="blush"></div>
        </div>
        <div class ="orbit">
            <div class="rocket">
                <div class="window"></div>
            </div>
        </div>
        <h1>Il nostro sito spedisce alla velocità della luce...! &#x2728;</h1>
    <script>
    // reindirizza a order.php dopo 10 secondi
    
    setTimeout(function() {
        window.location.href = 'order_page.php';
    }, 10000);
    
    </script>
</body>
</html>
