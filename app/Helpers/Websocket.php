<?php
namespace App\Helpers;

use App\Models\Device;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Websocket implements MessageComponentInterface {
    protected $clients;

    private $devices = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);
        if ($data && isset($data->action) && $data->action === 'change') {
            $isActive = Device::where('id', $data->id)->get('is_active')->first()->is_active;
            Device::where('id', $data->id)->update(['is_active' => $isActive ? 0 : 1]);
        } elseif ($data && isset($data->action) && $data->action === 'delete') {
            Device::where('id', $data->id)->delete();
        } elseif ($data) {
            Device::insert([
                'name' => $data->name,
                'type' => $data->type,
                'description' => $data->description,
                'is_active' => $data->isActive,
            ]);
        }

        $devices = Device::all();

        foreach ($this->clients as $client) {
            $client->send(json_encode($devices));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
