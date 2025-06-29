<?php
// src/Command/WebSocketServerCommand.php
namespace App\Command;

use App\WebSocket\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\SocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebSocketServerCommand extends Command 
{
    protected static $defaultName = 'app:websocket-server';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting WebSocket server...');

        // Use 0.0.0.0 to listen on all interfaces
        $ipAddress = '0.0.0.0';
        $port = 1700;

        // Create an event loop
        $loop = LoopFactory::create();

        // Create a socket server with proper configuration
        $socket = new SocketServer(
            "tcp://{$ipAddress}:{$port}",
            [
                'tcp' => [
                    'so_reuseport' => true,
                    'backlog' => 100
                ]
            ],
            $loop
        );

        // Create the WebSocket server with your Chat handler
        $wsServer = new WsServer(new Chat());
        $wsServer->enableKeepAlive($loop); // Enable keep-alive

        $server = new IoServer(
            new HttpServer($wsServer),
            $socket,
            $loop
        );

        $output->writeln("WebSocket server running at ws://{$ipAddress}:{$port}");

        // Run the event loop
        $loop->run();

        return Command::SUCCESS;
    }
}