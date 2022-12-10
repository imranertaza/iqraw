<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\Quiz_exam_joinedModel;
use App\Models\Quiz_questionModel;
use App\Models\QuizModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use App\Models\Vocabulary_exam_joinedModel;
use App\Models\Vocabulary_exam_r_quizModel;
use App\Models\Vocabulary_examModel;
use App\Models\VocabularyModel;
use CodeIgniter\Database\RawSql;


class Ranking extends BaseController
{
    protected $validation;
    protected $session;
    protected $student;
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'Ranking';
            $data['footer_icon'] = 'Ranking';
            $classId = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $classGroupId = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);
            $data['student'] = $this->studentModel->where('class_id',$classId)->where('class_group_id',$classGroupId)->limit(50)->findAll();

            $table = DB()->table('student');
            $hpoint = $table->selectMax('point' )->get()->getRow()->point;
            $data['studentBig'] = $this->studentModel->where('point',$hpoint)->first();



            echo view('Student/header',$data);
            echo view('Student/ranking',$data);
            echo view('Student/footer');
        }
    }






}
