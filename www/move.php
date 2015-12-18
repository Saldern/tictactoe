<?php
require_once 'classes.inc.php';

$host='localhost';
$database='tictactoe';
$user='root';
$pswd='';
$link = mysql_connect($host, $user, $pswd) or die("Не удалось подключиться к MySQL.");
mysql_select_db($database) or die("Не удалось подключиться к БД");
$id = ((int)$_GET['id']);
$currentPlayer = (int)$_GET['currentPlayer'];

$query = sprintf("SELECT * FROM `tictactoe`.`gamefield` WHERE id='%s'", mysql_real_escape_string($id));
$res = mysql_query($query);
$row = mysql_fetch_assoc($res);
$game = new Gamefield();
$game->initGame($row);
$size = $game->getFieldSize();
$cells = $game->getCells();
$winnerCells = $game->getWinnerCells();


$params = $_GET + $_POST;
$action = $params['action'];
if($action == 'move')
{
    $game->makeMove((int)$params['x'], (int)$params['y']);  
    $t = $game->getCells();
    $str_cells = base64_encode( serialize($t));
    $t = $game->getWinnerCells();
    $str_winnerCells = base64_encode( serialize($t));

    $number = (int)1;
    if ($currentPlayer == 1) $number = (int)2;

    $query = "UPDATE `tictactoe`.`gamefield`  
                SET rowSize=".$game->getRowSize().",
                fieldSize=".$game->getFieldSize().",
                cells='".$str_cells."',
                winnerCells='".$str_winnerCells."',
                currentPlayer=".$game->getCurrentPlayer().", 
                winner=".$game->getWinner()."  
                 WHERE id=".$id;
    mysql_query($query) or trigger_error(mysql_error()." in ".$query);
    header("Location: game.php?id=".$id."&currentPlayer=".$currentPlayer);
}
?>