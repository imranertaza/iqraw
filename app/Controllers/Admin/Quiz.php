<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\QuizModel;
use App\Models\SubjectModel;


class Quiz extends BaseController
{
    protected $validation;
    protected $session;
    protected $quizModel;
    protected $subjectModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Quiz';

    public function __construct()
    {
        $this->quizModel = new QuizModel();
        $this->subjectModel = new SubjectModel();
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
            $data['controller'] = 'Admin/Quiz';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Quiz/quiz', $data);
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

        $result = $this->quizModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->quiz_exam_info_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->quiz_exam_info_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(

                $value->quiz_exam_info_id,
                $value->quiz_name,
                get_data_by_id('name', 'class', 'class_id', $value->class_id),
                get_data_by_id('name', 'subject', 'subject_id', $value->subject_id),
                $value->total_questions,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('quiz_exam_info_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->quizModel->where('quiz_exam_info_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['quiz_name'] = $this->request->getPost('quiz_name');
        $fields['total_questions'] = $this->request->getPost('total_questions');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'class_id' => ['label' => 'class_id', 'rules' => 'required'],
            'subject_id' => ['label' => 'subject_id', 'rules' => 'required'],
            'quiz_name' => ['label' => 'quiz_name', 'rules' => 'required'],
            'total_questions' => ['label' => 'total_questions', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->quizModel->insert($fields)) {

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

        $fields['quiz_exam_info_id'] = $this->request->getPost('quiz_exam_info_id');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['quiz_name'] = $this->request->getPost('quiz_name');
        $fields['total_questions'] = $this->request->getPost('total_questions');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'subject_id' => ['label' => 'subject_id', 'rules' => 'required'],
            'quiz_name' => ['label' => 'quiz_name', 'rules' => 'required'],
            'total_questions' => ['label' => 'total_questions', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->quizModel->update($fields['quiz_exam_info_id'], $fields)) {

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

        $id = $this->request->getPost('quiz_exam_info_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->quizModel->where('quiz_exam_info_id', $id)->delete()) {

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
        $class_id = $this->request->getPost('class_id');

        $subject = $this->subjectModel->where('class_id',$class_id)->findAll();

        $view = '<option value="">Please select</option>';
        if (!empty($subject)){
            foreach ($subject as $val) {
                $view .='<option value="'.$val->subject_id.'">'.$val->name.'</option>';
            }
        }
        print $view;
    }

}
