<?php
{
    session_start();
    if(!empty($_POST)){
        //global $_FILES;
        $db_name = 'apollo';

        $link = mysql_pconnect('localhost', 'root', '');
        if (! $link) {
            die('Could not connect' . mysql_error());
        }

        if (!mysql_select_db($db_name)) {
            die("Could not connect to database");
        }

        $about = $_POST['about'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $image = $_FILES['image'];

        if (! $about) {
            $_SESSION['empty_about'] = true;
        } else if (! $title) {
            $_SESSION['empty_title'] = true;
        } else if (! $price) {
            $_SESSION['empty_price'] = true;
        } else if (! $image['name']) {
            $_SESSION['empty_image'] = true;
        } else {
            //Так работать не будет - надо сперва сделать загрузку как в примере
            //$photo = "http://" . $_SERVER['HTTP_HOST'] . "/img/" . basename($_FILES['image']['name']);

            $access_token = $_SESSION['access_token'];
            $sql_get_user = "SELECT type FROM users WHERE access_token=" ."'" . $access_token . "';";
            if (! $result = mysql_query($sql_get_user, $link)) {
                die("Could not get user" . mysql_error());
            }
            $row = mysql_fetch_array($result);
            if ($row) {
                echo $row['type'];
                if ($row['type'] != 1) {
                    return;
                }
            }

            $target_path = "images/";
            $target_path = $target_path . microtime(true) . basename( $_FILES['image']['name']);
            if(! move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $target_path = "images/grey.png";
            }
            //echo $photo;

    //    if ($about === "") {
    //        die("Empty field");
    //    }
            $curr_date = date('r');
            $add_article_sql = "INSERT INTO articles(user, title, text, price, photoUrl)
                            VALUES (1, '$title', '$about', '$price', '$target_path');";

            if (! mysql_query($add_article_sql)) {
                $_SESSION['title'] = $title;
            } else {
                unset($_POST['about']);
                unset($_POST['title']);
                unset($_POST['price']);
                unset($_POST['image']);
                $_SESSION['added'] = true;
            }
        }
    }
}
    echo "
    <div style='margin-top:5px; width: 100%;'>
        <div style='background-color: rgb(255, 255, 255); width: 100%; margin-bottom:10px; padding: 10px;' class='border'>
            <form action='' enctype='multipart/form-data' method='post'>
                <label for='title'>Заголовок</label>
                <input type='text' id='title' name='title' value=$_POST[title]><br/>
                <label for='price'>Цена, грн</label>
                <input type='text' id='price' name='price' value=$_POST[price]><br/>
                <label for='image'>Изображение</label>
                <input type='file' accept='image/*' name='image' id='image'/><br/>
                <label for='about'>Описание</label>
                <textarea rows='15' cols='100' name='about' id='about'>$_POST[about]</textarea>
                <input type='submit' value='Создать'/>
            </form>
            ";
        {
//                session_start();
            $text = "";
//            if ($_POST) {
                if ($_SESSION['added']) {
                    unset($_SESSION['added']);
                    $text = "Товар успешно добавлен";
                } else if ($_SESSION['empty_title']) {
                    unset($_SESSION['empty_title']);
                    $text = "Пустой заголовок";
                } else if ($_SESSION['empty_about']) {
                    unset($_SESSION['empty_about']);
                    $text = "Пустое описание";
                }
                else if ($_SESSION['empty_price']) {
                    unset($_SESSION['empty_price']);
                    $text = "Пустая цена";
                }
                else if ($_SESSION['empty_image']) {
                    unset($_SESSION['empty_image']);
                    $text = "Пустое изображение";
                } if (! ($_SESSION['title'] === "")) {
                    $sql_get_article = "SELECT id FROM articles WHERE title='" . $_SESSION['title'] . "';";
                    $res = mysql_query($sql_get_article);
                    $row = mysql_fetch_array($res);
                    if ($row) {
                        $text = "Товар с таким именем уже существует";
                    }
                    unset($_SESSION['title']);

                }
                echo "<p style='width: 100%; margin-top: 10px; margin-bottom:10px; text-align: center; color: red;'>$text</p>";
//            }
        }
echo "
        </div>
    </div>
    <div style='clear: both;'></div>
";
?>
