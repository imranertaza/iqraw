<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class LiveChatHistoryModel extends Model {

    protected $table = 'live_chat_history';
    protected $primaryKey = 'live_chat_history_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['live_chat_history_id', 'std_id', 'live_id', 'text', 'time'];
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}