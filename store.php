<?php
{
    session_start();
    echo "<div class='main_text_block border' style='min-height:200px; width:100%; margin-bottom:5px;'>
        <table border='1' cellspacing='0' cellpadding='4' style='text-align: center; margin: 10px 10px 10px 10px;'>
                            <tr style='font-weight: bold;'>
                                <td>
                                    № п/п
                                </td>
                                <td>
                                    Фото
                                </td>
                                <td>
                                    Название
                                </td>
                                <td>
                                    Стоимость, грн.
                                </td>
                                <td>
                                    Добавить в корзину
                                </td>
                                <td>
                                    Описание
                                </td>
                            </tr>
                        ";
    $i = 0;
    $db_name = 'apollo';

    $link = mysql_pconnect('localhost', 'root', '');
    if (! $link) {
        die('Could not connect' . mysql_error());
    }

    if (!mysql_select_db($db_name)) {
        die("Could not connect to database");
    }

    $sql_get_products = "SELECT * FROM articles;";
    $res = mysql_query($sql_get_products);
    while ($row = mysql_fetch_array($res)) {
        $i = $i + 1;
        echo "
            <tr>
                <td>
                    $i
                </td>
                <td>
                    <img src=$row[photoUrl] style='width:200px; height: 125px;' onmouseup='window.open(\"$row[photoUrl]\")'>
                </td>
                <td>
                    $row[title]
                </td>
                <td>
                    $row[price]
                </td>
                <td >
                    <input type='submit' value='Добавить' onmouseup='window.open(\"add_product.php?id=$row[id]\", \"_self\")'>
                </td>
                <td >
                    <input type='submit' value='Описание' onmouseup='window.open(\"./index.php?type=about_product&id=$row[id]\", \"_self\")'>
                </td>
            </tr>
        ";
    }
    echo "</table></div>";
}
    mysql_close($link);
?>