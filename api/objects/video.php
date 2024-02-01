<?php

class Video

{
    // подключение к базе данных и таблице "products"
    private $conn;
    private $table_name = "tableforvideo";

    // свойства объекта
    public $id;
    public $login_id;
    public $video;


    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // здесь будет метод read()
    function read()
{
    // выбираем все записи
    $query = "SELECT 
         t.id, t.login_id, t.video
    FROM
        " . $this->table_name . " t
        LEFT JOIN
            auth a
                ON t.login_id = a.login
    ORDER BY
        t.login_id DESC";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
}
// метод для создания товаров
function create()
{
    // запрос для вставки (создания) записей
    $query = "INSERT INTO
            " . $this->table_name . "
        SET
            id=:id, login_id=:login_id, video=:video";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->login_id = htmlspecialchars(strip_tags($this->login_id));
    $this->video = htmlspecialchars(strip_tags($this->video));


    // привязка значений
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":login_id", $this->login_id);
    $stmt->bindParam(":video", $this->video);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}
function readOne()
{
    // запрос для чтения одной записи (товара)
    $query = "SELECT 
         t.id, t.login_id, t.video
    FROM
        " . $this->table_name . " t
             LEFT JOIN
             auth a
                 ON t.login_id = a.login
        WHERE
            t.id = ?
        LIMIT
            0,1";
            
    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // привязываем id товара, который будет получен
    $stmt->bindParam(1, $this->id);

    // выполняем запрос
    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // установим значения свойств объекта
    $this->id = $row["id"];
    $this->video = $row["video"];
    $this->login_id = $row["login_id"];

}
// метод для обновления товара
function update()
{
    // запрос для обновления записи (товара)
    $query = "UPDATE
            " . $this->table_name . "
        SET
            video = :video
            login_id=:login_id
       WHERE
            id = :id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->video = htmlspecialchars(strip_tags($this->video));
    $this->login_id = htmlspecialchars(strip_tags($this->login_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // привязываем значения
    $stmt->bindParam(":video", $this->video);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":login_id", $this->login_id);
 

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}
}
