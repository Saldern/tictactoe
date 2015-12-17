<?php
require_once 'classes.inc.php';

$host='localhost';
$database='tictactoe';
$user='root';
$pswd='';
$dbh = mysql_connect($host, $user, $pswd) or die("Не удалось подключиться к MySQL.");
mysql_select_db($database) or die("Не удалось подключиться к БД");
$id = ((int)$_GET['id']);
$playersNumber = (int)$_GET['playersNumber'];

if (($id == NULL) || (!isset($_GET['id'])))  
{
   if (isset($_GET['sizeOfField']))
   {
    $sizeOfField = $_GET['sizeOfField'];
    $sizeOfField += 0;
    $game = new Gamefield($sizeOfField);
    $query = "INSERT INTO `tictactoe`.`gamefield` 
    (`id`, `rowSize`, `fieldSize`, `cells`, `winnerCells`, `currentPlayer`,`winner`, `title`, `playersNumber`) 
    VALUES (NULL, '.$game->getRowSize().', '.$game->getRowSize().', '', NULL, '1', NULL, 'Title', '1')";
    mysql_query($query);
    }
} 
else 
{
    $query = sprintf("SELECT * FROM `tictactoe`.`gamefield` 
        WHERE id='%s'", mysql_real_escape_string($id));
    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);
    if ($row['playersNumber'] != $playersNumber)
    {
        header('Refresh: 3');
        echo 'Turn of another player. Loading...<br>';
        exit();
    }

	//заполение game
	//$size = $game->getFieldSize();
	//$cells = $game->getCells();
	//$winnerCells = $game->getWinnerCells();	
}


// Получаем из сессии текущую игру.
// Если игры еще нет, создаём новую.
/*$game = isset($_SESSION['game'])? $_SESSION['game']: null;
if(!$game || !is_object($game)) {
    if (isset($_GET['sizeOfField'])){
        $sizeOfField = $_GET['sizeOfField'];
        $sizeOfField += 0;
        if (!(is_int($sizeOfField))){
                $redirect_page = $_SERVER["HTTP_HOST"];
                echo 'Size not int.';
                header('Location: '.$redirect_page.'/..');
        }
        if ($sizeOfField>10){
                $redirect_page = $_SERVER["HTTP_HOST"];
                echo 'Size > 10.';
                header('Location: '.$redirect_page.'/..');
        }
        if ($sizeOfField<3){
                $redirect_page = $_SERVER["HTTP_HOST"];
                echo 'Size < 3.';
                header('Location: '.$redirect_page.'/..');
        }
    }else{
        $redirect_page = $_SERVER['HTTP_HOST'];
        echo 'Size not set.';
        header('Location: '.$redirect_page.'/..');
    }
    $game = new Gamefield($sizeOfField);
	
}*/

// Обрабатываем запрос пользователя, выполняя нужное действие.
/*$params = $_GET + $_POST;
if(isset($params['action'])){
    $action = $params['action'];
    if($action == 'move'){
        // Обрабатываем ход пользователя.
		
		//Вместо 179
        $game->makeMove((int)$params['x'], (int)$params['y']);   
    }else if($action == 'newGame'){
        // Пользователь решил начать новую игру.
        $game = new Gamefield($_SESSION['size']);
    }else if($action == 'exit'){
        $_SESSION['game'] = null;
        $game = null;
        header('Location: '.$redirect_page.'/..');
    }
}*/


// Добавляем вновь созданную игру в сессию.
//$_SESSION['game'] = $game;
//$_SESSION['size'] = $game->getFieldSize();
// Отображаем текущее состояние игры в виде HTML страницы.
//$size = $game->getFieldSize();
//$cells = $game->getCells();
//$winnerCells = $game->getWinnerCells();

/*for ($i=0;$i<$game->getFieldSize()*$game->getFieldSize();$i++){
    switch ($cells[$i]){
        case 0:
            echo '<img src="images/blank.jpg" border="1" alt="blank">';
            break;
        case 1:
            echo '<img src="images/X.bmp" border="1" alt="X">';
            break;
        case 2:
            echo '<img src="images/O.bmp" border="1" alt="O">';
            break;
    }
    if ($i%$game->getFieldSize() == $game->getFieldSize()-1){
        echo '<br>';
    }
}*/
//exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
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
                    <?php if(!$player) { ?>
                            <!-- Клетка свободна. Отображаем здесь ссылку,
                            на которую нужно кликнуть для совершения хода. -->

                            <!-- обновление бд -->

                            <a href="?action=move&amp;x=<?php echo $x ?>&amp;y=<?php echo $y ?>"></a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
    </body>
    </html>