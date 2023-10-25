<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Vocabulary_exam_r_quizModel;
use App\Models\Vocabulary_examModel;
use App\Models\Vocabulary_quizModel;


class Vocabulary_exam extends BaseController
{
    protected $validation;
    protected $session;
    protected $vocabulary_examModel;
    protected $vocabulary_quizModel;
    protected $vocabulary_exam_r_quizModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Vocabulary_exam';

    public function __construct()
    {
        $this->vocabulary_examModel = new Vocabulary_examModel();
        $this->vocabulary_quizModel = new Vocabulary_quizModel();
        $this->vocabulary_exam_r_quizModel = new Vocabulary_exam_r_quizModel();
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
            $data['controller'] = 'Admin/Vocabulary_exam';

            $data['vocQuiz'] =$this->vocabulary_quizModel->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Vocabulary_exam/vocabulary_exam', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }

    }

    public function update($id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Vocabulary_exam';

            $data['exam'] = $this->vocabulary_examModel->where('voc_exam_id', $id)->first();
            $data['quiz'] = $this->vocabulary_quizModel->findAll();
            $data['quizData'] = $this->vocabulary_exam_r_quizModel->where('voc_exam_id', $id)->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Vocabulary_exam/vocabulary_exam_update', $data);
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

        $result = $this->vocabulary_examModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<a href="'.base_url('Admin/Vocabulary_exam/update/'.$value->voc_exam_id).'" type="button" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></a>';
            }
//            if ($perm['delete'] ==1) {
//                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->voc_exam_id . ')"><i class="fa fa-trash"></i></button>';
//            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->voc_exam_id,
                $value->title,
                $value->published_date,
                $value->status,
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('voc_exam_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->vocabulary_examModel->where('voc_exam_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();

        $quiz = $this->request->getPost('voc_quiz_id[]');

        $fields['title'] = $this->request->getPost('title');
        $fields['published_date'] = $this->request->getPost('published_date');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'published_date' => ['label' => 'Published date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if (!empty($quiz)) {

                if ($this->vocabulary_examModel->insert($fields)) {

                    $insertId = $this->vocabulary_examModel->getInsertID();

                    foreach ($quiz as $key => $val) {
                        $quizData = [
                            'voc_exam_id' => $insertId,
                            'voc_quiz_id' => $val,
                            'createdBy' => $this->session->user_id,
                        ];
                        $this->vocabulary_exam_r_quizModel->insert($quizData);
                    }

                    $response['success'] = true;
                    $response['messages'] = 'Data has been inserted successfully';

                } else {

                    $response['success'] = false;
                    $response['messages'] = 'Insertion error!';

                }
            }else{
                $response['success'] = false;
                $response['messages'] = 'Please select any question!';
            }

        }

        return $this->response->setJSON($response);
    }

    public function edit()
    {

        $response = array();

        $voc_exam_id = $this->request->getPost('voc_exam_id');
        $quiz = $this->request->getPost('voc_quiz_id[]');
        $fields['voc_exam_id'] = $this->request->getPost('voc_exam_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['published_date'] = $this->request->getPost('published_date');
        $fields['status'] = $this->request->getPost('status');

        $this->validation->setRules([
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'published_date' => ['label' => 'Published date', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->vocabulary_examModel->update($fields['voc_exam_id'], $fields)) {

                $quizData = $this->vocabulary_exam_r_quizModel->where('voc_exam_id', $voc_exam_id)->findAll();
                foreach ($quizData as $val) {
                    $this->vocabulary_exam_r_quizModel->where('exam_quiz_id', $val->exam_quiz_id)->delete();
                }

                foreach ($quiz as $q){
                    $quizind =['voc_exam_id'=> $voc_exam_id,'voc_quiz_id'=> $q,'createdBy' => $this->session->user_id, ];
                    $this->vocabulary_exam_r_quizModel->insert($quizind);
                }

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

        $id = $this->request->getPost('voc_exam_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->vocabulary_examModel->where('voc_exam_id', $id)->delete()) {

                $quizData = $this->vocabulary_exam_r_quizModel->where('voc_exam_id', $id)->findAll();
                foreach ($quizData as $val) {
                    $this->vocabulary_exam_r_quizModel->where('exam_quiz_id', $val->exam_quiz_id)->delete();
                }

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
