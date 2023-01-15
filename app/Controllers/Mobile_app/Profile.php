<?php

namespace App\Controllers\Mobile_app;

use App\Controllers\BaseController;
use App\Models\Chapter_exam_joinedModel;
use App\Models\Class_group_joinedModel;
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
    protected $class_group_joinedModel;
    protected $mcq_exam_joinedModel;
    protected $vocabulary_exam_joinedModel;
    protected $quiz_exam_joinedModel;

    public function __construct()
    {
        $this->student = new StudentModel();
        $this->chapter_exam_joinedModel = new Chapter_exam_joinedModel();
        $this->class_group_joinedModel = new Class_group_joinedModel();
        $this->mcq_exam_joinedModel = new Mcq_exam_joinedModel();
        $this->vocabulary_exam_joinedModel = new Vocabulary_exam_joinedModel();
        $this->quiz_exam_joinedModel = new Quiz_exam_joinedModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'Profile';
            $data['footer_icon'] = 'Home';

            $query = $this->student->where('std_id', $this->session->std_id)->get();
            $data['user'] = $query->getRow();

            $chapExam = $this->chapter_exam_joinedModel->where('std_id', $this->session->std_id)->countAllResults();
            $mcqExam = $this->mcq_exam_joinedModel->where('std_id', $this->session->std_id)->countAllResults();
            $vocExam = $this->vocabulary_exam_joinedModel->where('std_id', $this->session->std_id)->countAllResults();
            $quizExam = $this->quiz_exam_joinedModel->where('std_id', $this->session->std_id)->countAllResults();

            $data['totalExamJoin'] = $chapExam + $mcqExam + $vocExam + $quizExam;

            echo view('Student/header', $data);
            echo view('Student/profile', $data);
            echo view('Student/footer');
        }
    }

    public function update()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Profile');
            $data['page_title'] = 'Profile Update';
            $data['footer_icon'] = 'Home';

            $query = $this->student->where('std_id', $this->session->std_id)->get();
            $data['student'] = $query->getRow();

            echo view('Student/header', $data);
            echo view('Student/profile_update', $data);
            echo view('Student/footer');
        }
    }

    public function update_action()
    {
        $fields['std_id'] = $this->session->std_id;
        $fields['name'] = $this->request->getPost('name');
        $fields['phone'] = $this->request->getPost('phone');
        $fields['father_name'] = $this->request->getPost('father_name');
        $fields['address'] = $this->request->getPost('address');
        $fields['gender'] = $this->request->getPost('gender');
        $fields['age'] = $this->request->getPost('age');
        $fields['religion'] = $this->request->getPost('religion');
        $fields['institute'] = $this->request->getPost('institute');
        $fields['school_name'] = $this->request->getPost('school_name');
        $fields['class_id'] = empty($this->request->getPost('class_id')) ? null : $this->request->getPost('class_id');;
        $fields['class_group_id'] = empty($this->request->getPost('class_group_id')) ? null : $this->request->getPost('class_group_id');


        $rules = [
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'gender' => ['label' => 'Gender', 'rules' => 'required'],
            'religion' => ['label' => 'Religion', 'rules' => 'required'],
        ];

        if (checkClassIdByGroup($fields['class_id']) == 1) {
            $rules['class_id'] = ['label' => 'Class', 'rules' => 'required'];
            $rules['class_group_id'] = ['label' => 'Class Group', 'rules' => 'required'];
        }

        $this->validation->setRules($rules);

        if ($this->validation->run($fields) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$this->validation->listErrors().'</div>');
            return redirect()->to('/Mobile_app/Profile/update');

        } else {
            $this->student->update($fields['std_id'], $fields);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Update Successfully</div>');
            return redirect()->to('/Mobile_app/Profile/update');

        }
    }

    public function groupCheck()
    {
        $class_id = $this->request->getPost('class_id');

        $query = $this->class_group_joinedModel->where('class_id', $class_id)->findAll();
        $view = '';
        if (!empty($query)) {
            $view .= '<select class="form-control" name="class_group_id" id="class_group_id" required>';
            $view .= '<option value="">Class Group</option>';
            foreach ($query as $val) {
                $groupName = get_data_by_id('group_name', 'class_group', 'class_group_id', $val->class_group_id);
                $view .= '<option value="' . $val->class_group_id . '">' . $groupName . '</option>';
            }
            $view .= '</select>';
        }


        print $view;
    }


}
