<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Chapter_exam_joinedModel;
use App\Models\Mcq_exam_joinedModel;
use App\Models\Quiz_exam_joinedModel;
use App\Models\StudentModel;
use App\Models\Vocabulary_exam_joinedModel;


class Student extends BaseController
{
    protected $validation;
    protected $session;
    protected $student;
    protected $chapter_exam_joinedModel;
    protected $mcq_exam_joinedModel;
    protected $vocabulary_exam_joinedModel;
    protected $quiz_exam_joinedModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Student';
    public function __construct()
    {
        $this->student = new StudentModel();
        $this->chapter_exam_joinedModel = new Chapter_exam_joinedModel();
        $this->mcq_exam_joinedModel = new Mcq_exam_joinedModel();
        $this->vocabulary_exam_joinedModel = new Vocabulary_exam_joinedModel();
        $this->quiz_exam_joinedModel = new Quiz_exam_joinedModel();
        $this->permission = new Permission();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
    }
    public function index(){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        $role = $this->session->admin_role;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        }else {
            $data['controller'] = 'Admin/Student';

            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role,$this->module_name);

            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] ==1) {
                echo view('Admin/Student/student', $data);
            }else{
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

        $result = $this->student->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['read'] == 1) {
                $ops .= '	<a href="' . base_url() . '/Admin/Student/view/' . $value->std_id . '" type="button" class="btn btn-sm btn-primary" ><i class="fa fa-eye"></i></a>';
            }
            if ($perm['update'] == 1) {
                $ops .= '	<a href="' . base_url() . '/Admin/Student/update/' . $value->std_id . '" type="button" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></a>';
            }
            if ($perm['delete'] == 1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->std_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->std_id,
                $value->name,
                $value->phone,
                $value->school_name,
                get_data_by_id('name','class','class_id',$value->class_id),
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('std_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->student->where('std_id' ,$id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['name'] = $this->request->getPost('name');
        $fields['father_name'] = $this->request->getPost('father_name');
        $fields['address'] = $this->request->getPost('address');
        $fields['school_name'] = $this->request->getPost('school_name');
        $fields['gender'] = $this->request->getPost('gender');
        $fields['religion'] = $this->request->getPost('religion');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['age'] = $this->request->getPost('age');
        $fields['phone'] = $this->request->getPost('phone');
        $fields['password'] = SHA1($this->request->getPost('password'));
        $fields['institute'] = $this->request->getPost('institute');
        $fields['class_group'] = $this->request->getPost('class_group');
        $fields['createdBy'] = '1';

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'father_name' => ['label' => 'Father Name', 'rules' => 'required'],
            'address' => ['label' => 'Address', 'rules' => 'required'],
            'school_name' => ['label' => 'School Name', 'rules' => 'required'],
            'gender' => ['label' => 'Gender', 'rules' => 'required'],
            'religion' => ['label' => 'Religion', 'rules' => 'required'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'age' => ['label' => 'Age', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'institute' => ['label' => 'Institute', 'rules' => 'required'],
            'class_group' => ['label' => 'Class Group', 'rules' => 'required'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->student->insert($fields)) {

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

        $h_id = $this->request->getPost('h_id');

        $fields['lic_id'] = $this->request->getPost('lic_id');
        $fields['h_id'] = $this->request->getPost('h_id');
        $fields['start_date'] = $this->request->getPost('start_date');
        $fields['end_date'] = $this->request->getPost('end_date');


        $this->validation->setRules([
            'h_id' => ['label' => 'h_id', 'rules' => 'required'],
            'start_date' => ['label' => 'Start Date', 'rules' => 'required'],
            'end_date' => ['label' => 'End Date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->licenseModel->update($fields['lic_id'], $fields)) {

                $status = [
                    'status'=>'1',
                ];
                $tableUser = DB()->table('users');
                $tableUser->where('h_id',$h_id)->update($status);

                $tableHosp = DB()->table('hospital');
                $tableHosp->where('h_id',$h_id)->update($status);

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

        $id = $this->request->getPost('std_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->student->where('std_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function update($std_id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        }else {
            $data['student'] = $this->student->where('std_id' ,$std_id)->first();
            $data['controller'] = 'Admin/Student';


            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role,$this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['update'] ==1) {
                echo view('Admin/Student/student_update',$data);
            }else{
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function update_action(){
        $response = array();

        $std_id = $this->request->getPost('std_id');
        $pass = $this->request->getPost('password');
        if (!empty($pass)) {
            $fields['password'] = SHA1($this->request->getPost('password'));
        }
        $fields['std_id'] = $this->request->getPost('std_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['father_name'] = $this->request->getPost('father_name');
        $fields['address'] = $this->request->getPost('address');
        $fields['school_name'] = $this->request->getPost('school_name');
        $fields['gender'] = $this->request->getPost('gender');
        $fields['religion'] = $this->request->getPost('religion');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['age'] = $this->request->getPost('age');
        $fields['phone'] = $this->request->getPost('phone');
        $fields['institute'] = $this->request->getPost('institute');
        $fields['class_group'] = $this->request->getPost('class_group');
        $fields['status'] = $this->request->getPost('status');


        if (!empty($_FILES['pic']['name'])){
            $target_dir = FCPATH . 'assets/upload/profile/'.$std_id.'/';
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            //old image unlink
            $old_img = get_data_by_id('pic','student','std_id',$std_id);
            if (!empty($old_img)){
                unlink($target_dir.''.$old_img);
            }

            //new image uplode
            $pic = $this->request->getFile('pic');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir,$namePic);
            $pro_nameimg = 'pro_'.$pic->getName();
            $this->crop->withFile($target_dir.''.$namePic)->fit(80, 80, 'center')->save($target_dir.''.$pro_nameimg);
            unlink($target_dir.''.$namePic);
            $fields['pic'] = $pro_nameimg;
        }


        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'father_name' => ['label' => 'Father Name', 'rules' => 'required'],
            'address' => ['label' => 'Address', 'rules' => 'required'],
            'school_name' => ['label' => 'School Name', 'rules' => 'required'],
            'gender' => ['label' => 'Gender', 'rules' => 'required'],
            'religion' => ['label' => 'Religion', 'rules' => 'required'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'age' => ['label' => 'Age', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'institute' => ['label' => 'Institute', 'rules' => 'required'],
            'class_group' => ['label' => 'Class Group', 'rules' => 'required'],

        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->student->update($fields['std_id'], $fields)) {
                $response['success'] = true;
                $response['messages'] = 'Successfully updated';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Update error!';
            }
        }
        return $this->response->setJSON($response);
    }

    public function view($id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        }else {
            $data['student'] = $this->student->where('std_id' ,$id)->first();
            $data['controller'] = 'Admin/Student';


            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role,$this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['read'] ==1) {
                echo view('Admin/Student/student_red',$data);
            }else{
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function test($id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        }else {
            $data['student'] = $this->student->where('std_id' ,$id)->first();
            $data['controller'] = 'Admin/Student';

            $data['chapExam'] = $this->chapter_exam_joinedModel->where('std_id',$id)->findAll();
            $data['mcqExam'] = $this->mcq_exam_joinedModel->where('std_id',$id)->findAll();
            $data['vocExam'] = $this->vocabulary_exam_joinedModel->where('std_id',$id)->findAll();
            $data['quizExam'] = $this->quiz_exam_joinedModel->where('std_id',$id)->findAll();


            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role,$this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['read'] ==1) {
                echo view('Admin/Student/student_test',$data);
            }else{
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }




}
