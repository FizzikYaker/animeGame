<?php
// Подключаем файл config.php, который содержит настройки подключения к базе данных
require_once 'mySQLi_connection.php';
require_once 'testMail.php';
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
                        $deekStart = json_encode([12, 6, 8, 9]);
                        $allCardStart = json_encode([12, 6, 8, 9]);

                        $stmt = $pdo->prepare("INSERT INTO cardUser (id, deek, all_card) VALUES (:id, :deek, :all_card)");
                        $stmt->bindParam(':id', $id);
                        $stmt->bindParam(':deek', $deekStart);
                        $stmt->bindParam(':all_card', $allCardStart);
                        $stmt->execute();

                        $hash = md5($login . time());

                        // Переменная $headers нужна для Email заголовка   
                        $subject = '=?utf-8?b?' . base64_encode("Подтвердите Email на сайте") . '?=';
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
                            mailFunc($email, $message, $subject);
                        } else {
                            echo "бд ебанулось";
                        }
                    } else {
                        echo "Ошибка: " . implode(", ", $stmt->errorInfo());
                    }
                } else {
                    echo "бд ебанулось";
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
