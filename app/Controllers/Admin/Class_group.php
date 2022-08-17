<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Group_classModel;
use App\Libraries\Permission;


class Class_group extends BaseController
{
    protected $validation;
    protected $session;
    protected $group_classModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Class_group';

    public function __construct()
    {
        $this->group_classModel = new Group_classModel();
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
            $data['controller'] = 'Admin/Class_group';


            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Class_group/group', $data);
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

        $result = $this->group_classModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->class_group_id . ')"><i class="fa fa-edit"></i></button>';
            }
//            if ($perm['delete'] ==1) {
//                $ops .= '<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->class_group_id . ')"><i class="fa fa-trash"></i></button>';
//            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->class_group_id,
                $value->group_name,
                $value->status,
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('class_group_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->group_classModel->where('class_group_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['group_name'] = $this->request->getPost('group_name');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'group_name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->group_classModel->insert($fields)) {

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

        $class_group_id = $this->request->getPost('class_group_id');

        $fields['class_group_id'] = $this->request->getPost('class_group_id');
        $fields['group_name'] = $this->request->getPost('group_name');
        $fields['status'] = $this->request->getPost('status');


        $this->validation->setRules([
            'class_group_id' => ['label' => 'Class', 'rules' => 'required'],
            'group_name' => ['label' => 'Name', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->group_classModel->update($fields['class_group_id'], $fields)) {

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

        $id = $this->request->getPost('class_group_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->group_classModel->where('class_group_id', $id)->delete()) {

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
