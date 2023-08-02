<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class CourseModel extends Model {
    
	protected $table = 'course';
	protected $primaryKey = 'course_id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['course_id','course_name','description','price','class_id','class_group_id','image','createdDtm', 'createdBy', 'updateDtm', 'updatedBy', 'deleted', 'deletedRole'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}