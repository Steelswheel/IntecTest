<?php
/** Скрипт для обработки загруженного файла*/

header("Refresh: 4; url=$_SERVER[HTTP_REFERER]");
session_start();
require 'classes/reader.php';
error_reporting(0);//Здесь для отключения ошибок, выводимых при отсутствии файла

$reader = new Reader();
$reader->downloadFile();//Грузим файл из формы в папку
$reader->readFile();//Читаем файл
$reader->getData();//Приводим данные в нужный формат
$reader->pushData();//Добавляем/обновляем информацию в БД
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Download File</title>
</head>
<body>
    <div class="alert"><?echo $reader->alert;?></div>
</body>
</html>