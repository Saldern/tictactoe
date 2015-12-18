<?php

$host='localhost';
$database='tictactoe';
$user='root';
$pswd='';
$link = mysql_connect($host, $user, $pswd) or die("Не удалось подключиться к MySQL.");
mysql_select_db($database) or die("Не удалось подключиться к БД");
$id = ((int)$_GET['id']);

$query = "DELETE FROM `tictactoe`.`gamefield`  
             WHERE winner > 0";
mysql_query($query) or trigger_error(mysql_error()." in ".$query);

$t = time() - 600;

$query = "DELETE FROM `tictactoe`.`gamefield`  
             WHERE time < ".$t;
mysql_query($query) or trigger_error(mysql_error()." in ".$query);

header("Refresh: 10");

?>