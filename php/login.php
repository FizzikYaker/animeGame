<?php
// Запускаем сессию, чтобы сохранить данные пользователя после успешного входа
session_start();

// Подключаем файл с настройками подключения к базе данных
require_once 'mySQLi_connection.php';

// Проверяем, была ли отправлена форма входа
if (isset($_POST['submit'])) {
    // Получаем данные из формы
    $login = $_POST['login'];
    $password = $_POST['password'];

    try {
        // Создаем подготовленный запрос для поиска пользователя по логину
        $stmt = $pdo->prepare("SELECT password, id, login  FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        // Если пользователь найден в базе данных
        if ($stmt->rowCount() > 0) {
            // Получаем данные пользователя из результата запроса
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Проверяем, соответствует ли введенный пароль хешированному паролю из базы данных
            if (password_verify($password, $user['password'])) {
                // Сохраняем ID и логин пользователя в сессии
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_login'] = $user['login'];

                // Перенаправляем пользователя на главную страницу или его профиль
                header('Location: /index.html');
            } else {
                // Если пароль неверный, выводим сообщение об ошибке
                echo "Неверный пароль!";
            }
        } else {
            // Если пользователь с введенным логином не найден, выводим сообщение об ошибке
            echo "Пользователь с таким логином не найден!";
        }
    } catch (PDOException $e) {
        // Выводим сообщение об ошибке, если возникла проблема с выполнением запроса
        echo "Ошибка: " . $e->getMessage();
    }
}
