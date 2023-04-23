<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once 'game.php';
require_once 'player.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Game;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Game()
        )
    ),
    7070
);

$server->run();
