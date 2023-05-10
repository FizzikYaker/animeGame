<?php


namespace MyApp;


require_once 'pRedis_connection.php';
require_once 'mySQLi_connection.php';

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

const allCard = [
    [], //это оставить пустым оно нулевое
    [10, 2, 3], // карта[хп, мана, дамаг]
    [10, 4, 5],
    [5, 1, 2],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3],
    [10, 2, 3]
];


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
        //$this->redis->flushAll();
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
                    var_dump($this->redis->hMSet($this->waitingPlayer->resourceId, [$userCard['deek'],  $user_login,  $user_id])); //сохраняем все о юзере в редис

                } else {
                    $this->games[$conn->resourceId] = $this->waitingPlayer; // два игрока в одной каморке
                    $this->redis->set('test_key', 'Hello, Predisas!');

                    $this->games[$this->waitingPlayer->resourceId] = $conn; // тот кто до этого сидел
                    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! возможно пользователей местами попутал
                    // создаем комнату в редисе ид по одному из игроков
                    $data = $this->startRedis($this->waitingPlayer->resourceId,  $this->waitingPlayer->resourceId, [json_decode($userCard['deek']),  $user_login,  $user_id]);
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
        var_dump("данные", $data);
        $redisData = 0;
        $redisKey = -1;
        // здесь распокавать нужный редис
        if ($this->redis->exists($from->resourceId) == 1) {
            $redisData = json_decode($this->redis->get($from->resourceId));
            $redisKey = $from->resourceId;
            var_dump("редис", $redisData);
        } else {
            $redisData = json_decode($this->redis->get($this->games[$from->resourceId]->resourceId), true);
            $redisKey = $this->games[$from->resourceId]->resourceId;
            var_dump("редис", $redisData);
        }
        $turn = 0;
        if ($turn == 0) {
            $redisData['turn'] = 1; // меняем ход
            foreach ($data as $key => $value) {
                if ($value != 0) {
                    $redisData['user_1'][1] =  $redisData['user_1'][1] - allCard[$value][1]; //снимаем ману !!!!!!! проверка на отрицательное
                    $redisData['field_1'][$key] = [$value, allCard[$value][0], allCard[$value][1], allCard[$value][2]]; // тут проверить куда поставить
                }
            }
            $this->games[$from->resourceId]->send(json_encode(['type' => 'enemy_atak', 'enemy_mana' =>  $redisData['user_1'][1], 'card' =>  $data])); // отпраляем второрму
        } elseif ($turn == 1) {
            $redisData['turn'] = 2;
            // снимаем ману
            // подсчет урона по картам или игроку
            // проверка выживших карт и самого игрока
            // меняем ход на 2
            // отправляем ид сдохших карт ид и здоровье выживших карт, здоровье игроков и их ману, добавляем юзерам карты из колоды
            // запись карт в редис
        } elseif ($turn == 2) {
            $redisData['turn'] = 3;
            foreach ($data as $key => $value) {
                if ($value != 0) {
                    $redisData['user_2'][1] = $redisData['user_2'][1] - allCard[$value][1]; //снимаем ману !!!!!!! проверка на отрицательное
                    $redisData['field_2'][$key] = [$value, allCard[$value][0], allCard[$value][1], allCard[$value][2]]; // тут проверить куда поставить
                }
            }
            $this->games[$from->resourceId]->send(json_encode(['type' => 'enemy_atak', 'enemy_mana' => $redisData['user_2'][1], 'card' =>  $data]));
        } else {
            $redisData['turn'] = 0;
            // снимаем ману
            // подсчет урона по картам или игроку
            // проверка выживших карт и самого игрока
            // меняем ход на 0
            // отправляем ид сдохших карт ид и здоровье выживших карт, здоровье игроков и их ману, добавляем юзерам карты из колоды
            // запись карт в редис
        }
        var_dump($redisData);
        $this->redis->set($redisKey, json_encode($redisData)); // сохраняем изменения в редис



        // $opponent = $this->games[$from->resourceId]; // ищет оппонента, кому отправить враг(опонент)
        // //$from->send(json_encode($data)); ид того кто отправил меседж
        // if ($opponent) {  // если оппонент найден 
        //     $opponent->send(json_encode($data));
        //     if ($data->type === 'restart') {
        //         $this->waitingPlayer = $opponent;
        //     }
        // }
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
            'turn' => 0, // кто ходит 0-первый атакует, 1-второй зашита, 2-второй атакует, 3-первый зашита и опять 0
            'hand_1' => [allCard[$arr1[0]], allCard[$arr1[1]], allCard[$arr1[2]], allCard[$arr1[3]]], // карты на руке ид, хп, мана, дмг[1, 10, 2, 5]
            'hand_2' => [allCard[$arr2[0]], allCard[$arr2[1]], allCard[$arr2[2]], allCard[$arr2[3]]],
            'deek_1' => $arr1, //вся стопка карт у игрока
            'deek_2' => $arr2,
            'field_1' => [], // ид, хп, мана, дмг[1, 10, 2, 5], [0]если пусто
            'field_2' => []
        ]));

        //var_dump($this->redis->get($id));
        return [[$arr1[0], $arr1[1], $arr1[2], $arr1[3]], [$arr2[0], $arr2[1], $arr2[2], $arr2[3]], $user_1[1], $user_2[1]];
    } // возвращяем идишники ПЕРВЫХ карт и логины пользователей
}
/*
Написать функции для обработки логики игры 
Написать проверку для обработки правильности хода
Улучшить поиск игроков
Перенести частичную логику игры из client.js
Написать проверку через redis
*/