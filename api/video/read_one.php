<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once "../config/database.php";
include_once "../objects/video.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$video = new Video($db);

// установим свойство ID записи для чтения
$video->id = isset($_GET["id"]) ? $_GET["id"] : die();

// получим детали товара
$video->readOne();

if ($video->video != null) {

    // создание массива
    $videos_arr = array(
        "id" =>  $video->id,
        "video" => $video->video,
        "login_id" => $video->login_id,
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($videos_arr);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой товар не существует
    echo json_encode(array("message" => "Записи не существует"), JSON_UNESCAPED_UNICODE);
}
