<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['login'])){
    header("Location: login.php");
}
if ($_SESSION['role']!='admin'){
    header("Location: errors/403.php");
}
?>
<!DOCTYPE html>
<html lang="it" class="theme-dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin ordini</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="images/site-icon.ico">
</head>
<body class="has-navbar-fixed-top">
<?php
include 'navbar.php';
include 'get_order_details.php';
include 'admin_delete_detail.php';
?>
<section class="section has-background-light">
    <div class="container mb-5">
    </div>
    <div class="container">
        <?php
        echo "<h3 class='title is-4 is-spaced'>" . $_SESSION["firstname"] . ", stai modificando l'ordine ".$orderid." </h3>";
        ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" class="big-screen" style="width: 200px">Record</th>
                <th scope="col" class="big-screen" style="width: 200px">Nome</th>
                <th scope="col" class="big-screen" style="width: 200px">Artista</th>
                <th scope="col" class="big-screen" style="width: 200px">Quantità</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row=$result->fetch_assoc()){
                echo '<td class="big-screen">'.$row['recordid'].'</td>';
                echo '<td class="big-screen">'.$row['title'].'</td>';
                echo '<td class="big-screen">'.$row['artist'].'</td>';
                echo '<td class="big-screen">'.$row['quantity'].'</td>';
                echo '<td>';
                echo '<form action="admin_order_details.php" method="post">
                    <button class="button is-small mb-2 p is-warning" type="submit" name="delete_one" value="' . $row['orderdetailid'] . '" onclick="setLocalStorage(\'oneRemoved\')">Rimuovi uno</button>
                    <button class="button is-small mb-2 p is-danger" type="submit" name="delete_detail" value="' . $row['orderdetailid'] . '" onclick="setLocalStorage(\'orderDeleted\')">Elimina dettaglio</button>
                </form>';
            }?>
            </tbody>
        </table>
    </div>
</section>
<div id="notification" class="notification"></div>
<?php
include 'footer.php';
?>
</body>
</html>