<?php
/** Скрипт для контроля авторизации */
require 'classes/authorizer.php';
$authorizer = new Authorizer();
$authorizer->auth();//Выполняется при авторизации пользователя - проверка id и пароля
$authorizer->control();//Контроль авторизации
$authorizer->exit();//Выход, уничтожение сессии
?>