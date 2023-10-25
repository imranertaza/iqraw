<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Class_descriptionModel;
use App\Models\Class_group_joinedModel;


class Class_description extends BaseController
{
    protected $validation;
    protected $session;
    protected $class_descriptionModel;
    protected $class_group_joinedModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Class_description';

    public function __construct()
    {
        $this->class_descriptionModel = new Class_descriptionModel();
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
            $data['controller'] = 'Admin/Class_description';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Class_description/index', $data);
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

        $result = $this->class_descriptionModel->findAll();

        foreach ($result as $key => $value) {
            $class_group = $this->class_group_joinedModel->where('class_group_jnt_id',$value->class_group_jnt_id)->first();
            $class = get_data_by_id('name','class','class_id',$class_group->class_id);
            $group = get_data_by_id('group_name','class_group','class_group_id',$class_group->class_group_id);
            $clGro = (!empty($group))?$class.' -> '.$group:$class;
            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '<a href="'.base_url('Admin/Class_description/update/'.$value->class_des_id).'" type="button" class="btn btn-sm btn-info"  ><i class="fa fa-edit"></i></a>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->class_des_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->class_des_id,
                $clGro,
                $value->title,
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Class_description';
            $data['class_group'] = $this->class_group_joinedModel->findAll();
            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['create'] == 1) {
                echo view('Admin/Class_description/create', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }

    }


    public function create_action(){

        $response = array();

        $fields['class_group_jnt_id'] = $this->request->getPost('class_group_jnt_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['short_description'] = $this->request->getPost('short_description');
        $fields['description'] = $this->request->getPost('description');
        $fields['feature_details'] = $this->request->getPost('feature_details');
        $fields['video'] = $this->request->getPost('video');
        $fields['for_who'] = $this->request->getPost('for_who');
        $fields['for_why'] = $this->request->getPost('for_why');
        $fields['what_is_included'] = $this->request->getPost('what_is_included');
        $fields['syllabus'] = $this->request->getPost('syllabus');
        $fields['faq'] = $this->request->getPost('faq');


        $this->validation->setRules([
            'class_group_jnt_id' => ['label' => 'Class', 'rules' => 'required'],
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'short_description' => ['label' => 'Short Description', 'rules' => 'required'],
            'feature_details' => ['label' => 'Feature Details', 'rules' => 'required'],
            'video' => ['label' => 'Video', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->class_descriptionModel->insert($fields)) {

                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Insertion error!';

            }

        }

        return $this->response->setJSON($response);
    }


    public function update($id)
    {
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Class_description';
            $data['class_group'] = $this->class_group_joinedModel->findAll();

            $data['desc'] = $this->class_descriptionModel->where('class_des_id',$id)->first();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['create'] == 1) {
                echo view('Admin/Class_description/update', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }

    }

    public function update_action(){

        $response = array();

        $fields['class_des_id'] = $this->request->getPost('class_des_id');
        $fields['class_group_jnt_id'] = $this->request->getPost('class_group_jnt_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['short_description'] = $this->request->getPost('short_description');
        $fields['description'] = $this->request->getPost('description');
        $fields['feature_details'] = $this->request->getPost('feature_details');
        $fields['video'] = $this->request->getPost('video');
        $fields['for_who'] = $this->request->getPost('for_who');
        $fields['for_why'] = $this->request->getPost('for_why');
        $fields['what_is_included'] = $this->request->getPost('what_is_included');
        $fields['syllabus'] = $this->request->getPost('syllabus');
        $fields['faq'] = $this->request->getPost('faq');


        $this->validation->setRules([
            'class_group_jnt_id' => ['label' => 'Class', 'rules' => 'required'],
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'short_description' => ['label' => 'Short Description', 'rules' => 'required'],
            'feature_details' => ['label' => 'Feature Details', 'rules' => 'required'],
            'video' => ['label' => 'video', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->class_descriptionModel->update($fields['class_des_id'],$fields)) {

                $response['success'] = true;
                $response['messages'] = 'Data has been update successfully';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Insertion error!';

            }

        }

        return $this->response->setJSON($response);
    }

    public function remove()
    {
        $response = array();

        $id = $this->request->getPost('class_des_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->class_descriptionModel->where('class_des_id', $id)->delete()) {

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
