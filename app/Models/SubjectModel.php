<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class SubjectModel extends Model {

    protected $table = 'subject';
    protected $primaryKey = 'subject_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['subject_id','class_id','class_group_id','name', 'status', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm', 'deleted', 'deletedRole'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}