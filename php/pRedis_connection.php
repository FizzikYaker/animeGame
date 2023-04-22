<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Predis\Client;

// Подключение к Redis
function createRedisConnection()
{
    try {
        $redis = new Client([
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
        ]);
        return $redis;
    } catch (Exception $error) {
        echo ("Ошибка подключения к pRedis: " . $error->getMessage() . "\n");
        return null;
    }
}

// Создайте глобальную переменную и установите соединение

$GLOBALS['redisConnection'] = createRedisConnection();