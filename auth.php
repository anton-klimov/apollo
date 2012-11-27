<?php
{    $secret_key = "8W5ku7m239[B9603<04+582G5F6tPK";

    $login=$_POST['login'];
    $password = $_POST['password'];

    $db_name = 'apollo';

    $link = mysql_pconnect('localhost', 'root', '');
    if (! $link) {
        die('Could not connect' . mysql_error());
    }

    if (!mysql_select_db($db_name)) {
        die("Could not connect to database");
    }

    $sql_get_user = "SELECT * FROM users WHERE name=" ."'" . $login . "' AND password=" . "'" . $password . "'";
    if (! $result = mysql_query($sql_get_user, $link)) {
        die("Could not get user" . mysql_error());
    }

    $row = mysql_fetch_array($result);
    if (! $row) {
        die("Wrong login or password");
    }

    $access_token = sha1($row['name'] . $secret_key);
    $put_access_token = "UPDATE users SET access_token='" . $access_token . "' WHERE name=" . "'"
        . $login . "' AND password=" . "'" . $password . "';";

    if (! mysql_query($put_access_token)) {
        die("Can't save access_token");
    }

//    session_destroy();
    session_start();
    $_SESSION['access_token'] = $access_token;


//    echo $_SESSION['access_token'];
    mysql_close($link);

    header("Location: http://localhost/index.php");
//    ob_end_flush();
}
?>