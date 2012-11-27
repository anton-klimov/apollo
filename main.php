<?php
{
    session_start();
    $username = "Гость";
    $photoUrl = "images/0.gif";
    $type = 2;

    if (isset($_SESSION['access_token'])) {
        $db_name = 'apollo';

        $link = mysql_pconnect('localhost', 'root', '');
        if (! $link) {
            die('Could not connect' . mysql_error());
        }

        if (!mysql_select_db($db_name)) {
            die("Could not connect to database");
        }

        $access_token = $_SESSION['access_token'];
        $sql_get_user = "SELECT name, access_token, photoUrl, type FROM users WHERE access_token=" ."'"
            . $access_token . "';";
        if (! $result = mysql_query($sql_get_user, $link)) {
            die("Could not get user" . mysql_error());
        }
        $row = mysql_fetch_array($result);
        if ($row) {
            $username = $row['name'];
            $photoUrl = $row['photoUrl'];
            $type = $row['type'];
        } else {

        }

        mysql_close($link);
    }
    echo "
        <div style='margin-top:5px; width: 100%;'>
            <div class='some_left_block border'>
                <div class='info_block'>
                <p style='margin-bottom:25px;'>Авторизация</p>
                <form style='margin-bottom: 10px; text-align: center;' method='post' action='auth.php'>
                    <div style='float: left; margin-left:10px;'>
                        <label for='login' style='float: left;'>Логин</label><br/>
                        <label for='pass' >Пароль</label>
                    </div>

                    <input type='text' class='input_box' id='login' name='login'>
                    <input type='password' class='input_box' id='pass' name='password'>
                    <input style='margin-top:10px;' type='submit' value='Войти'>
                </form>";
    if (! $row) {
        echo "<a href='http://localhost/register.php'>Регистрация</a>";
    } else {
        echo "<input type='submit' value='Выход' onmouseup=\"window.open('http://localhost/logout.php', '_self')\"/>";
        if ($type == 1) {
            echo "<input type='submit' value='Добавить товар' onmouseup=\"window.open('http://localhost/index.php?type=add_product', '_self')\"/>";
        }
    }
    echo "</div>";
    echo "<div class='info_block'>
                <p>Профиль</p>
                <img src=$photoUrl alt='Аватарка' style='width: 100px; height: 100px;'/>
                <p>Добро пожаловать, $username</p>
            </div>
        </div>
        <div class='main_text_block border' style='font-size:20pt;'>
            <p class='bold' style='text-align:center; margin-top:40px; margin-bottom:20px;'> Добро пожаловать на сайт посвящённый космическому кораблестроению</p>
            <p style='margin-top:40px;'>На данном сайте вы сможете подобрать косический корабль на любой вкус. Наш интернет-магазин
                                        предоставляет широкий ассортимент космических кораблей, которые смогут удовлетворить
                                        любые потребности: от полёту на дачу со всей семьёй на Марсе, вплоть до захвата
                                        галактики. Переходите в раздел магазин </p>

        </div>
    </div>
    ";
}
?>