<?php
ob_start();
require_once 'classes.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Game</title>
    </head>
    <body>
    <?php
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
        if (isset($_GET['time'])){
            $game_time = $_GET['time'];
            $game_time += 0;
            if (!(is_int($game_time))){
                echo 'Error. Time not a number.';
                $correct = false;
                $game_time = 15;
            }
            if ($game_time>60){
                    echo 'Error. Time > 60.';
                    $correct = false;
                $game_time = 15;
            }
            if ($game_time<5){
                    echo 'Error. Time < 5.';
                    $correct = false;
                $game_time = 15;
            }
        }else{
            echo 'Error. Time not set';
            $correct = false;
            $game_time = 15;
        }
        $gamefield = new Gamefield($sizeOfField);
        echo 'Size: '.$gamefield->getFieldSize().'<br>'.'Row: '.$gamefield->getRowSize().'<br>';
        echo 'Active: ';$gamefield->getActivePlayer();
        $game_end = false;
        $cells = $gamefield->getCells();
        for ($i=0;$i<$gamefield->getFieldSize()*$gamefield->getFieldSize();$i++){
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
            if ($i%$gamefield->getFieldSize() == $gamefield->getFieldSize()-1){
                echo '<br>';
            }
        }
        //echo '<img src="images/X.jpg" width="1024" alt="X"/>'
        //exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
        ob_end_flush();
    ?> 
    </body>
</html>