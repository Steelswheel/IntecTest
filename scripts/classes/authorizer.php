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
        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
            $id = htmlentities(trim($_POST['user_id']));
            $pass = htmlentities(trim($_POST['pass']));

            if (isset($_SESSION['user_id'])) {
                echo "<meta http-equiv=\"refresh\" content=\"0;URL=/index.php\">";
            }

            if (!empty($id) && !empty($pass)) {

                $mysqli = new mysqli($this->server, $this->user, $this->password, $this->db) or die('Ошибка соединения с БД');

                /* Проверить соединение */
                if (mysqli_connect_errno()) {
                    printf("Попытка соединения не удалась: %s\n", mysqli_connect_error());
                    exit();
                }

                $query = "SELECT user_id, pass FROM $this->table WHERE user_id = ?";
                $stmt = $mysqli->prepare($query);
                if(!$stmt ) { //если ошибка - убиваем процесс и выводим сообщение об ошибке.
                    die($mysqli->error);
                }
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->bind_result($i, $p);
                if ($stmt->fetch()) {
                    if ($i == $id && $p == $pass) {
                        $_SESSION['user_id'] = $id;
                        echo $alert = "Успешная авторизация!";
                        echo "<meta http-equiv=\"refresh\" content=\"2;URL=/index.php\">";
                    } elseif ($i != $id && $p != $pass) {
                        echo $alert = "Данные не верны";
                        echo "<meta http-equiv=\"refresh\" content=\"1;URL=/auth.php\">";
                    }
                }
                $stmt->close();
                $mysqli->close();
            } else {
                echo $alert = "Введите данные для входа";
            }
        }
    }

    public function control()
    {
        if (!isset($_SESSION['user_id'])) {
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=/auth.php\">";
        }
    }

    public function exit()
    {
        if (isset($_GET['do']) && $_GET['do'] == 'exit') {
            echo "Вы не авторизованы!";
            unset($_SESSION['user_id']);
            session_destroy();
            $this->control();
        }
    }
}
?>