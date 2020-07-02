<?php
/** Класс для отслеживания авторизации */

require 'dbconnect.php';

class Authorizer extends DbConnect
{

    function __construct($server = "localhost", $user = "root", $password = "", $db = "test", $table = "users")
    {
        parent::__construct($server, $user, $password, $db, $table);
    }

    public function auth()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {//Если данные из формы авторизации отправлены
            $id = htmlentities(trim($_POST['user_id']));//Небольшая проверка данных
            $pass = htmlentities(trim($_POST['pass']));

            if (isset($_SESSION['user_id'])) {//Если пользователь авторизован, редирект на главную
                echo "<meta http-equiv=\"refresh\" content=\"0;URL=/index.php\">";
            }

            if (!empty($id) && !empty($pass)) {

                $mysqli = new mysqli($this->server, $this->user, $this->password, $this->db) or die('Ошибка соединения с БД');//Соединяемся с БД

                //Проверить соединение
                if ($mysqli->connect_errno) {
                    printf("Попытка соединения не удалась: %s\n", $mysqli->connect_error);
                    exit();
                }

                $query = "SELECT user_id, pass FROM $this->table WHERE user_id = ?";
                $stmt = $mysqli->prepare($query);
                if(!$stmt ) { //если ошибка - убиваем процесс и выводим сообщение об ошибке.
                    die($mysqli->error);
                }
                $stmt->bind_param('i', $id);//Проверяем по id
                $stmt->execute();
                $stmt->bind_result($i, $p);
                if ($stmt->fetch()) {
                    if ($i == $id && $p == $pass) {
                        $_SESSION['user_id'] = $id;
                        $this->alert = "Успешная авторизация!";
                        echo "<meta http-equiv=\"refresh\" content=\"2;URL=/index.php\">";
                    } else {
                        $this->alert = "Данные не верны";
                    }
                    $stmt->close();
                    $mysqli->close();
                }
            } else {
                $this->alert = "Введите корректные данные";
            }
        }
    }

    public function control()//Функция контроля авторизации
    {
        if (!isset($_SESSION['user_id'])) {
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=/auth.php\">";
        }
    }

    public function exit()//Кнопка "Выход"
    {
        if (isset($_GET['do']) && $_GET['do'] == 'exit') {
            unset($_SESSION['user_id']);
            session_destroy();
            $this->control();
        }
    }
}
?>