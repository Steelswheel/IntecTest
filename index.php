<?php
session_start();
require 'scripts/authorization.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Intec test</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<form enctype="multipart/form-data" class="form" method="post" action="scripts/redirect.php">
			<fieldset>
				<div class="label"><label for="inputfile">Выберите файл:</label></div>
				<input type="file" name="inputfile" placeholder="Файл..." class="inputfile">
				<button type="submit" name="button" class="button">Импорт</button>
			</fieldset>
		</form>
		<div><a href="<?php echo $_SERVER['PHP_SELF'] . '?do=exit'?>">Выйти</a></div>
	</body>
</html>