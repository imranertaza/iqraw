<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\User_rollModel;


class User_roll extends BaseController
{
    protected $validation;
    protected $session;
    protected $user_rollModel;
    protected $permission;
    protected $crop;
    private $module_name = 'User_roll';

    public function __construct()
    {
        $this->user_rollModel = new User_rollModel();
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
            $data['controller'] = 'Admin/User_roll';

            $data['permission'] = json_decode($this->permission->all_permissions);

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Roll/roll', $data);
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
        $perm = $this->permission->module_permission_list($role, $this->module_name);
        $response = array();

        $data['data'] = array();

        $result = $this->user_rollModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] == 1) {
                $ops .= '	<a href="' . base_url() . '/Admin/User_roll/update/' . $value->role_id . '" type="button" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></a>';
            }
            if ($perm['delete'] == 1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->role_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->role_id,
                $value->role,
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('role_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->user_rollModel->where('role_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function update($id)
    {
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/User_roll';

            $data['permission'] = json_decode($this->permission->all_permissions);
            $data['roll'] = $this->user_rollModel->where('role_id', $id)->first();


            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['update'] == 1) {
                echo view('Admin/Roll/roll_update', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function update_action()
    {
        $response = array();

        $fields['role_id'] = $this->request->getPost('role_id');
        $fields['role'] = $this->request->getPost('role');
        $permission = $this->request->getPost('permission[][]');

        $all_permissions = json_decode($this->permission->all_permissions, true);
        foreach ($permission as $k => $v) {
            foreach ($v as $key => $value) {
                $all_permissions[$k][$key] = $value;
            }
        }
        $fields['permission'] = json_encode($all_permissions);

        $this->validation->setRules([
            'role_id' => ['label' => 'role_id', 'rules' => 'required'],
            'role' => ['label' => 'Role', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->user_rollModel->update($fields['role_id'], $fields)) {

                $response['success'] = true;
                $response['messages'] = 'Successfully updated';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Update error!';
            }
        }
        return $this->response->setJSON($response);
    }

    public function add()
    {

        $response = array();


        $fields['role'] = $this->request->getPost('role');
        $permission = $this->request->getPost('permission[][]');
        $fields['createdBy'] = $this->session->user_id;


        $all_permissions = json_decode($this->permission->all_permissions, true);
        foreach ($permission as $k => $v) {
            foreach ($v as $key => $value) {
                $all_permissions[$k][$key] = $value;
            }
        }
        $fields['permission'] = json_encode($all_permissions);

        $this->validation->setRules([
            'role' => ['label' => 'Role', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->user_rollModel->insert($fields)) {

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

        $role_id = $this->request->getPost('role_id');

        $fields['role_id'] = $this->request->getPost('role_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['status'] = $this->request->getPost('status');


        $this->validation->setRules([
            'role_id' => ['label' => 'Class', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->user_rollModel->update($fields['role_id'], $fields)) {

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

        $id = $this->request->getPost('role_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->user_rollModel->where('role_id', $id)->delete()) {

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
