<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class Class_descriptionModel extends Model {

    protected $table = 'class_description';
    protected $primaryKey = 'class_des_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class_des_id','class_group_jnt_id','title','short_description','description','feature_details','for_who','for_why', 'what_is_included','video','syllabus','faq' ];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}