<?php namespace App\Libraries;
use App\Models\ChatRoom;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $chatRoom;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->chatRoom = new ChatRoom();
    }

    public function onOpen(ConnectionInterface $conn) {
        // User details
//        $studentModel = new StudentModel();
//        $student = $studentModel->find(4);
//        $conn->user = $student;
//        $conn->Session->get(4);

        //Store data into database
        // ws://localhost:8081?class_id=2&&grp_id=2
        $uriQuery = $conn->httpRequest->getUri()->getQuery(); //class_id=2&grp_id=2
        $classGroupArray = explode('&', $uriQuery); //$classGroupArray return class_id=2 and grp_id=2
        $classArray = explode('=', $classGroupArray[0]); //$classArray[1]
        $groupArray = explode('=', $classGroupArray[1]); //$groupArray[1]
        $stdArray = explode('=', $classGroupArray[2]); //$stdArray[1]

        $data = array(
            'resource_id' => $conn->resourceId,
            'class_id' => $classArray[1],
            'std_id' => empty($stdArray[1]) ? null : $stdArray[1],
//            'value' => json_encode($classGroupArray[0]),
            'group_id' => empty($groupArray[1]) ? null : $groupArray[1],
        );
        $this->chatRoom->insert($data);

        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        //$msg = json_encode($this->clients);
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $fromBuilder = DB()->table('chat_room');
                $fromBuilder->where('resource_id', $from->resourceId);
                $from_info = $fromBuilder->get()->getRow();

                $clientBuilder = DB()->table('chat_room');
                $clientBuilder->where('resource_id', $client->resourceId);
                $client_info = $clientBuilder->get()->getRow();

//                $lastQuery = DB()->getLastQuery();
                //$from_info = $this->chatRoom->where('resource_id', $from->resourceId)->findAll();
                //$client_info = $this->chatRoom->where('resource_id', $client->resourceId)->findAll();
                if (($from_info->class_id == $client_info->class_id) && ($from_info->group_id == $client_info->group_id)) {
                    // The sender is not the receiver, send to each client connected
                    $client->send("Client $from->resourceId said $msg");
                }
//                $client->send($msg);
//                $client->send("Client $from->resourceId to $client->resourceId And Last Query is : $lastQuery");
//                $client->send("Client $from->resourceId to $client->resourceId And fromclassid $from_info->class_id And fromgroupid $from_info->group_id");
//                $client->send("Client $from->resourceId to $client->resourceId And clientclassid $client_info->class_id And clientgroupid $client_info->group_id");
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove data from chat_room table
        $this->chatRoom->where('resource_id', $conn->resourceId)->delete();

        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}