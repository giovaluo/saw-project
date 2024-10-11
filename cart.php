<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['login'])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="it" class="theme-dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrello</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="images/site-icon.ico">
</head>
<body class="has-navbar-fixed-top">
<?php
include 'navbar.php';
include 'cart_script.php';
include 'remove_from_cart.php';
include 'checkout_script.php';
?>
<section class="section">
    <div class="container">
        <h2 class="title is-1">Il tuo carrello</h2>
        <?php
            if($result->num_rows==0){
                echo '
                <article class="message is-danger">
                    <div class="message-body">
                    <strong>Il tuo carrello è vuoto !</strong>
                    </div>
                </article>
                ';
            } else {
                echo '<form action="cart.php" method="POST">';
                echo '<button type="submit" name="flush_cart" value=' . $_SESSION['cart'] . ' class="button mt-4 is-danger is-fullwidth" style="width: 50%">Svuota carrello</button></form>';
                echo '
                <div class="column is-12 is-8-widescreen mb-8 mb-0-widescreen">
                    <div class="is-hidden-touch columns" style="border-bottom: 1px solid grey;">
                        <div class="column is-4">
                            <h4 class="has-text-grey has-text-weight-bold">Prodotto</h4>
                        </div>
                        <div class="column is-4">
                            <h4 class="has-text-grey has-text-weight-bold">Quantità</h4>
                        </div>
                        <div class="column is-4">
                            <h4 class="has-text-grey has-text-weight-bold">Totale</h4>
                        </div>
                    </div>
                    </div>';

                $total_price = 0;
                while ($row = $result->fetch_assoc()) {
                $total_price += floatval($row['quantity'] * $row['price']);
                echo'<div class="columns">
                        <div class="column is-4 mb-3">
                        <div class="is-flex is-justify-content-center is-align-items-center" style="width: 96px; height: 128px;">
                        <img class="image is-fullwidth" style="object-fit: contain;" src="images/' . $row['cover'] . '.png" alt="">
                        </div>
                     
                        <div class="column is-8">
                        <h3 class="subtitle mb-2 has-text-weight-bold">' . $row['title'] . '</h3>
                        <p class="has-text-grey">' . $row['artist'] . '</p>
                    </div>
                    </div>
                    <div class="column is-3">
                    <p class="subtitle has-text-weight-bold">' . $row['quantity'] . '</p>
                    </div>
                    <div class="column is-3">
                    <p class="subtitle has-text-weight-bold">' . floatval($row['quantity'] * $row['price']) . ' €</p>
                    </div>
                    <div class="column is-3">
                    <form action="cart.php" method="POST">
                    <button type="submit" name="remove_one" value=' . $row['recordid'] . ' class="button mt-4 is-danger is-fullwidth" style="width: 50%">Rimuovi uno</button>
                    <button type="submit" name="remove_all" value=' . $row['recordid'] . ' class="button mt-4 is-danger is-fullwidth" style="width: 50%">Rimuovi tutti</button>
                    </form>
                    </div>
                    </div>
                   
                    ';
                /*echo '<div class="column is-6-desktop is-7-tablet mb-0-tablet"> <div class="columns is-vcentered is-multiline"><div class="column is-4 mb-3"><div class="is-flex has-background-light is-justify-content-center is-align-items-center" style="width: 96px; height: 128px;">';
                echo '<img class="image is-fullwidth" style="object-fit: contain;" src="images/' . $row['cover'] . '.png" alt="">';
                echo '</div></div></div> <div class="column is-8">';
                echo '<h3 class="subtitle mb-2 has-text-weight-bold">' . $row['title'] . '</h3>';
                echo '<p class="has-text-grey">' . $row['artist'] . '</p></div></div>';
                echo '<div class="column">';
                echo '<p class="subtitle has-text-weight-bold">' . $row['quantity'] . '</p>';
                echo '<form action="cart.php" method="POST">';
                echo '<button type="submit" name="remove_one" value=' . $row['recordid'] . ' class="button mt-4 is-danger is-fullwidth" style="width: 50%">Rimuovi uno</button></form>';
                echo '</div><div class="column">';
                echo '<div class="column">';
                echo '<p class="subtitle has-text-weight-bold">' . floatval($row['quantity'] * $row['price']) . ' €</p>';
                echo '<form action="cart.php" method="POST">';
                echo '<button type="submit" name="remove_all" value=' . $row['recordid'] . ' class="button mt-4 is-danger is-fullwidth" style="width: 50%">Rimuovi tutti</button></form>';
                echo '</div><div class="column">';
                echo '</div></div></div></div>';*/
                // Aggiorna il totale nel carrello nella tabella 'cart'
                $query = "UPDATE carts SET total = ? WHERE cartid = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("di", $total_price, $_SESSION['cart']);
                $stmt->execute();
            }
            echo'</div>
        
    </div>
    <div class="box">
            <h3 class="title is-3 has-text-white">Totale</h3>
            <div class="pb-5 is-flex is-justify-content-space-between is-align-items-center">';
                if($result->num_rows!=0) {
                    echo '<span class="subtitle has-text-white has-text-weight-bold">' . $total_price . '€</span>';
                }


                echo'<form action="checkout.php" method="POST">
                    <button type="submit" name="checkout" value='.$total_price.' class="button mt-4 is-link is-fullwidth" style="width: 100%">Vai al checkout</button>
                </form>
            </div>';
    }
            ?>
    </div>
</section>
<?php
include 'footer.php';
?>
</body>
</html>
