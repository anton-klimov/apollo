<?php
{
    session_start();

    $db_name = 'apollo';
    $link = mysql_pconnect('localhost', 'root', '');
    if (! $link) {
        die('Could not connect' . mysql_error());
    }
    if (! mysql_select_db($db_name)) {
        die("Could not connect to database");
    }

    $query = "";
    $total = 0;
    if (isset($_SESSION['products'])) {
        foreach ($_SESSION['products'] as $i => $val) {
            $query = $query . "id=$i OR ";
        }
    }

    echo "<div class='main_text_block border' style='min-height:35px; width:100%; margin-bottom:5px;'>";
    if ($query !== "" && isset($_SESSION['products'])) {
        $query = substr($query, 0, strlen($query) - 4);
        $sql_get_selected_products = "SELECT id, title, price FROM articles WHERE " . $query . ";";

        $res = mysql_query($sql_get_selected_products);
        echo "<table border='1' cellspacing='0' cellpadding='4' style='margin: 10px 10px 10px 10px;'>
                <tr style='font-weight: bold;'>
                    <td>
                        № п/п
                    </td>
                    <td>
                        Название
                    </td>
                    <td>
                        Стоимость
                    </td>
                    <td>
                        Количество
                    </td>
                    <td>
                        Удалить
                    </td>
                </tr>
            ";
        $i = 0;
        $total = 0;
        $totalCount = 0;

        while ($row = mysql_fetch_array($res)) {
            $i = $i + 1;
            $count = $_SESSION['products'][$row['id']];
            $total = $total + $count * $row['price'];
            $totalCount = $totalCount + $count;
            echo "<tr>
                    <td style='text-align: center'>
                        $i
                    </td>
                    <td>
                        $row[title]
                    </td>
                    <td>
                        $row[price]
                    </td>
                    <td style='text-align: center'>
                        $count
                    </td>
                    <td style='text-align: center;'>
                        <input type='submit' value='Удалить' onmouseup='window.open(\"./remove_product.php?id=$row[id]\", \"_self\")'>
                    </td>
                </tr>";

        }
        echo "<td colspan='2' style='text-align: center; font-weight: bold;'>Итого</td><td>$total</td><td style='text-align: center;'>$totalCount</td><td><input type='submit' value='Очистить' onmouseup=\"window.open('./remove_product.php?id=all', '_self')\"/></td></table>";
    } else {
        echo "<p style='text-align: center; width: 100%;'>Ваша корзина пуста</p>";
    }
    echo "</div>";

echo "<p style='width: 100%; margin-top: 10px; margin-bottom:10px; text-align: center; color: red;'>$text</p>";
    mysql_close($link);
}
?>
