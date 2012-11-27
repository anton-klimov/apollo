<?php
$db_name = 'apollo';

$link = mysql_pconnect('localhost', 'root', '');
if (! $link) {
    die('Could not connect' . mysql_error());
}

if (! mysql_query("DROP DATABASE IF EXISTS $db_name;", $link)) {
    die('Could not drop database' . mysql_error());
}

if (! mysql_query("CREATE DATABASE IF NOT EXISTS $db_name;", $link)) {
    die('Could create database' . mysql_error());
}
//Create table
mysql_select_db("$db_name", $link);
$user_types_table_name = "user_types";
$sql_crete_user_types = "CREATE TABLE IF NOT EXISTS $user_types_table_name(id INT AUTO_INCREMENT,
	name varchar(5) NOT NULL UNIQUE, PRIMARY KEY (id)) ENGINE=INNODB;";
if (! mysql_query($sql_crete_user_types, $link)) {
    die ("Could ot create table $user_types_table_name" . mysql_error());
}
$sql_add_user_type_admin = "INSERT INTO $user_types_table_name(name) VALUES ('admin');";
$sql_add_user_type_user = "INSERT INTO $user_types_table_name(name) VALUES ('user');";
if (! mysql_query($sql_add_user_type_admin, $link)) {
    die("Could not add entry" . mysql_error());
}
mysql_query($sql_add_user_type_user, $link);

$sql_create_users_table = "CREATE TABLE IF NOT EXISTS users(id INT AUTO_INCREMENT,
                                    name varchar(20) NOT NULL UNIQUE, password VARCHAR(20) NOT NULL,
                                    type int DEFAULT 2, INDEX type_id (type), access_token VARCHAR(40),
                                    email VARCHAR(40) NOT NULL UNIQUE, photoUrl VARCHAR(100) DEFAULT
                                    'http://localhost/images/0.gif',
                                    PRIMARY KEY(id), FOREIGN KEY(type) REFERENCES
                                    $user_types_table_name(id) ON DELETE CASCADE) ENGINE=INNODB;";
if (! mysql_query($sql_create_users_table, $link)) {
    die ("Could ot create table users" . mysql_error());
}

$articles_table_name = "articles";
$sql_create_articles_table = "CREATE TABLE IF NOT EXISTS $articles_table_name(id INT AUTO_INCREMENT,
                                    user INT NOT NULL, INDEX user_id(user), title VARCHAR(100) NOT NULL UNIQUE,
                                    text LONGTEXT, photoUrl VARCHAR(100),price DECIMAL NOT NULL,
                                    PRIMARY KEY(id), FOREIGN KEY(user) REFERENCES users(id))
                                    ENGINE=INNODB;";

$sql_add_admin = "INSERT INTO users(name, password, email, type) VALUES('admin', 'admin', 'rufus-90@mail.ru', 1);";
if (!mysql_query($sql_add_admin, $link)) {
    die ("Could ot create admin" . mysql_error());
}

if (!mysql_query($sql_create_articles_table, $link)) {
    die ("Could ot create table $articles_table_name" . mysql_error());
}

mysql_close($link);
echo "Ok";
?>