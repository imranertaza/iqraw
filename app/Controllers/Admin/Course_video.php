<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Course_categoryModel;
use App\Models\Course_videoModel;


class Course_video extends BaseController
{
    protected $validation;
    protected $session;
    protected $course_videoModel;
    protected $course_categoryModel;
    protected $group_classModel;
    protected $class_group_joinedModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Course_video';

    public function __construct()
    {
        $this->course_videoModel = new Course_videoModel();
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
            $data['controller'] = 'Admin/Course_video';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Course_video/course_video', $data);
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

        $result = $this->course_videoModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->course_video_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->course_video_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->course_video_id,
                get_data_by_id('course_name','course','course_id',$value->course_id),
                get_data_by_id('category_name','course_category','course_cat_id',$value->course_cat_id),
                $value->title,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('course_video_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->course_videoModel->where('course_video_id', $id)->first();



            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['course_id'] = $this->request->getPost('course_id');
        $fields['course_cat_id'] = $this->request->getPost('course_cat_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['author'] = $this->request->getPost('author');
        $fields['URL'] = $this->request->getPost('URL');
        $fields['createdBy'] = $this->session->user_id;


        $thumb = $this->request->getFile('thumb');


        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/courseVideo/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        if (!empty($_FILES['thumb']['name'])) {
            $name = $thumb->getRandomName();
            $thumb->move($target_dir, $name);

            // Image cropping of the uploaded image
            $thumb_nameimg = 'thumb_' . $thumb->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $thumb_nameimg);
            unlink($target_dir . '' . $name);

            $fields['thumb'] = $thumb_nameimg;
        }
        // thumb image uploading section (End)

        $this->validation->setRules([
            'course_id' => ['label' => 'course_id', 'rules' => 'required'],
            'course_cat_id' => ['label' => 'course_cat_id', 'rules' => 'required'],
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'author' => ['label' => 'Author', 'rules' => 'required'],
            'URL' => ['label' => 'URL', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->course_videoModel->insert($fields)) {

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

        $course_video_id = $this->request->getPost('course_video_id');

        $fields['course_video_id'] = $this->request->getPost('course_video_id');
        $fields['course_id'] = $this->request->getPost('course_id');
        $fields['course_cat_id'] = $this->request->getPost('course_cat_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['author'] = $this->request->getPost('author');
        $fields['URL'] = $this->request->getPost('URL');

        $thumb = $this->request->getFile('thumb');
        $oldimg = get_data_by_id('thumb','course_video','course_video_id',$course_video_id);

        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/courseVideo/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        if (!empty($_FILES['thumb']['name'])) {

            unlink($target_dir . '' . $oldimg);
            $name = $thumb->getRandomName();
            $thumb->move($target_dir, $name);

            // Image cropping of the uploaded image
            $thumb_nameimg = 'thumb_' . $thumb->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $thumb_nameimg);
            unlink($target_dir . '' . $name);

            $fields['thumb'] = $thumb_nameimg;
        }
        // thumb image uploading section (End)


        $this->validation->setRules([
            'course_id' => ['label' => 'course_id', 'rules' => 'required'],
            'course_cat_id' => ['label' => 'course_cat_id', 'rules' => 'required'],
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'author' => ['label' => 'Author', 'rules' => 'required'],
            'URL' => ['label' => 'URL', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->course_videoModel->update($fields['course_video_id'], $fields)) {

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

        $id = $this->request->getPost('course_video_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->course_videoModel->where('course_video_id', $id)->delete()) {

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

    public function get_category(){
        $id = $this->request->getPost('course_id');
        $data = $this->course_categoryModel->where('course_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $view .= '<option value="'.$val->course_cat_id.'">'.$val->category_name.'</option>';
        }

        print $view;
    }


}
