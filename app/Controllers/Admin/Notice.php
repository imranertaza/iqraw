<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\NoticeModel;
use App\Models\StudentModel;


class Notice extends BaseController
{
    protected $validation;
    protected $session;
    protected $noticeModel;
    protected $studentModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Notice';

    public function __construct()
    {
        $this->noticeModel = new NoticeModel();
        $this->studentModel = new StudentModel();
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
            $data['controller'] = 'Admin/Notice';


            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Notice/list', $data);
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

        $result = $this->noticeModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->notice_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->notice_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->notice_id,
                $value->title,
                $value->description,
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('notice_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->noticeModel->where('notice_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['title'] = $this->request->getPost('title');
        $fields['description'] = $this->request->getPost('description');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'description' => ['label' => 'Description', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->noticeModel->insert($fields)) {
                $notice_id = $this->noticeModel->getInsertID();
                $allStudent = $this->studentModel->findAll();

                foreach ($allStudent as $std){
                    $dataRead['notice_id'] = $notice_id;
                    $dataRead['receiver_std_id'] = $std->std_id;
                    $dataRead['createdBy'] = $this->session->user_id;
                    $table = DB()->table('notice_send');
                    $table->insert($dataRead);
                }

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

        $notice_id = $this->request->getPost('notice_id');

        $fields['notice_id'] = $this->request->getPost('notice_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['description'] = $this->request->getPost('description');


        $this->validation->setRules([
            'notice_id' => ['label' => 'Class', 'rules' => 'required'],
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'description' => ['label' => 'Description', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->noticeModel->update($fields['notice_id'], $fields)) {

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

        $id = $this->request->getPost('notice_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->noticeModel->where('notice_id', $id)->delete()) {

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
