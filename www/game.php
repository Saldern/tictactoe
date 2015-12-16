<?php
ob_start();
require_once 'classes.inc.php';
/*
где то здесь надо написать цикл, в котором висит игрок пока не получит свой ход
while(flag){
flag = запрос в бд()
что то в таком духе
}
*/
session_start();

// Получаем из сессии текущую игру.
// Если игры еще нет, создаём новую.
// глобальную сессию можно взять за основу
// и везде где операции с сессией заменить на операцию с БД
$game = isset($_SESSION['game'])? $_SESSION['game']: null; // здесь будет запрос в БД создана ли игра
if(!$game || !is_object($game)) { //создаем если нет
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
}

// Обрабатываем запрос пользователя, выполняя нужное действие.
$params = $_GET + $_POST;
if(isset($params['action'])){
    $action = $params['action'];
    if($action == 'move'){
        // Обрабатываем ход пользователя.
        $game->makeMove((int)$params['x'], (int)$params['y']);   
    }else if($action == 'newGame'){
        // Пользователь решил начать новую игру.
        $game = new Gamefield($_SESSION['size']); //перезапись в БД
    }else if($action == 'exit'){
        $_SESSION['game'] = null; //удаление игры из БД
        $game = null;
        header('Location: '.$redirect_page.'/..');
    }
}
// Добавляем вновь созданную игру в сессию. // в БД
$_SESSION['game'] = $game;
$_SESSION['size'] = $game->getFieldSize();
// Отображаем текущее состояние игры в виде HTML страницы.
$size = $game->getFieldSize();
$cells = $game->getCells();
$winnerCells = $game->getWinnerCells();

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
ob_end_flush();
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
                                <a href="?action=move&amp;x=<?php echo $x ?>&amp;y=<?php echo $y ?>"></a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <br/><a href="?action=newGame">Start a new game</a>
        <br/><a href="?action=exit">Delete session, exit</a>
    </body>
</html>
