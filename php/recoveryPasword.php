<?php
// Подключаем коннект к БД
require_once 'mySQLi_connection.php';
require_once 'testMail.php';
// Проверка есть ли хеш
if ($_GET['hash']) {
    // Кладём этот хеш в отдельную переменную 
    $hash = $_GET['hash'];
    // Проверка на то, что есть пользователь с таки хешом
    try {
        $stmt = $pdo->prepare("SELECT id FROM email_confirm WHERE hash=:hash");
        $stmt->bindParam(':hash', $hash);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $user['id'];

            // Переменная для хранения символов 
            $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
            // Получаем длину строки
            $numChars = strlen($chars);
            // Переменная для пароля
            $pass = '';
            // Цикл для создания пароля
            for ($i = 0; $i < 10; $i++) {
                $pass .= substr($chars, rand(1, $numChars) - 1, 1);
            }
            $passDB = password_hash($pass, PASSWORD_DEFAULT);
            // Обновление пароля
            $stmt = $pdo->prepare("UPDATE user SET 	password=:pass WHERE id=:id");
            $stmt->bindParam(':pass', $passDB);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {

                $stmt = $pdo->prepare("SELECT email FROM user WHERE id=:id");
                $stmt->bindParam(':id', $id);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $email = $user['email'];
                        // Переменная $headers нужна для Email заголовка   
                        $subject = '=?utf-8?b?' . base64_encode("Подтвердите Email на сайте") . '?=';
                        // Сообщение для Email
                        $message = '
                         <html>
                         <head>
                         <title>Ваш новый пароль</title>
                         </head>
                         <body>
                         <p>Ваш новый пароль"' . $hass . '"</p>
                         </body>
                         </html>
                         ';
                        mailFunc($email, $message, $subject);
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
                    echo "бд ебнулось";
                }
            } else {
                echo "бд ебнулось";
            }
        } else {
            echo "нет такого хэша";
        }
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
} else {
    echo "Что то пошло не так хеш";
}
