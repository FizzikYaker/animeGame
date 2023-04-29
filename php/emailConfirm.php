<?php
require_once 'mySQLi_connection.php';

// Проверка есть ли хеш
if ($_GET['hash']) {
    $hash = $_GET['hash'];
    // Получаем id и подтверждено ли Email
    try {
        // Создаем подготовленный запрос для поиска пользователя по логину
        $stmt = $pdo->prepare("SELECT id FROM email_confirm WHERE hash=:hash");
        $stmt->bindParam(':hash', $hash);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $user['id'];

            $stmt = $pdo->prepare("UPDATE user SET email_chek=1 WHERE id=:id");
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                echo "Email подтверждён";
                $stmt = $pdo->prepare("DELETE FROM email_confirm WHERE id=:id");
                $stmt->bindParam(':id', $id);
                if ($stmt->execute()) {
                    header('Location: /index.html');
                } else {
                    echo "бд ебнулось";
                }
            } else {
                echo "бд ебнулось";
            }
        } else {
            echo "Нет такого хеша";
        }
    } catch (PDOException $e) {
        // Выводим сообщение об ошибке, если возникла проблема с выполнением запроса
        echo "Ошибка: " . $e->getMessage();
    }
} else {
    echo "хеша нет";
}
