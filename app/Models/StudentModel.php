<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model {

    protected $table = 'student';
    protected $primaryKey = 'std_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['std_id', 'phone', 'password', 'name', 'father_name', 'address', 'school_name', 'gender', 'religion', 'age', 'class_id', 'class_group', 'institute', 'pic', 'point', 'coin', 'badge_id', 'status', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm', 'deleted', 'deletedRole'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}