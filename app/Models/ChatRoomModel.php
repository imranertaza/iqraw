<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class ChatRoomModel extends Model {

    protected $table = 'chat_room';
    protected $primaryKey = 'room_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['room_id', 'resource_id', 'std_id', 'live_id', 'class_id', 'group_id', 'value'];
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}