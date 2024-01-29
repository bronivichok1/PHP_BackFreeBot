<?php
$host='localhost';
$db = 'FreeBot';
$username = 'dbuser';
$password = 'admin';
  

# Создаем соединение с базой PostgreSQL с указанными выше параметрами
$dbconn = pg_connect("host=$host port=5432 dbname=$db user=$username password=$password");
 
if (!$dbconn) {
die('Could not connect');
}
else {
echo ("Connected to local DB");

# Сделаем запрос на получение списка созданных таблиц
$res = pg_query($dbconn, "select table_name, column_name from information_schema.columns where table_schema='public'");
if (!$res) {
    echo "Произошла ошибка.\n";

}
}
# Выведем список таблиц и столбцов в каждой таблице w

while ($row = pg_fetch_row($res)) {
    echo "tableName: $row[0] ColumnName: $row[1]";
    echo "<br />\n";
}
?>