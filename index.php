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
    <link rel="icon" type="image/x-icon" href="images/site-icon.ico">
</head>
<body class="has-navbar-fixed-top">
<?php
require 'navbar.php';
require 'view_products_script.php';
?>
<?php
    if(isset($_GET['logout'])) {
        echo '<article class="message is-success logout-message" id="logout-message">
                <div class="message-header">
                <p>Hai fatto logout !</p>
                </div>
             </article>';
        echo '<script type="text/javascript">
                setTimeout(function(){
                    document.getElementById("logout-message").style.display = "none";
                }, 3000);  // Nasconde il messaggio dopo 3 secondi
              </script>';
    }
?>
<!-- Presentazione del sito -->
<section class="section">
    <div class="container has-text-centered p-6">
        <h1 class="title is-1 is-spaced">NEGOZIO DI ROBE</h1>
        <p class="subtitle">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ullamcorper ligula sed lorem pharetra sodales.
        </p>
    </div>
</section>
<!-- Servizi speciali -->
<section class="section">
    <div class="container">
        <h2 class="title is-2 is-spaced">Perché acquistare qui?</h2>
            <p class="subtitle">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ullamcorper ligula sed lorem pharetra sodales.
            </p>
        <div class="columns">
            <div class="column is-two-fifths">
                <p class="title is-4">MOTIVO 1</p>
                <p class="subtitle"></p>
            </div>
            <div class="column is-two-fifths">
                <p class="title is-4">MOTIVO 2</p>
                <p class="subtitle"></p>
            </div>
            <div class="column is-two-fifths">
                <p class="title is-4">MOTIVO 3</p>
                <p class="subtitle"></p>
            </div>
        </div>
    </div>
</section>
<!-- Le novità -->
<section class="section">
    <div class="container">
        <h2 class="title is-2 is-spaced">Le novità</h2>
        <p class="subtitle is-spaced pb-5">Non perderti le ultime uscite!</p>
        <div class="grid is-col-min-12 is-gap-8">
            <?php
            $counter = 0;
            while (($row = $result->fetch_assoc()) && ($counter<8)){
                echo "<div class='cell p-4'><div class='card'><div class='card-image'><figure class='image'>";
                echo "<a href='product_page.php?recordid=". $row["recordid"] ."'><img src='images/" . $row['cover'] . ".png'></a>";
                echo "</figure></div><div class='card-content'><div class='media'><div class='media-content'>";
                echo "<p class='title is-4'>" . $row["title"] . "</p>";
                echo "<p class='subtitle is-5'>" . $row['artist'] . "</p>";
                echo "</div></div></div></div></div>";
                $counter+=1;
            }
            ?>
        </div>
    </div>
</section>
<!-- About us -->
<section class="section">
    <div class="container">
        <h2 class="title is-2 is-spaced">Dove trovarci</h2>
        <p class="subtitle">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ullamcorper ligula sed lorem pharetra sodales.
        </p>
    </div>
</section>
<?php
require 'footer.php';
?>
</body>
</html>