<?php
require_once 'vendor/autoload.php';

use Predis\Client;
// Подключение к Redis
try {
    $redis = new Client([
        'scheme' => 'tcp',
        'host' => '127.0.0.1',
        'port' => 6379,
    ]);
} catch (Exception $error) {
    echo ("Ошибка подключения к pRedis: " . $error->getMessage() . "\n");
}
