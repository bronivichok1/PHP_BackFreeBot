<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Product
include_once "../config/database.php";
include_once "../objects/video.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$video = new Video($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим id свойства товара для редактирования
$video->id = $data->id;

// установим значения свойств товара
$video->video = $data->video;
$video->id = $data->id;
$video->login_id = $data->login_id;

// обновление товара
if ($video->update()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Видео было заменено"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить товар, сообщим пользователю
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно заменить видео"), JSON_UNESCAPED_UNICODE);
}