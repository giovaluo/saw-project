<?php
    $_SESSION = array();

    session_destroy();
    setcookie(session_name(),'',time() - 3600, "/");
    header("Location: index.php?logout=true");
?>