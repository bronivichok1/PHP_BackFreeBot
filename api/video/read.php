<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение к базе данных будет здесь
// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/video.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$video = new Video($db);
 
// чтение товаров будет здесь
// запрашиваем товары
$stmt = $video->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $videos_arr = array();
    $videos_arr["records"] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $video_item = array(
            "id" => $id,
            "login_id" => $login_id,
            "video"=>$video
        );
        array_push($videos_arr["records"], $video_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($videos_arr);
}
    
else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}