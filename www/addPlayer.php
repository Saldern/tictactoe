<?php

$host='localhost';
$database='tictactoe';
$user='root';
$pswd='';
$link = mysql_connect($host, $user, $pswd) or die("Не удалось подключиться к MySQL.");
mysql_select_db($database) or die("Не удалось подключиться к БД");
$id = ((int)$_GET['id']);

$query = "UPDATE `tictactoe`.`gamefield`  
            SET playersNumber=2  
             WHERE id=".$id;
mysql_query($query) or trigger_error(mysql_error()." in ".$query);
header("Location: game.php?id=".$id."&currentPlayer=2");

?>