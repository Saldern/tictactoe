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
		
		<?php
			$host='localhost';
			$database='tictactoe';
			$user='root';
			$pswd='';
			 
			$dbh = mysql_connect($host, $user, $pswd) or die("Не удалось подключиться к MySQL.");
			mysql_select_db($database) or die("Не удалось подключиться к БД");
			
			$query = "SELECT * FROM gamefield";
			$res = mysql_query($query);
			if (!$res) {
				echo 'Ошибка запроса: ' . mysql_error();
				exit;
			}
			echo "<table width='50%' border='1'>";
			echo "<tr>
						<td width='80%'>Название</td>
						<td width='20%'>Число игроков</td>
					</tr>";
			while($row = mysql_fetch_array($res)){
				$pole1=$row['key'];
				$pole2=$row['key'];
				echo "<tr>
						<td>$pole1</td>
						<td>$pole2 / 2</td>
					</tr>";
			}
			echo "</table>";
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
