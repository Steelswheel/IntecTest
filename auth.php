<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Authorization to Intec Test</title>
</head>
<body>
    <form action="scripts/check.php" method="post">
        <div><label for="user_id">Введите Ваш id:</label></div>
        <input name="user_id" class="input">
        <div><label for="pass">Введите Ваш пароль:</label></div>
        <input name="pass" class="input">
        <button class="button">Авторизация</button>
    </form>
</body>
</html>