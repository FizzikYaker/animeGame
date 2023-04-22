<?php


namespace MyApp;

require_once 'pRedis_connection.php';

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;



class Game implements MessageComponentInterface
{

    protected $clients;
    protected $waitingPlayer;
    protected $games;
    protected $redis;

    public function __construct()
    {
        global $redisConnection;
        $this->clients = new \SplObjectStorage;
        $this->waitingPlayer = null;
        $this->games = [];
        $this->redis = $redisConnection;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        if (!$this->waitingPlayer) { // Если комната не найдена
            $this->waitingPlayer = $conn;
            echo "1";
        } else {
            $this->games[$conn->resourceId] = $this->waitingPlayer; // два игрока в одной каморке
            $this->redis->set('test_key', 'Hello, Predisas!');
            $this->games[$this->waitingPlayer->resourceId] = $conn;

            $this->waitingPlayer->send(json_encode(['type' => 'start', 'symbol' => 'X']));
            $conn->send(json_encode(['type' => 'start', 'symbol' => 'O']));

            $this->waitingPlayer = null;
            echo "0";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);
        $opponent = $this->games[$from->resourceId]; // ищет оппонента, кому отправить

        if ($opponent) {  // если оппонент найден 
            $opponent->send(json_encode($data));
            if ($data->type === 'restart') {
                $this->waitingPlayer = $opponent;
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        if ($this->waitingPlayer === $conn) {
            $this->waitingPlayer = null;
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    public function chekPlay($msg)
    {
        $data = json_decode($msg);
    }
}
/*
Написать функции для обработки логики игры 
Написать проверку для обработки правильности хода
Улучшить поиск игроков
Перенести частичную логику игры из client.js
Написать проверку через redis
*/