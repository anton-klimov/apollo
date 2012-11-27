<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mu3AHTPOn
 * Date: 27.11.12
 * Time: 0:25
 * To change this template use File | Settings | File Templates.
 */
{
    session_start();
    if (isset($_GET['id'])) {
        if ($_GET['id'] === 'all') {
            foreach ($_SESSION['products'] as $i) {

            }
            unset($_SESSION['products']);
        } else {
            $var = $_SESSION['products'][$_GET['id']];
            $var = $var - 1;

            if ($var == 0) {
                unset($_SESSION['products'][$_GET['id']]);
            } else {
                $_SESSION['products'][$_GET['id']] = $var;
            }
        }
        header("Location: http://localhost/index.php?type=basket");
    }
}
?>