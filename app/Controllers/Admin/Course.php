<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Class_group_joinedModel;
use App\Models\CourseModel;
use App\Models\Group_classModel;
use App\Models\SubjectModel;


class Course extends BaseController
{
    protected $validation;
    protected $session;
    protected $courseModel;
    protected $group_classModel;
    protected $class_group_joinedModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Course';

    public function __construct()
    {
        $this->courseModel = new CourseModel();
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
            $data['controller'] = 'Admin/Course';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Course/course', $data);
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

        $result = $this->courseModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->course_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->course_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->course_id,
                $value->course_name,
                $value->price,
                $value->description,
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('course_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->courseModel->where('course_id', $id)->first();

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

            if ($this->courseModel->insert($fields)) {

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

        $course_id = $this->request->getPost('course_id');

        $fields['course_id'] = $this->request->getPost('course_id');
        $fields['course_name'] = $this->request->getPost('course_name');
        $fields['price'] = $this->request->getPost('price');
        $fields['description'] = $this->request->getPost('description');


        $this->validation->setRules([
            'course_id' => ['label' => 'Class', 'rules' => 'required'],
            'course_name' => ['label' => 'Name', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'description' => ['label' => 'description', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->courseModel->update($fields['course_id'], $fields)) {

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

        $id = $this->request->getPost('course_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->courseModel->where('course_id', $id)->delete()) {

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
