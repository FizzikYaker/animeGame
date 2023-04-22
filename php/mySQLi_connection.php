<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "anime_game");
if ($mysqli->connect_error) {
    die("Ошибка: " . $mysqli->connect_error);
}
// $request = "INSERT INTO user (login, email, password ) VALUES ('Toom', 'eee@mail.ru', '55885')";
// if ($mysqli->query($request)) {
//     echo "Данные успешно добавлены";
// } else {
//     echo "Ошибка: " . $mysqli->error;
// }
//$mysqli->close();