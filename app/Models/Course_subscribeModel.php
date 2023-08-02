<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class Course_subscribeModel extends Model {
    
	protected $table = 'course_subscribe';
	protected $primaryKey = 'course_subscribe_id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['course_subscribe_id','std_id','course_id','subs_time','status','createdDtm', 'createdBy', 'updateDtm', 'updatedBy', 'deleted', 'deletedRole'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}