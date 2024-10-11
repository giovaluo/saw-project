<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "s5038815";

    // approccio object-oriented.
    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_errno){
        error_log("Connection failed: ". $conn->connect_error);
        exit("Qualcosa è andato storto... riprova più tardi.");
    }
?>
