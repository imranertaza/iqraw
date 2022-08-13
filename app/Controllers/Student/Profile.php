<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\Chapter_exam_joinedModel;
use App\Models\Mcq_exam_joinedModel;
use App\Models\Quiz_exam_joinedModel;
use App\Models\StudentModel;
use App\Models\Vocabulary_exam_joinedModel;


class Profile extends BaseController
{
    protected $validation;
    protected $session;
    protected $student;
    protected $chapter_exam_joinedModel;
    protected $mcq_exam_joinedModel;
    protected $vocabulary_exam_joinedModel;
    protected $quiz_exam_joinedModel;

    public function __construct()
    {
        $this->student = new StudentModel();
        $this->chapter_exam_joinedModel = new Chapter_exam_joinedModel();
        $this->mcq_exam_joinedModel = new Mcq_exam_joinedModel();
        $this->vocabulary_exam_joinedModel = new Vocabulary_exam_joinedModel();
        $this->quiz_exam_joinedModel = new Quiz_exam_joinedModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/');
            $data['page_title'] = 'Profile';
            $data['footer_icon'] = 'Home';

            $query = $this->student->where('std_id',$this->session->std_id)->get();
            $data['user'] = $query->getRow();

            $chapExam = $this->chapter_exam_joinedModel->where('std_id',$this->session->std_id)->countAllResults();
            $mcqExam = $this->mcq_exam_joinedModel->where('std_id',$this->session->std_id)->countAllResults();
            $vocExam = $this->vocabulary_exam_joinedModel->where('std_id',$this->session->std_id)->countAllResults();
            $quizExam = $this->quiz_exam_joinedModel->where('std_id',$this->session->std_id)->countAllResults();

            $data['totalExamJoin']= $chapExam + $mcqExam + $vocExam + $quizExam;

            echo view('Student/header',$data);
            echo view('Student/profile',$data);
            echo view('Student/footer');
        }
    }




}
