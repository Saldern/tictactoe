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
		if ($correct){
			header("Location: game.php?sizeOfField=".$sizeOfField);
		}
		ob_end_flush();
		?>
		<ul>
			<form action="index.php" method="get"> 
				<li> Size of field(3-10): </li>
				<input name="sizeOfField" type="text" value="3">
				<input value="Start game" type="submit">
			</form>
		</ul>		
		<p> 
			If you already created game, use this link: <a href=game.php>THE GAME</a>
		</p>
	</body>
</html>
