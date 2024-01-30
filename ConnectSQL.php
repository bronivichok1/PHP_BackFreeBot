<?php
header("Access-Control-Allow-Origin: *");
$host='localhost';
$db = 'FreeBot';
$username = 'dbuser';
$password = 'admin';
  

# Создаем соединение с базой PostgreSQL с указанными выше параметрами
$dbconn = pg_connect("host=$host port=5432 dbname=$db user=$username password=$password");
 

# Сделаем запрос на получение списка созданных таблиц
$res = pg_query($dbconn, "SELECT video from tableforvideo where login_id='admin'");
if (!$res) {
    echo "Произошла ошибка.\n";
}
# Выведем список таблиц и столбцов в каждой таблице w
while ($row = pg_fetch_row($res)) {

    echo "$row[0]".'RAZDEL';
}


?>