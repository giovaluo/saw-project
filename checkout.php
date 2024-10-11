<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['login'])){
    header("Location: login.php");
} else if (!isset($_POST['checkout'])) {
    header ("Location: cart.php");
}
//prendiamo il totale del carrello
$cartid = $_SESSION['cart'];
$userid = $_SESSION['id'];

include 'db/connect_to_db.php';
$query = "SELECT total FROM carts WHERE cartid=? AND userid=?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error . " (" . $conn->errno . ")", 0, "errors/errors.log");
    exit("Something went wrong... try again later.");
}
if (!($stmt->bind_param("ii", $cartid, $userid))) {
    error_log("Binding parameters failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
    exit("Something went wrong... try again later.");
}
if (!($stmt->execute())) {
    error_log("Execute failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
    exit("Something went wrong... try again later.");
}
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total = $row['total'];
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="it" class="theme-dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mex_alert.css">
    <link rel="icon" type="image/x-icon" href="images/site-icon.ico">
</head>
<body class="has-navbar-fixed-top">
<?php
include 'navbar.php';
?>
<div class="container">
    <h1 class="p-6 title is-1">CHECKOUT</h1>
    <p class="subtitle">Spedizione gratuita e consegna alla velocità della luce in tutta la Via Lattea!</p>
</div>
<?php
    if ($result->num_rows == 0){
        echo '<p class="p-6 subtitle has-text-danger">Il tuo carrello è vuoto, cosa vuoi pagare?<p>';
    } else {
        echo '<section>
                  <div class="column p-6 is-12 is-4-widescreen">
                        <div class="wrapper">
                            <h3 class="title is-3">Totale</h3>
                                <div class="pb-5 is-flex is-justify-content-space-between is-align-items-center">
                                <span>Totale parziale</span>';
        echo '<span class="subtitle has-text-weight-bold">'.$total.'€</span></div>';
        echo '<div class="mb-6 is-flex is-justify-content-space-between is-align-items-center">
            <span class="has-text-grey">Spedizione</span>
            <span class="subtitle has-text-weight-bold">0.00 €</span>
            </div>
            <div class="mb-5 is-flex is-justify-content-space-between is-align-items-center" style="border-top: 2px solid white">
                <span class="title is-size-5 mt-5 has-text-weight-bold">Order total</span>
                <span class="title is-size-5 has-text-weight-bold">'.$total.'€</span></div>';
        echo '<form action="order_add_script.php" method="post">
                <button type="submit" name="add_order" value="'.$total.'" class="button is-link">Ordina</button>
              </form></section>';
    }
?>
<?php
include 'footer.php';
?>
<script src="js/mex_alert.js"></script>
</body>
</html>