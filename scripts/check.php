<?php
session_start();
require 'authorization.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Check auth</title>
</head>
<body>
    <div class="alert">
        <?echo $authorizer->alert;?>
    </div>
</body>
</html>
