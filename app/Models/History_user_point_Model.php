<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class History_user_point_Model extends Model {

    protected $table = 'history_user_point';
    protected $primaryKey = 'history_user_point_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['history_user_point_id','std_id','order_id','chapter_joined_id', 'mcq_joined_id', 'qe_joined_id', 'voc_mcq_joined_id', 'particulars', 'trangaction_type', 'amount', 'rest_balance', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm', 'deleted', 'deletedRole'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}