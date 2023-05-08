<?php


namespace MyApp;


require_once 'pRedis_connection.php';
require_once 'mySQLi_connection.php';

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
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $params);

        if (isset($params['user_id'], $params['login'])) {
            $user_id = $params['user_id'];
            $user_login = $params['login'];
            //var_dump($params);
            global $pdo;
            $stmt = $pdo->prepare("SELECT deek  FROM cardUser WHERE id = :id");
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $userCard = $stmt->fetch();


                $this->clients->attach($conn);
                if (!$this->waitingPlayer) { // Если комната не найдена
                    $this->waitingPlayer = $conn;

                    $this->redis->hMSet($conn->resourceId, [$userCard['deek'],  $user_login,  $user_id]); //сохраняем все о юзере в редис
                    echo "1";
                } else {
                    $this->games[$conn->resourceId] = $this->waitingPlayer; // два игрока в одной каморке
                    $this->redis->set('test_key', 'Hello, Predisas!');

                    $this->games[$this->waitingPlayer->resourceId] = $conn; // тот кто до этого сидел
                    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! возможно пользователей местами попутал
                    // создаем комнату в редисе ид по одному из игроков
                    $data = $this->startRedis($this->waitingPlayer->resourceId,  $this->waitingPlayer->resourceId, [json_decode($userCard['deek']),  $user_login,  $user_id]);
                    var_dump($data);
                    //отправить стартовые данные
                    $this->waitingPlayer->send(json_encode(['type' => 'start', 'oponent_login' => $data[3], 'hand' => $data[1]]));
                    $conn->send(json_encode(['type' => 'start', 'oponent_login' => $data[2], 'hand' => $data[0]]));


                    //$this->waitingPlayer->send(json_encode(['type' => 'start', 'symbol' => 'X']));
                    //$conn->send(json_encode(['type' => 'start', 'symbol' => 'O']));

                    $this->waitingPlayer = null;
                    echo "0";
                }
            } else {
                echo "Ошибка нет пользователя с таким ид";
            }
        } else {
            echo "Ощибка ид или логин не получены";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);
        var_dump($data);
        // здесь вся логика игры
        $opponent = $this->games[$from->resourceId]; // ищет оппонента, кому отправить враг(опонент)
        //$from->send(json_encode($data)); ид того кто отправил меседж
        if ($opponent) {  // если оппонент найден 
            $opponent->send(json_encode($data));
            if ($data->type === 'restart') {
                $this->waitingPlayer = $opponent;
            }
        }
    }

    public function onClose(ConnectionInterface $conn) // убить редис комнаты
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


    public function startRedis($id, $user_id_1, $user_2)
    {
        $user_1 = $this->redis->hGetAll($user_id_1);
        $arr2 = $user_2[0];
        $arr1 = json_decode($user_1[0]);
        shuffle($arr1);
        shuffle($arr2); // перемешиваем масив


        $this->redis->set($id, json_encode([
            'user_1' => [20, 10, 3, $user_1[2]], //хп мана количество использованных карт с нуля и ид юзера
            'user_2' => [20, 10, 3, $user_2[2]],
            'turn' => 0, // кто ходит
            'hand_1' => [$arr1[0], $arr1[1], $arr1[2], $arr1[3]], // карты на руке их ид
            'hand_2' => [$arr2[0], $arr2[1], $arr2[2], $arr2[3]],
            'deek_1' => $arr1,
            'deek_2' => $arr2,
            'field_1' => [[0, 0, 0], [0, 0, 0], [0, 0, 0], [0, 0, 0], [0, 0, 0]], // хп ид дмг карт на поле если нет то по нулям
            'field_2' => [[0, 0, 0], [0, 0, 0], [0, 0, 0], [0, 0, 0], [0, 0, 0]]
        ]));

        //var_dump($this->redis->get($id));
        return [[$arr1[0], $arr1[1], $arr1[2], $arr1[3]], [$arr2[0], $arr2[1], $arr2[2], $arr2[3]], $user_1[1], $user_2[1]];
    }
}
/*
Написать функции для обработки логики игры 
Написать проверку для обработки правильности хода
Улучшить поиск игроков
Перенести частичную логику игры из client.js
Написать проверку через redis
*/