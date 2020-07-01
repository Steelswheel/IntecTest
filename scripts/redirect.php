<?php
//header("Refresh: 2; url=$_SERVER[HTTP_REFERER]");
session_start();
require 'classes/reader.php';

$reader = new Reader();
$reader->downloadFile();
$reader->readFile();
$reader->getData();
$reader->pushData();
?>