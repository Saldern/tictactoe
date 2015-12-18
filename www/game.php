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


if (($id == NULL) || (!isset($_GET['id'])))  
{
   if (isset($_GET['sizeOfField']))
   {
    $sizeOfField = $_GET['sizeOfField'];
    $title = $_GET['title'];
    $sizeOfField += 0;
    $game = new Gamefield($sizeOfField);
    $query = "INSERT INTO `tictactoe`.`gamefield` 
    (`id`, `rowSize`, `fieldSize`, `cells`, `winnerCells`, `currentPlayer`,`winner`, `title`, `playersNumber`, `time`) 
    VALUES (NULL, '".$game->getRowSize()."', '".$game->getFieldSize()."', '', '', '1', '0', '".$title."', '1', '".time()."')";
    mysql_query($query);
    $id = mysql_insert_id();
    }
} 
else 
{
    $query = sprintf("SELECT * FROM `tictactoe`.`gamefield` 
        WHERE id='%s'", mysql_real_escape_string($id));
    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);

    if ($row['winner'] != 0)
    {
        if ($row['winner'] == $currentPlayer)
        {
            echo 'You winner<br>';
        }
        else
        {
            echo 'You loser<br>';
        }

    }
    else
    {
         if ($row['currentPlayer'] != $currentPlayer)
        {
            header('Refresh: 1');
            echo 'Turn of another player. Loading...<br>';
            exit();
        }   
    }


}

$query = sprintf("SELECT * FROM `tictactoe`.`gamefield` WHERE id='%s'", mysql_real_escape_string($id));
$res = mysql_query($query);
$row = mysql_fetch_assoc($res);
$game = new Gamefield();
$game->initGame($row);
$size = $game->getFieldSize();
$cells = $game->getCells();
$winnerCells = $game->getWinnerCells();


?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Game</title>
</head>
<body>     
    <!-- Отображаем состояние игры и игровое поле. -->
    <!-- CSS-стили, задающие внешний вид элементов HTML. -->
    <style type="text/css">
        .cells {overflow:hidden;}
        .row {clear:both;}
        .cell {float:left; border: 1px solid #ccc; width: 20px; height:20px;
            position:relative; text-align:center;}
        .cell a {position:absolute; left:0;top:0;right:0;bottom:0}
        .cell a:hover { background: #aaa; }
        .cell.winner { background:#f00;}

        .icon { display:inline-block; }
        .player1:after { content: 'X'; }
        .player2:after { content: 'O'; }
    </style>

    <?php if($game->getCurrentPlayer()) { ?>
    <!-- Отображаем приглашение сделать ход. -->
    Player 
    <div class="icon player<?php echo $game->getCurrentPlayer() ?>"></div> turn...
    <?php } ?>

    <?php if($game->getWinner()) { ?>
    <!-- Отображаем сообщение о победителе -->
    Player 
    <div class="icon player<?php echo $game->getWinner() ?>"></div> is a winner!
    <?php } ?>

    <!-- Рисуем игровое поле, отображая сделанные ходы
    и подсвечивая победившую комбинацию. -->    
    <div class="cells">
        <?php for($y=0; $y < $size; $y++) { ?>
        <div class="row">
            <?php for($x=0; $x < $size; $x++) {
                    // $player - игрок, сходивший в эту клетку :), или null, если клетка свободна.
                    // $winner - флаг, означающий, что эта клетка должна быть подсвечена при победе.
                $player = isset($cells[$x][$y])? $cells[$x][$y]: null;
                $winner = isset($winnerCells[$x][$y]);
                $class = ($player? ' player' . $player: '') . ($winner? ' winner': '');
                ?>
                <div class="cell<?php echo $class ?>">
                    <?php if(!$player) {
                        echo "<a href='move.php?id=".$id."&currentPlayer=".$currentPlayer."&action=move&amp;x=".$x."&amp;y=".$y."'></a>";
                    }?>
                </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</body>
</html>