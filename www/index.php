<?php ob_start(); ?>
<html>
    <head>
        <title>Tic-Tac-Toe</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
		<h1> Tic-Tac-Toe </h1>
		<p> Game creation:</p>
		<?php 
		$correct = true;
		if (isset($_GET['sizeOfField'])){
                $sizeOfField = $_GET['sizeOfField'];
                $sizeOfField += 0;
                if (!(is_int($sizeOfField))){
                    echo 'Error. Size not int. ';
					$correct = false;
                }
                if ($sizeOfField>10){
                    echo 'Error. Size > 10. ';
					$correct = false;
                }
                if ($sizeOfField<3){
                    echo 'Error. Size < 3. ';
					$correct = false;
                }
        }else{
            echo 'Error. Size not set. ';
			$correct = false;
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
		if ($correct){
			header("Location: game.php?sizeOfField=".$sizeOfField."&time=".$game_time);
		}
		ob_end_flush();
		?>
		<ul>
			<form action="index.php" method="get"> 
				<li> Size of field(3-10): </li>
				<input name="sizeOfField" type="text" value="3">
				<li> Turn time(sec:5-60): </li>
				<input name="time" type="text" value="15"></br>
				<input value="Start game" type="submit">
			</form>
		</ul>		
		<p> 
			Your link to the game: <a href=game.php>TEST</a>
		</p>
		<p> 
			Damn right </br>: <img src="images/stalin.jpg" alt="pravilno blyat'"/>
		</p>
		<p> 
			<img src="images/tree.jpg" width="1024" alt="a tree"/>
		</p>
	</body>
</html>
