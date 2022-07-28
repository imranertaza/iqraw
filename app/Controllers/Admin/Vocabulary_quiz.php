<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Vocabulary_quizModel;


class Vocabulary_quiz extends BaseController
{
    protected $validation;
    protected $session;
    protected $vocabulary_quizModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Vocabulary_quiz';

    public function __construct()
    {
        $this->vocabulary_quizModel = new Vocabulary_quizModel();
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
            $data['controller'] = 'Admin/Vocabulary_quiz';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Vocabulary_quiz/vocabulary_quiz', $data);
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

        $result = $this->vocabulary_quizModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->voc_quiz_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->voc_quiz_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->voc_quiz_id,
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

        $id = $this->request->getPost('voc_quiz_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->vocabulary_quizModel->where('voc_quiz_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();

        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
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

            if ($this->vocabulary_quizModel->insert($fields)) {

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

        $fields['voc_quiz_id'] = $this->request->getPost('voc_quiz_id');
        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');
        $fields['status'] = $this->request->getPost('status');

        $this->validation->setRules([
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
            if ($this->vocabulary_quizModel->update($fields['voc_quiz_id'], $fields)) {

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

        $id = $this->request->getPost('voc_quiz_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->vocabulary_quizModel->where('voc_quiz_id', $id)->delete()) {

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
