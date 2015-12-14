<!DOCTYPE html>
<html>
    <head>
        <title>Tic-Tac-Toe</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
		<h1> Tic-Tac-Toe </h1>
		<p> Game creation:</p>
		<ul>
			<form action="game.php" method="post"> 
				<li> Size of field(3-10): <?php echo $size.'x'.$size;?></li>
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
