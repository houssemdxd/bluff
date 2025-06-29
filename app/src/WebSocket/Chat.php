<?php

namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    /** @var \SplObjectStorage */
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
        $this->log("New connection established: ({$conn->resourceId})");

        // Optional: Notify the client of a successful connection
        $conn->send(json_encode([
            'topic' => '/system',
            'data' => ['message' => 'Connection established']
        ]));
    }

    public function onMessage(ConnectionInterface $from, $msg): void
    {
        $this->log("Message received from client {$from->resourceId}: $msg");

        // Parse and validate the incoming message
        $message = json_decode($msg, true);

        if (!is_array($message) || !isset($message['topic']) || empty($message['topic'])) {
            $this->log("Invalid message format from client {$from->resourceId}");
            $from->send(json_encode([
                'topic' => '/error',
                'data' => ['message' => 'Invalid message format or missing topic']
            ]));
            return;
        }

        $topic = $message['topic'];
        $data = $message['data'] ?? null;

        // Broadcast the message to all other connected clients
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send(json_encode([
                    'topic' => $topic,
                    'data' => $data
                ]));
            }
        }

        $this->log("Broadcasted message on topic '{$topic}' from client {$from->resourceId}");
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->clients->detach($conn);
        $this->log("Connection {$conn->resourceId} has been closed");
    }

    public function onError(ConnectionInterface $conn, \Exception $e): void
    {
        $this->log("Error on connection {$conn->resourceId}: {$e->getMessage()}");
        $conn->close();
    }

    /**
     * Utility function to log messages to the console.
     *
     * @param string $message
     */
    private function log(string $message): void
    {
        echo "[" . date('Y-m-d H:i:s') . "] $message\n";
    }
}
