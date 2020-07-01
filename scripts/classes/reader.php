<?php
/** Класс для чтения CSV-файлов */
require 'dbconnect.php';

class Reader extends DbConnect
{
    protected $dir;
    protected $fileData;
    protected $completeData;

    function __construct($server = "localhost", $user = "root", $password = "", $db = "test", $table = "product", $dir = "csv")
    {
        parent::__construct($server, $user, $password, $db, $table);
        $this->dir = $dir;
        $this->sid = $_SESSION['user_id'];
    }

    public function downloadFile() 
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
            if ($_FILES['inputfile']['error'] == 0 && $_FILES['inputfile']['type'] == 'application/vnd.ms-excel') {
                $destination_dir = '../' . $this->dir . '/' . $_FILES['inputfile']['name'];
                if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destination_dir)) {
                    echo "Файл загружен!";
                    return $this->filePath = $destination_dir;
                } else {
                    echo "Файл не загружен!";
                }
            } else {
                switch ($_FILES['inputfile']['error']) {
                case UPLOAD_ERR_NO_FILE:
                    echo 'Файл не загружен!';
                    break;
                default:
                    echo 'Что-то пошло не так';
                }
            }
        }
    }
    
    public function readFile()
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

    public function getData()
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
                $assoc['small_text'] = htmlspecialchars_decode($arr[4]);
                if(strlen($assoc['small_text']) > 30) {
                    echo 'Строка small_text №' . $i . ' имеет более 30 символов';
                    $assoc['small_text'] = mb_substr($assoc['small_text'], 0, 30, 'UTF-8');
                }
                $assoc['big_text'] = addslashes($arr[5]);
                if($assoc['small_text'] === "" || $assoc['small_text'] === null) {
                    $assoc['small_text'] = mb_substr($assoc['big_text'], 0, 30, 'UTF-8');
                }
                $assoc['user_id'] = $this->sid;
                array_push($this->completeData, $assoc);
            }
        }
        return $this->completeData;
    }

    public function pushData()
    {
        if(!empty($this->fileData)) {
            $mysqli = new mysqli($this->server, $this->user, $this->password, $this->db) or die('Ошибка соединения с БД');
            /* Проверить соединение */
            if (mysqli_connect_errno()) {
                printf("Попытка соединения не удалась: %s\n", mysqli_connect_error());
                exit();
            }
            foreach ($this->completeData as $key) {
                $query = "INSERT INTO $this->table VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($query);
                if(!$stmt ) { //если ошибка - убиваем процесс и выводим сообщение об ошибке.
                    die($mysqli->error);
                }
                $stmt->bind_param('issdssi', $id, $name, $name_trans, $price, $small_text, $big_text, $user_id);
                $id = (int) $key['id'];
                $name = $key['name'];
                $name_trans = $key['name_trans'];
                $price = (double) $key['price'];
                $small_text = $key['small_text'];
                $big_text = $key['big_text'];
                $user_id = (int) $key['user_id'];
                $stmt->execute();
            }
            $stmt->close();
            $mysqli->close();
        }
    }
}
?>