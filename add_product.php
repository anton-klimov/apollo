<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mu3AHTPOn
 * Date: 26.11.12
 * Time: 20:51
 * To change this template use File | Settings | File Templates.
 */
{
    header("Location: http://localhost/index.php?type=store", "_self");
    session_start();
//    session_destroy();
    if (isset($_GET['id'])) {
        $_SESSION['products'][$_GET['id']] = $_SESSION['products'][$_GET['id']] + 1;
//        foreach ($_SESSION['products'] as $i => $value) {
//            echo $value . ", ";
//        }
    }
}
?>