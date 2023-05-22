<?php

namespace App\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\Chat;

class Server extends BaseController
{
    public function index()
    {
    if (!is_cli()) {
        die('You are at the wrong place!');
    }
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8081
        );

    $server->run();
    }
}
