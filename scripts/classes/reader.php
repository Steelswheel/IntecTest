<?php
/** Класс для чтения CSV-файлов */
require 'dbconnect.php';

class Reader extends DbConnect
{
    protected $dir;//директория загруженного файла
    protected $fileData;//данные из файла
    protected $completeData;//данные из файла, преобразованные в ассоциативный массив
    protected $sid;//id пользователя из сессии
    protected $upd = 0;//счетчик обновлений
    protected $ins = 0;//счетчик добавлений

    function __construct($server = "localhost", $user = "root", $password = "", $db = "test", $table = "product", $dir = "csv")
    {
        parent::__construct($server, $user, $password, $db, $table);
        $this->dir = $dir;
        $this->sid = $_SESSION['user_id'];
    }

    public function downloadFile()//Функция для загрузки файла из формы в директорию
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
            if ($_FILES['inputfile']['error'] == 0 && $_FILES['inputfile']['type'] == 'application/vnd.ms-excel') {
                $destination_dir = '../' . $this->dir . '/' . $_FILES['inputfile']['name'];
                if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destination_dir)) {
                    $this->alert .= "Файл загружен!<br>";
                    return $this->filePath = $destination_dir;
                } else {
                    $this->alert = "Файл не загружен!<br>";
                }
            } else {
                switch ($_FILES['inputfile']['error']) {
                case UPLOAD_ERR_NO_FILE:
                    $this->alert = 'Файл не загружен!<br>';
                    break;
                default:
                    $this->alert = 'Что-то пошло не так<br>';
                }
            }
        }
    }
    
    public function readFile()//Функция чтения загруженного файла и получения из него информации
    {
        if (($handle = fopen($this->filePath, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    $this->fileData[] = $data[$c];
                }
            }
            fclose($handle);
        }
        return $this->fileData;
    }

    public function getData()//Преобразует данные в ассоциативный массив + форматирует данные
    {
        $this->completeData = [];
        if(!empty($this->fileData)) {
            for ($i = 1; $i < count($this->fileData); $i++) {
                $str = $this->fileData[$i];
                $arr = explode(";", $str);
                $assoc = [
                    'id' => '',
                    'name' => '',
                    'name_trans' => '',
                    'price' => '',
                    'small_text' => '',
                    'big_text' => '',
                    'user_id' => ''
                ];
                $assoc['id'] = $arr[0];
                $assoc['name'] = $arr[1];
                $assoc['name_trans'] = $arr[2];
                $assoc['price'] = $arr[3];
                $assoc['small_text'] = strip_tags($arr[4]);//Удаляем теги
                if(strlen($assoc['small_text']) > 30) {
                    $this->alert = 'Данные в small_text строки №' . $i . '  содержат более 30 символов<br>';//Доп.проверка на длину строки
                    $assoc['small_text'] = mb_substr($assoc['small_text'], 0, 30, 'UTF-8');
                }
                $assoc['big_text'] = $arr[5];
                if($assoc['small_text'] === "" || $assoc['small_text'] === null) {
                    $assoc['small_text'] = mb_substr(strip_tags($assoc['big_text']), 0, 30, 'UTF-8');
                }
                $assoc['user_id'] = $this->sid;
                array_push($this->completeData, $assoc);
            }
        }
        return $this->completeData;
    }

    public function pushData()//Функция для обновления/изменения данных в БД
    {
        if(!empty($this->fileData)) {
            $mysqli = new mysqli($this->server, $this->user, $this->password, $this->db) or die('Ошибка соединения с БД');
            //Проверить соединение
            if ($mysqli->connect_errno) {
                printf("Попытка соединения не удалась: %s\n", $mysqli->connect_error);
                exit();
            }
            
            foreach ($this->completeData as $key) {//Получаем данные из загруженного файла
                $id = (int) $key['id'];
                $name = $key['name'];
                $name_trans = $key['name_trans'];
                $price = (double) $key['price'];
                $small_text = $key['small_text'];
                $big_text = $key['big_text'];
                $user_id = (int) $key['user_id'];

                $query = "SELECT id, name FROM $this->table WHERE user_id = $this->sid AND id = ? AND name = ?";//Получаем все товары текущего пользователя по name и id
                $stmt = $mysqli->prepare($query);
                if(!$stmt ) { //если ошибка - убиваем процесс и выводим сообщение об ошибке.
                    die($mysqli->error);
                }
                $stmt->bind_param('is', $id, $name);
                $stmt->execute();
                $stmt->bind_result($i, $n);
                if ($stmt->fetch()) {
                    if ($i == $id && $n == $name) {//если id и имя товара совпали, то обновляем информацию о товаре
                        $stmt->close();
                        $query = "UPDATE $this->table SET name_trans = ?, price = ?, small_text = ?, big_text = ? WHERE id = ? AND name = ? AND user_id = $this->sid";
                        $stmt = $mysqli->prepare($query);
                        if(!$stmt ) {
                            die($mysqli->error);
                        }
                        $stmt->bind_param('sdssis', $name_trans, $price, $small_text, $big_text, $id, $name);
                        $stmt->execute();
                        $this->upd++;
                    }
                } else {//если id и имя товара не совпали, то добавляем новый товар
                    $stmt->close();
                    $query = "INSERT INTO $this->table VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $mysqli->prepare($query);
                    if(!$stmt ) {
                        die($mysqli->error);
                    }
                    $stmt->bind_param('issdssi', $id, $name, $name_trans, $price, $small_text, $big_text, $user_id);
                    $stmt->execute();
                    $this->ins++;
                }
            }
            $this->alert .= "Добавлено: $this->ins/обновлено: $this->upd";
            $this->ins = 0;
            $this->upd = 0;
            $stmt->close();
            $mysqli->close();
        }
    }
}
?>