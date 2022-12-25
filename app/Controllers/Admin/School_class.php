<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Class_group_joinedModel;
use App\Models\Group_classModel;
use App\Models\School_classModel;


class School_class extends BaseController
{
    protected $validation;
    protected $session;
    protected $classModel;
    protected $group_classModel;
    protected $class_group_joinedModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Class';

    public function __construct()
    {
        $this->classModel = new School_classModel();
        $this->group_classModel = new Group_classModel();
        $this->class_group_joinedModel = new Class_group_joinedModel();
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
            $data['controller'] = 'Admin/School_class';
            $data['group'] = $this->group_classModel->findAll();


            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/School_class/class', $data);
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

        $result = $this->classModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '<a href="'.base_url('Admin/School_class/update/'.$value->class_id).'" type="button" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></a>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->class_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->class_id,
                $value->name,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('class_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->classModel->where('class_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['name'] = $this->request->getPost('name');
        $fields['createdBy'] = $this->session->user_id;
        $group_id = $this->request->getPost('group_id[]');


        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->classModel->insert($fields)) {
                $classId = $this->classModel->getInsertID();
                if (!empty($group_id)) {
                    foreach ($group_id as $v) {
                        $dat['class_id'] = $classId;
                        $dat['class_group_id'] = $v;
                        $dat['createdBy'] = $this->session->user_id;
                        $this->class_group_joinedModel->insert($dat);
                    }
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

        $class_id = $this->request->getPost('class_id');

        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['name'] = $this->request->getPost('name');
        $group_id = $this->request->getPost('group_id[]');
        $this->class_group_joinedModel->where('class_id', $class_id)->delete();

        if (!empty($group_id)) {
            foreach ($group_id as $v) {
                $dat['class_id'] = $class_id;
                $dat['class_group_id'] = $v;
                $dat['createdBy'] = $this->session->user_id;
                $this->class_group_joinedModel->insert($dat);
            }
        }
        $fields['status'] = $this->request->getPost('status');


        $this->validation->setRules([
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->classModel->update($fields['class_id'], $fields)) {

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

        $id = $this->request->getPost('class_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->classModel->where('class_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function update($id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/School_class';
            $data['group'] = $this->group_classModel->findAll();
            $data['class'] = $this->classModel->where('class_id', $id)->first();
            $data['classGroup'] = $this->class_group_joinedModel->where('class_id', $id)->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['update'] == 1) {
                echo view('Admin/School_class/update', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }


}
