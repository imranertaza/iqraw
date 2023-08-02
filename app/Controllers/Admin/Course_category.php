<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Course_categoryModel;


class Course_category extends BaseController
{
    protected $validation;
    protected $session;
    protected $course_categoryModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Course';

    public function __construct()
    {
        $this->course_categoryModel = new Course_categoryModel();
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
            $data['controller'] = 'Admin/Course_category';

            $table = DB()->table('course');
            $data['course'] = $table->get()->getResult();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Course_category/list', $data);
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

        $result = $this->course_categoryModel->findAll();

        foreach ($result as $key => $value) {

            $img = (!empty($value->image))?$value->image:'noImage.svg';
            $image = '<img src="'.base_url('assets/upload/courseCategory/'.$img).'"  width="150" alt="">';


            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->course_cat_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->course_cat_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->course_cat_id,
                get_data_by_id('course_name','course','course_id',$value->course_id),
                $value->category_name,
                $image,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('course_cat_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->course_categoryModel->where('course_cat_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add(){

        $response = array();


        $fields['category_name'] = $this->request->getPost('category_name');
        $fields['course_id'] = $this->request->getPost('course_id');
        $fields['createdBy'] = $this->session->user_id;
        $image = $this->request->getFile('image');

        if (!empty($_FILES['image']['name'])) {
            // thumb image uploading section (start)
            $target_dir = FCPATH . 'assets/upload/courseCategory/';
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            $name = $image->getRandomName();
            $image->move($target_dir, $name);

            // Image cropping of the uploaded image
            $nameimg = 'category_' . $image->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $nameimg);
            unlink($target_dir . '' . $name);

            $fields['image'] = $nameimg;
        }
        // image uploading section (End)

        $this->validation->setRules([
            'category_name' => ['label' => 'Category Name', 'rules' => 'required'],
            'course_id' => ['label' => 'Course', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->course_categoryModel->insert($fields)) {

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

        $fields['course_cat_id'] = $this->request->getPost('course_cat_id');

        $fields['category_name'] = $this->request->getPost('category_name');
        $fields['course_id'] = $this->request->getPost('course_id');
        $fields['status'] = $this->request->getPost('status');
        $image = $this->request->getFile('image');

        if (!empty($_FILES['image']['name'])) {
            //image uploading section (start)
            $target_dir = FCPATH . 'assets/upload/courseCategory/';
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            $name = $image->getRandomName();
            $image->move($target_dir, $name);

            // Image cropping of the uploaded image
            $nameimg = 'category_' . $image->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $nameimg);
            unlink($target_dir . '' . $name);

            $fields['image'] = $nameimg;
        }
        // image uploading section (End)


        $this->validation->setRules([
            'category_name' => ['label' => 'Category Name', 'rules' => 'required'],
            'course_id' => ['label' => 'Course', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->course_categoryModel->update($fields['course_cat_id'], $fields)) {

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

        $id = $this->request->getPost('course_cat_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->course_categoryModel->where('course_cat_id', $id)->delete()) {

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
