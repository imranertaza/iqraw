<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class School_classModel extends Model {

    protected $table = 'class';
    protected $primaryKey = 'class_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class_id','group_id','name', 'status', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm', 'deleted', 'deletedRole'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}