<?php
require 'classes/authorizer.php';
$authorizer = new Authorizer();
$authorizer->auth();
$authorizer->control();
$authorizer->exit();
?>