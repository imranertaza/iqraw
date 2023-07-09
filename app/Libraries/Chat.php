<?php namespace App\Libraries;
use App\Models\ChatRoomModel;
use App\Models\LiveChatHistoryModel;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $chatRoom;
    protected $liveChatHistory;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->chatRoom = new ChatRoomModel();
        $this->liveChatHistory = new LiveChatHistoryModel();
    }

    public function onOpen(ConnectionInterface $conn) {

        $uriQuery = $conn->httpRequest->getUri()->getQuery(); //live_id=2&std_id=2
        $dataToArray = explode('&', $uriQuery); //$dataToArray[0] = 'live_id=2',$dataToArray[1] = 'std_id=2'
        $liveArray = explode('=', $dataToArray[0]); //$liveArray[1]
        $stdArray = explode('=', $dataToArray[1]); //$stdArray[1]

        $data = array(
            'resource_id' => $conn->resourceId,
            'live_id' => $liveArray[1],
            'std_id' => empty($stdArray[1]) ? null : $stdArray[1],
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


        if ($this->isStudent($from->resourceId) == true){
            $from_info = $this->queryBuilderWithJoin($from->resourceId);
            $sender = $from_info->name;
        }else {
            $from_info = $this->queryBuilder($from->resourceId);
            $sender = "Admin";
        }

        if ($this->liveStatus($from_info->live_id) > 0) {
            // Store to database
            $historyData = array(
                'live_id' => $from_info->live_id,
                'std_id' => empty($from_info->std_id) ? null : $from_info->std_id,
                'text' => $msg,
                'time' => date('h:m'),
            );
            $this->liveChatHistory->insert($historyData);
        }

        //$msg = json_encode($this->clients);
        foreach ($this->clients as $client) {

            if ($this->isStudent($client->resourceId) == true){
                $client_info = $this->queryBuilderWithJoin($client->resourceId);;
            }else {
                $client_info = $this->queryBuilder($client->resourceId);
            }

            if (($from !== $client) && ($from_info->std_id !== $client_info->std_id)) {

//                $lastQuery = DB()->getLastQuery();
                if ($from_info->live_id == $client_info->live_id) {
                    $info['sender'] = $sender;
                    $info['message'] = $msg;
                    $info = json_encode($info);
                    // The sender is not the receiver, send to each client connected
                    $client->send($info);
                }
//                $client->send($msg);
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

    private function isStudent(int $resource_id) : bool {
        $Builder = DB()->table('chat_room');
        $Builder->select('std_id');
        $Builder->where('resource_id', $resource_id);
        $Builder->where('std_id !=', null);
        return ($Builder->countAllResults(true) > 0) ? true : false;
    }

    private function queryBuilderWithJoin(int $resourceId) : \stdClass {
        $Builder = DB()->table('chat_room');
        $Builder->select('*');
        $Builder->join('student', 'student.std_id = chat_room.std_id');
        $Builder->where('resource_id', $resourceId);
        return $Builder->get()->getRow();
    }
    private function queryBuilder(int $resourceId) : ?\stdClass {
        $Builder = DB()->table('chat_room');
        $Builder->where('resource_id', $resourceId);
        return $Builder->get()->getRow();
    }

    private function liveStatus(int $liveId) : int {
        $Builder = DB()->table('live_class');
        $Builder->select('live_status');
        $Builder->where('live_id', $liveId);
        $Builder->where('live_status', "Runing");
        return $Builder->countAllResults();
    }

}