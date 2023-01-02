<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Course_subscribeModel;
use App\Models\CourseModel;


class Subscribe extends BaseController
{
    protected $validation;
    protected $session;
    protected $course_subscribeModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Subscribe';

    public function __construct()
    {
        $this->course_subscribeModel = new Course_subscribeModel();
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
            $data['controller'] = 'Admin/Subscribe';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Subscribe/payment', $data);
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

        $result = $this->course_subscribeModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->course_subscribe_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->course_subscribe_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->course_subscribe_id,
                get_data_by_id('name','student','std_id',$value->std_id),
                get_data_by_id('course_name','course','course_id',$value->course_id),
                statusView($value->status),
//                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('course_subscribe_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->course_subscribeModel->where('course_subscribe_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['course_name'] = $this->request->getPost('course_name');
        $fields['price'] = $this->request->getPost('price');
        $fields['description'] = $this->request->getPost('description');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['class_group_id'] = $this->request->getPost('class_group_id');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'course_name' => ['label' => 'Name', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'description' => ['label' => 'description', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->course_subscribeModel->insert($fields)) {

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

        $course_subscribe_id = $this->request->getPost('course_subscribe_id');

        $fields['course_subscribe_id'] = $this->request->getPost('course_subscribe_id');
        $fields['course_name'] = $this->request->getPost('course_name');
        $fields['price'] = $this->request->getPost('price');
        $fields['description'] = $this->request->getPost('description');


        $this->validation->setRules([
            'course_subscribe_id' => ['label' => 'Class', 'rules' => 'required'],
            'course_name' => ['label' => 'Name', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'description' => ['label' => 'description', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->course_subscribeModel->update($fields['course_subscribe_id'], $fields)) {

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

        $id = $this->request->getPost('course_subscribe_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->course_subscribeModel->where('course_subscribe_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function get_group(){
        $id = $this->request->getPost('class_id');
        $data = $this->class_group_joinedModel->where('class_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $name = get_data_by_id('group_name','class_group','class_group_id',$val->class_group_id);
            $view .= '<option value="'.$val->class_group_id.'">'.$name.'</option>';
        }

        print $view;
    }


}
