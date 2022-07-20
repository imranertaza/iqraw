<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\ChapterModel;
use App\Models\School_classModel;
use App\Models\SubjectModel;


class Subject extends BaseController
{
    protected $validation;
    protected $session;
    protected $schoolClassModel;
    protected $subjectModel;
    protected $chapterModel;

    public function __construct()
    {
        $this->schoolClassModel = new School_classModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterModel = new ChapterModel();
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
            $data['page_title'] = 'My Subject';

            $classId = get_data_by_id('class_id','student','std_id',$this->session->std_id);

            $data['subject'] = $this->subjectModel->where('class_id',$classId)->findAll();
            unset($_SESSION['quiz']);
            unset($_SESSION['chapter_joined_id']);

            echo view('Student/header',$data);
            echo view('Student/class',$data);
            echo view('Student/footer');
        }
    }

    public function chapter($subjectId)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {
            $subject = get_data_by_id('name','subject','subject_id',$subjectId);
            $data['back_url'] = base_url('/Student/Subject');
            $data['page_title'] = $subject;


            $data['chapter'] = $this->chapterModel->where('subject_id',$subjectId)->findAll();

            echo view('Student/header',$data);
            echo view('Student/chapter',$data);
            echo view('Student/footer');
        }
    }




}
