<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Class_group_joinedModel;
use App\Models\Group_classModel;
use App\Models\SubjectModel;


class Subject extends BaseController
{
    protected $validation;
    protected $session;
    protected $subjectModel;
    protected $group_classModel;
    protected $class_group_joinedModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Subject';

    public function __construct()
    {
        $this->subjectModel = new SubjectModel();
        $this->class_group_joinedModel = new Class_group_joinedModel();
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
            $data['controller'] = 'Admin/Subject';
            $data['group'] = $this->group_classModel->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Subject/subject', $data);
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

        $result = $this->subjectModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->subject_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->subject_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->subject_id,
                $value->name,
                get_data_by_id('name', 'class', 'class_id', $value->class_id),
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('subject_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->subjectModel->where('subject_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['name'] = $this->request->getPost('name');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['class_group_id'] = empty($this->request->getPost('class_group_id')) ? null : $this->request->getPost('class_group_id');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->subjectModel->insert($fields)) {

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

        $subject_id = $this->request->getPost('subject_id');

        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['class_group_id'] = empty($this->request->getPost('class_group_id')) ? null : $this->request->getPost('class_group_id');
        $fields['status'] = $this->request->getPost('status');


        $this->validation->setRules([
            'subject_id' => ['label' => 'Class', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->subjectModel->update($fields['subject_id'], $fields)) {

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

        $id = $this->request->getPost('subject_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->subjectModel->where('subject_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function get_class_group(){
        $id = $this->request->getPost('class_id');

        $classGroJoin = $this->class_group_joinedModel->where('class_id',$id)->findAll();

        $view = '<option value="">Please select</option>';
        if (!empty($classGroJoin)){
            foreach ($classGroJoin as $val) {
                $clName = get_data_by_id('group_name','class_group','class_group_id',$val->class_group_id);

                $view .='<option value="'.$val->class_group_id.'">'.$clName.'</option>';
            }
        }
        print $view;
    }

    public function filter(){
        $class_group_id = $this->request->getPost('class_group_id');
        $class_id = $this->request->getPost('class_id');
        $data = $this->subjectModel->like('class_group_id' ,$class_group_id)->like('class_id' ,$class_id)->findAll();
        $view ='';
        foreach ($data as $val) {

            $view .= '<tr>
                    <td>'.$val->subject_id.'</td>
                    <td>'.$val->name.'</td>
                    <td>'.get_data_by_id('name','class','class_id',$val->class_id).'</td>
                    <td>'.statusView($val->status).'</td>
                    <td>
                    <div class="btn-group">	
                    <button type="button" onclick="edit(' . $val->subject_id . ')" type="button" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>	
                    <button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $val->subject_id . ')"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
            </tr>';
        }

        print $view;
    }
}
