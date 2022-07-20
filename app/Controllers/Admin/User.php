<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\UsersModel;


class User extends BaseController
{
    protected $validation;
    protected $session;
    protected $usersModel;
    protected $crop;
    protected $permission;
    private $module_name = 'User';

    public function __construct()
    {
        $this->usersModel = new UsersModel();
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
            $data['controller'] = 'Admin/User';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/User/user', $data);
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

        $result = $this->usersModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->user_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->user_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';
            $img = (!empty($value->pic)) ? $value->pic : 'noImage.svg';
            $data['data'][$key] = array(
                $value->user_id,
                $value->name,
                $value->email,
                $value->mobile,
                get_data_by_id('role', 'roles', 'role_id', $value->role_id),
                statusView($value->status),
                '<img src="' . base_url() . '/assets/upload/user/' . $img . '" alt="pic" class="rounded-circle" width="80" height="80" >',
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('user_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->usersModel->where('user_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['name'] = $this->request->getPost('name');
        $fields['email'] = $this->request->getPost('email');
        $fields['password'] = SHA1($this->request->getPost('password'));
        $fields['role_id'] = $this->request->getPost('role_id');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'role_id' => ['label' => 'Role', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->usersModel->insert($fields)) {

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

        $user_id = $this->request->getPost('user_id');
        $password = $this->request->getPost('password');

        $fields['user_id'] = $this->request->getPost('user_id');
        $fields['status'] = $this->request->getPost('status');
        $fields['name'] = $this->request->getPost('name');
        $fields['email'] = $this->request->getPost('email');
        $fields['mobile'] = $this->request->getPost('mobile');
        $fields['address'] = $this->request->getPost('address');
        $fields['role_id'] = $this->request->getPost('role_id');
        if (!empty($password)) {
            $fields['password'] = SHA1($this->request->getPost('password'));
        }

        if (!empty($_FILES['pic']['name'])) {

            $target_dir = FCPATH . 'assets/upload/user/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //old image unlink
            $old_img = get_data_by_id('pic', 'users', 'user_id', $user_id);
            if (!empty($old_img)) {
                unlink($target_dir . '' . $old_img);
            }

            //new image uplode
            $pic = $this->request->getFile('pic');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir, $namePic);
            $pro_nameimg = 'user_' . $pic->getName();
            $this->crop->withFile($target_dir . '' . $namePic)->fit(80, 80, 'center')->save($target_dir . '' . $pro_nameimg);
            unlink($target_dir . '' . $namePic);
            $fields['pic'] = $pro_nameimg;

        }


        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required'],
            'role_id' => ['label' => 'Role', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->usersModel->update($fields['user_id'], $fields)) {

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

        $id = $this->request->getPost('user_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->usersModel->where('user_id', $id)->delete()) {

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
