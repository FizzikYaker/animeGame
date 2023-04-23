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
            echo "Успешная регистрация!";
        } else {
            echo "Ошибка: " . implode(", ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
