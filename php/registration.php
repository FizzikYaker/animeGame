<?php
// Подключаем файл config.php, который содержит настройки подключения к базе данных
require_once 'mySQLi_connection.php';

// Проверяем, была ли отправлена форма регистрации
if (isset($_POST['register'])) {
    // Получаем данные из формы
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Хешируем пароль пользователя с использованием алгоритма bcrypt (PASSWORD_DEFAULT)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Создаем подготовленный запрос для вставки нового пользователя в таблицу user
    try {
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
                echo "Успешная регистрация!";
            }
        } else {
            echo "Ошибка: " . implode(", ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
