<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mu3AHTPOn
 * Date: 28.11.12
 * Time: 0:15
 * To change this template use File | Settings | File Templates.
 */
{
    $db_name = 'apollo';

    $link = mysql_pconnect('localhost', 'root', '');
    if (! $link) {
        die('Could not connect' . mysql_error());
    }

    if (!mysql_select_db($db_name)) {
        die("Could not connect to database");
    }

    $sql_get_products = "SELECT * FROM articles WHERE id=$_GET[id];";
    $row = mysql_fetch_array(mysql_query($sql_get_products));

    if (! $row) {
        echo "Bad id";
        return;
    }

    echo "
    <div class='main_text_block border' style='width:100%; min-height: 300px;'>
        <img src=$row[photoUrl] style= 'margin: 10px 10px 10px 10px; float: left; max-width: 400px; max-height: 300px;'>
        <p style='font-size: 20pt; font-weight: bold; text-align: center; margin-top: 20px;'>$row[title]</p>
        <p>$row[text]</p>
    </div>
    ";

    mysql_close($link);
}