<?php ob_start(); ?>
<html>
    <head>
        <title>Tic-Tac-Toe</title>
        <meta charset="Windows-1251">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
		<h1> Tic-Tac-Toe </h1>
		<?php 
		$correct = true;
		if (isset($_GET['sizeOfField'])){
                $sizeOfField = (int)$_GET['sizeOfField'];
                $title = $_GET['title'];
                if ($sizeOfField>10){
                    echo 'Error. Size > 10. ';
					$correct = false;
                }
                if ($sizeOfField<3){
                    echo 'Error. Size < 3. ';
					$correct = false;
                }
        }else{
			$correct = false;
        }
		if ($correct){
			header("Location: game.php?sizeOfField=".$sizeOfField."&currentPlayer=1&title=".$title);
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
						<td width='80%'>Name</td>
						<td width='20%'>Players number</td>
				 </tr>";
			while($row = mysql_fetch_array($res)){
				$pole1=$row['title'];
				$pole2=$row['playersNumber'];
				echo "
					<tr>
						<td>";
				if ($pole2 > 1) 
					echo $pole1;
				else 
				{
					echo "<a href=addPlayer.php?id=".$row['id'].">
								".$pole1."
							</a>";
				}
				echo	"</td>
						<td>".$pole2." / 2</td>
					</tr>
					";
			}
			echo "</table>";
		?>
		
		<p> Game creation:</p>
		<ul>
			<form action="index.php" method="get"> 
				<li> Size of field(3-10): </li>
				<input name="sizeOfField" type="text" value="3">
				<li> Title: </li>
				<input name="title" type="text" value="Title">
				<input value="Start game" type="submit">
			</form>
		</ul>		
	</body>
</html>
