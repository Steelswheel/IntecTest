<?php
session_start();
require 'scripts/authorization.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Intec test</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<form enctype="multipart/form-data" class="download" method="post" action="scripts/download.php">
			<fieldset>
				<legend>Загрузка CSV-файла</legend>
				<input type="file" name="inputfile" placeholder="Файл...">
				<button type="submit" name="button" class="button">Импорт</button>
			</fieldset>
		</form>
		<a class="button" href="<?php echo $_SERVER['PHP_SELF'] . '?do=exit'?>">Выйти</a>
	</body>
</html>