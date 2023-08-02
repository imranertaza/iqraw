<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class Course_quizModel extends Model {

    protected $table = 'course_quiz';
    protected $primaryKey = 'course_quiz_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['course_quiz_id','course_video_id','question','one','two','three','four','correct_answer', 'status', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm', 'deleted', 'deletedRole'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}