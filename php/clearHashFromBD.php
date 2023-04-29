<?php
// Подключаем коннект к БД
require_once 'mySQLi_connection.php';

// Проверка есть ли хеш
if ($_GET['hash'] and $_GET['hash'] == "WsECFKghvBk0jm6") {
    try {
        $stmt = $pdo->prepare("DELETE FROM user
        WHERE id IN( SELECT id FROM email_confirm WHERE `time` < now() - interval 86400 second) ");
        if ($stmt->execute()) {
            echo "таблица чистенькая";
        } else {
            echo "нечего чистить";
        }
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
} else {
    echo "Вас забанят суки ебанные";
}
