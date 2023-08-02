<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class Course_videoModel extends Model {
    
	protected $table = 'course_video';
	protected $primaryKey = 'course_video_id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['course_video_id','course_id','course_cat_id','title','URL','hand_note','thumb','author','total_views','status','createdDtm', 'createdBy', 'updateDtm', 'updatedBy', 'deleted', 'deletedRole'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}