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

    $count  = 0;
    $total = 0;

    if (isset($_SESSION['products'])) {
        foreach ($_SESSION['products'] as $i => $val) {
            $query = $query . "id=$i OR ";
        }
    }

    if ($query !== "" && isset($_SESSION['products'])) {
        $query = substr($query, 0, strlen($query) - 4);
        $sql_get_selected_products = "SELECT id, title, price FROM articles WHERE " . $query . ";";

        $res = mysql_query($sql_get_selected_products);
        while ($row = mysql_fetch_array($res)) {
            $count = $count + $_SESSION['products'][$row['id']];
            $total = $total + $count * $row['price'];
        }
    }

    if ($count == 1) {
        $prod = "товар";
    } else if ($count < 5 && $count > 1) {
        $prod = "товара";
    } else {
        $prod = "товаров";
    }

    echo "
    <div class='header border'>
			</div>

			<div class='main_panel border'>
			<div style='float: right; height: 100%; min-width: 200px; margin-top:8px;'>
			    У вас в <a href='index.php?type=basket'>корзине</a> $count $prod<br/>
			    На сумму - $total
			</div>
				<ul style='margin-left: 10%; list-style-type: none; margin-top:15px;'>
					<li>
						<a class='test' href='/' title='Главная страница'>Главная</a>
					</li>
					<li>
						<a class='test' href='index.php?type=store' title='Основной блок'>Магазин</a>
					</li>
					<li>
						<a class='test' href='index.php?type=tech' title='Технические характеристики'>Технические характеристики</a>
					</li>
					<li>
						<a  class='test' href='about.php' title='О сайте'>О сайте</a>
					</li>
				</ul>
			</div>
			";
    mysql_close($link);
}
?>