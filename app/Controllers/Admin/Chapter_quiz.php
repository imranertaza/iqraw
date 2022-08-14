<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Chapter_quizModel;
use App\Models\ChapterModel;
use App\Models\School_classModel;
use App\Models\SubjectModel;


class Chapter_quiz extends BaseController
{
    protected $validation;
    protected $session;
    protected $chapterQuizModel;
    protected $school_classModel;
    protected $subjectModel;
    protected $chapterModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Chapter_quiz';

    public function __construct()
    {
        $this->chapterQuizModel = new Chapter_quizModel();
        $this->school_classModel = new School_classModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterModel = new ChapterModel();
        $this->permission = new Permission();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
    }

    public function index()
    {
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Chapter_quiz';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Chapter_quiz/quiz', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }

    }

    public function getAll()
    {
        $role = $this->session->admin_role;
        //[mod_access] [create] [read] [update] [delete]
        $perm = $this->permission->module_permission_list($role,$this->module_name);
        $response = array();

        $data['data'] = array();

        $result = $this->chapterQuizModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->quiz_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->quiz_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(

                $value->quiz_id,
                get_data_by_id('name', 'chapter', 'chapter_id', $value->chapter_id),
                $value->question,
                $value->one,
                $value->two,
                $value->three,
                $value->four,
                $value->correct_answer,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $data = array();

        $id = $this->request->getPost('quiz_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->chapterQuizModel->where('quiz_id', $id)->first();
            $subject_id = get_data_by_id('subject_id','chapter','chapter_id',$data->chapter_id);
            $class_id = get_data_by_id('class_id','subject','subject_id',$subject_id);
            $data->class_id = $class_id;
            $data->subject_id = $subject_id;

            return $this->response->setJSON($data);
        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['chapter_id'] = $this->request->getPost('chapter_id');
        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'chapter_id' => ['label' => 'Chapter', 'rules' => 'required'],
            'question' => ['label' => 'Question', 'rules' => 'required'],
            'one' => ['label' => 'One', 'rules' => 'required'],
            'two' => ['label' => 'Two', 'rules' => 'required'],
            'three' => ['label' => 'Three', 'rules' => 'required'],
            'four' => ['label' => 'Four', 'rules' => 'required'],
            'correct_answer' => ['label' => 'Correct answer', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->chapterQuizModel->insert($fields)) {

                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Insertion error!';

            }

        }

        return $this->response->setJSON($response);
    }

    public function edit()
    {

        $response = array();

        $quiz_id = $this->request->getPost('quiz_id');

        $fields['quiz_id'] = $this->request->getPost('quiz_id');
        $fields['chapter_id'] = $this->request->getPost('chapter_id');
        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');


        $this->validation->setRules([
            'chapter_id' => ['label' => 'Chapter', 'rules' => 'required'],
            'question' => ['label' => 'Question', 'rules' => 'required'],
            'one' => ['label' => 'One', 'rules' => 'required'],
            'two' => ['label' => 'Two', 'rules' => 'required'],
            'three' => ['label' => 'Three', 'rules' => 'required'],
            'four' => ['label' => 'Four', 'rules' => 'required'],
            'correct_answer' => ['label' => 'Correct answer', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->chapterQuizModel->update($fields['quiz_id'], $fields)) {

                $response['success'] = true;
                $response['messages'] = 'Successfully updated';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Update error!';
            }
        }
        return $this->response->setJSON($response);

    }

    public function remove()
    {
        $response = array();

        $id = $this->request->getPost('quiz_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->chapterQuizModel->where('quiz_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function get_subject(){
        $id = $this->request->getPost('class_id');
        $data = $this->subjectModel->where('class_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $view .= '<option value="'.$val->subject_id.'">'.$val->name.'</option>';
        }

        print $view;
    }

    public function get_chapter(){
        $id = $this->request->getPost('subject_id');
        $data = $this->chapterModel->where('subject_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $view .= '<option value="'.$val->chapter_id.'">'.$val->name.'</option>';
        }

        print $view;
    }


}
