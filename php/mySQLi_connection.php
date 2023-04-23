<?php
// Настройки подключения к базе данных
$host = '127.0.0.1'; // Адрес сервера базы данных
$db   = 'anime_game'; // Название базы данных
$user = 'roo'; // Имя пользователя базы данных
$pass = ''; // Пароль пользователя базы данных
$charset = 'utf8mb4'; // Кодировка 

// Формируем строку подключения с использованием настроек
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Настройки для объекта PDO
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Режим сообщений об ошибках
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Режим извлечения данных по умолчанию
    PDO::ATTR_EMULATE_PREPARES   => false, // Отключаем эмуляцию подготовленных запросов
];

// Создаем объект PDO с подключением к базе данных
try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
    // Если возникла ошибка при подключении, выводим сообщение об ошибке и завершаем работу скрипта
    die("Ошибка подключения: " . $e->getMessage());
}

//https://phpfaq.ru/pdo полезная ссылочка