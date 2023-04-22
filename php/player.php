<?php

namespace MyApp;

class Player
{
    private $connection;
    private $hand;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->hand = [];
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getHand()
    {
        return $this->hand;
    }

    public function setHand($hand)
    {
        $this->hand = $hand;
    }

    // Дополнительные методы для работы с игроками
}
