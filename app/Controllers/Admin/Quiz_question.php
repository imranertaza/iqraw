<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Quiz_questionModel;


class Quiz_question extends BaseController
{
    protected $validation;
    protected $session;
    protected $quiz_questionModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Quiz_question';

    public function __construct()
    {
        $this->quiz_questionModel = new Quiz_questionModel();
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
            $data['controller'] = 'Admin/Quiz_question';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Quiz_question/Quiz_question', $data);
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

        $result = $this->quiz_questionModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->quiz_question_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->quiz_question_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(

                $value->quiz_question_id,
                get_data_by_id('quiz_name', 'quiz_exam_info', 'quiz_exam_info_id', $value->quiz_exam_info_id),
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
        $response = array();

        $id = $this->request->getPost('quiz_question_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->quiz_questionModel->where('quiz_question_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['quiz_exam_info_id'] = $this->request->getPost('quiz_exam_info_id');
        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'quiz_exam_info_id' => ['label' => 'quiz_exam_info_id', 'rules' => 'required'],
            'one' => ['label' => 'one', 'rules' => 'required'],
            'two' => ['label' => 'two', 'rules' => 'required'],
            'three' => ['label' => 'three', 'rules' => 'required'],
            'four' => ['label' => 'four', 'rules' => 'required'],
            'correct_answer' => ['label' => 'correct_answer', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->quiz_questionModel->insert($fields)) {

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

        $fields['quiz_question_id'] = $this->request->getPost('quiz_question_id');
        $fields['quiz_exam_info_id'] = $this->request->getPost('quiz_exam_info_id');
        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');
        $fields['status'] = $this->request->getPost('status');

        $this->validation->setRules([
            'quiz_exam_info_id' => ['label' => 'quiz_exam_info_id', 'rules' => 'required'],
            'one' => ['label' => 'one', 'rules' => 'required'],
            'two' => ['label' => 'two', 'rules' => 'required'],
            'three' => ['label' => 'three', 'rules' => 'required'],
            'four' => ['label' => 'four', 'rules' => 'required'],
            'correct_answer' => ['label' => 'correct_answer', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->quiz_questionModel->update($fields['quiz_question_id'], $fields)) {

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

        $id = $this->request->getPost('quiz_question_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->quiz_questionModel->where('quiz_question_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }


}
