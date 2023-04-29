<?php
// Подключаем файл config.php, который содержит настройки подключения к базе данных
require_once 'mySQLi_connection.php';

// Проверяем, была ли отправлена форма регистрации
if (isset($_POST['register'])) {
    // Получаем данные из формы
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        $stmt = $pdo->prepare("SELECT login FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {

            $stmt = $pdo->prepare("SELECT email FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                // Хешируем пароль пользователя с использованием алгоритма bcrypt (PASSWORD_DEFAULT)
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Создаем подготовленный запрос для вставки нового пользователя в таблицу user

                $stmt = $pdo->prepare("INSERT INTO user (login, email, password) VALUES (:login, :email, :password)");
                $stmt->bindParam(':login', $login);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);

                if ($stmt->execute()) {
                    $stmt = $pdo->prepare("SELECT id FROM user WHERE login = :login");
                    $stmt->bindParam(':login', $login);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $id = $user['id'];
                        $deekStart = "12";
                        $allCardStart = "123";

                        $stmt = $pdo->prepare("INSERT INTO cardUser (id, deek, all_card) VALUES (:id, :deek, :all_card)");
                        $stmt->bindParam(':id', $id);
                        $stmt->bindParam(':deek', $deekStart);
                        $stmt->bindParam(':all_card', $allCardStart);
                        $stmt->execute();

                        $hash = md5($login . time());

                        // Переменная $headers нужна для Email заголовка   
                        $subject = '=?utf-8?b?' . base64_encode("Подтвердите Email на сайте") . '?=';
                        $fromMail = 'community-webma@mail.ru';
                        $fromName = 'mail.ru';
                        $date = date(DATE_RFC2822);
                        $messageId = '<' . time() . '-' . md5($fromMail . $email) . '@' . $_SERVER['SERVER_NAME'] . '>';
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
                        $headers .= "From: " . $fromName . " <" . $fromMail . "> \r\n";
                        $headers .= "Date: " . $date . " \r\n";
                        $headers .= "Message-ID: " . $messageId . " \r\n";
                        // Сообщение для Email
                        $message = '
                                <html>
                                <head>
                                <title>Подтвердите Email</title>
                                </head>
                                <body>
                                <p>Что бы подтвердить Email, перейдите по <a href="http://animegame/php/emailConfirm.php?hash=' . $hash . '">ссылка</a></p>
                                </body>
                                </html>
                                ';

                        // Добавление пользователя в БД
                        $stmt = $pdo->prepare("INSERT INTO email_confirm (id, hash) VALUES (:id, :hash)");
                        $stmt->bindParam(':id', $id);
                        $stmt->bindParam(':hash', $hash);
                        if ($stmt->execute()) {
                            // проверяет отправилась ли почта
                            if (mail($email, $subject, $message, $headers)) {
                                // Если да, то выводит сообщение
                                echo 'Подтвердите на почте';
                                echo "Успешная регистрация!";
                            }
                        } else {
                            // Если ошибка есть, то выводить её 
                            echo "почта не отправлена";
                        }
                    } else {
                        echo "бд ебанулось";
                    }
                } else {
                    echo "Ошибка: " . implode(", ", $stmt->errorInfo());
                }
            } else {
                echo "Пользователь с такой почтой уже существует";
            }
        } else {
            echo "Пользователь с таким логином уже существует";
        }
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
