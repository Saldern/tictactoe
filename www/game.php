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
        if (isset($_POST['sizeOfField'])){
                $sizeOfField = $_POST['sizeOfField'];
                if ((!(is_int($szieOfFeld)))||($sizeOfField>10)||($sizeOfField<3)){
                        $redirect_page = $_SERVER["HTTP_HOST"];
                        echo $redirect_page.'<br>';
                        header('Location: '.$redirect_page.'/..');
                }
        }else{
            $redirect_page = $_SERVER['HTTP_HOST'];
            echo $redirect_page.'<br>';
            header('Location: '.$redirect_page.'/..');
        }
        if (isset($_POST['time'])){
            $game_time = $_POST['time'];
            if ((!(is_int($game_time)))||($game_time>60)||($game_time<0)){
            $game_time = $_POST['time'];
        }else{
            $game_time = 15;
        }
        $game_end = false;
        while (!$game_end){
                $game_end = true;
                //$turn = $player1->get_turn();
                switch (turn){
                        case 0:
                                //hodit vtoroi
                                break;
                        case 1;
                                //hodit pervy
                                break;
                }
        }
        echo 'refresh';
        while ($size>0){
                //exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
                $size--;
        }
        ob_end_flush();
    ?> 
    </body>
</html>


