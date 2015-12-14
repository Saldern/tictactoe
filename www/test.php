<html>
    <head>
        <meta charset="UTF-8">
        <title>Main page</title>
    </head>
    <body>
        <?php
            $size = $_POST["sizeOfField"];
			if ($size != 0){
				echo "Size of field:".$size."</br>";
			}
			echo 'refresh';
			while ($size>0){
				exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
				$size--;
			}
		?> 
    </body>
</html>


