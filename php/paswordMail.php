<?php
// Подключаем к БД
require_once 'mySQLi_connection.php';
require_once 'testMail.php';
// Проверяем нажата ли кнопка отправки формы
if (isset($_POST['submit'])) {
    if ($_POST['email']) {
        // Получаем данные из формы
        $login = $_POST['login'];
        $email = $_POST['email'];
        try {
            $stmt = $pdo->prepare("SELECT id, login, email, email_chek  FROM user WHERE login = :login");
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            // Если пользователь найден в базе данных
            if ($stmt->rowCount() > 0) {
                // Получаем данные пользователя из результата запроса
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Проверяем, соответствует ли введенный пароль хешированному паролю из базы данных
                if ($email == $user['email']) {
                    if ($user['email_chek'] == 1) {
                        $id = $user['id'];
                        // хешируем хеш, который состоит из email и времени
                        $hash = md5($email . time());

                        // Переменная $headers нужна для Email заголовка   
                        $subject = '=?utf-8?b?' . base64_encode("Подтвердите Email на сайте") . '?=';
                        // Сообщение для Email
                        $message = '
                                <html>
                                <head>
                                <title>Подтвердите Email</title>
                                </head>
                                <body>
                                <p>Что бы восстановить пароль перейдите по <a href="http://animegame/php/recoveryPasword.php?hash=' . $hash . '">ссылка</a></p>
                                </body>
                                </html>
                                ';

                        // Добавление пользователя в БД
                        $stmt = $pdo->prepare("INSERT INTO email_confirm (id, hash) VALUES (:id, :hash)");
                        $stmt->bindParam(':id', $id);
                        $stmt->bindParam(':hash', $hash);
                        if ($stmt->execute()) {
                            // проверяет отправилась ли почта
                            mailFunc($email, $message, $subject);
                        } else {
                            echo "бд ебанулось";
                        }
                    } else {
                        echo "У вас даже почта не подтверждена";
                    }
                } else {
                    echo "Нет пользователя с такой почтой";
                }
            } else {
                echo "Нет пользователя с таким логином";
            }
        } catch (PDOException $e) {
            // Выводим сообщение об ошибке, если возникла проблема с выполнением запроса
            echo "Ошибка: " . $e->getMessage();
        }
    } else {
        // Если ошибка есть, то выводить её 
        echo "Вы не ввели Email";
    }
} else {
    echo "кнопка отправки не нажата";
}
