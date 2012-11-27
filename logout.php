<?php
    session_start();
    if (@session_destroy())
        header("Location: http://localhost/index.php");
    else {
        echo "Can't destroy session";
    }
?>