<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Class_subscribe_packageModel;
use App\Models\Class_subscribeModel;


class Class_subscribe extends BaseController
{
    protected $validation;
    protected $session;
    protected $class_subscribeModel;
    protected $class_subscribe_packageModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Class_subscribe';

    public function __construct()
    {

        $this->class_subscribeModel = new Class_subscribeModel();
        $this->class_subscribe_packageModel = new Class_subscribe_packageModel();
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
            $data['controller'] = 'Admin/Class_subscribe';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Class_subscribe/list', $data);
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

        $result = $this->class_subscribeModel->findAll();

        foreach ($result as $key => $value) {

            $pack = $this->class_subscribe_packageModel->where('class_subscription_package_id',$value->class_subscription_package_id)->first();
            $class = get_data_by_id('class_id','class_subscribe_package','class_subscription_package_id',$value->class_subscription_package_id);
            $class_group_id = get_data_by_id('class_group_id','class_subscribe_package','class_subscription_package_id',$value->class_subscription_package_id);
            $ops = '<div class="btn-group">';
            $ops .= '<select class="form-control" onchange="subscribeStatusChange(this.value,'.$value->class_subscribe_id.')" name="status">'.globalStatus($value->status).'</select>';
//            if ($perm['update'] ==1) {
//                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->class_subscribe_id . ')"><i class="fa fa-edit"></i></button>';
//            }
//            if ($perm['delete'] ==1) {
//                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->class_subscribe_id . ')"><i class="fa fa-trash"></i></button>';
//            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->class_subscribe_id,
                get_data_by_id('name','student','std_id',$value->std_id),
                get_data_by_id('name','class','class_id',$class),
                get_data_by_id('group_name','class_group','class_group_id',$class_group_id),
                $pack->name,
                $pack->m_fee,
                $pack->end_date,
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
        $fields['class_id'] = empty($this->request->getPost('class_id')) ? null : $this->request->getPost('class_id');
        $fields['class_group_id'] = empty($this->request->getPost('class_group_id')) ? null : $this->request->getPost('class_group_id');
        $fields['createdBy'] = $this->session->user_id;
        $image = $this->request->getFile('image');

        if (!empty($_FILES['image']['name'])) {
            // thumb image uploading section (start)
            $target_dir = FCPATH . 'assets/upload/course/';
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            $name = $image->getRandomName();
            $image->move($target_dir, $name);

            // Image cropping of the uploaded image
            $nameimg = 'course_' . $image->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $nameimg);
            $this->crop->withFile($target_dir . '' . $name)->fit(1116 ,500, 'center')->save($target_dir . '' . 'big_'.$nameimg);
            unlink($target_dir . '' . $name);

            $fields['image'] = $nameimg;
        }

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
        $fields['class_id'] = empty($this->request->getPost('class_id')) ? null : $this->request->getPost('class_id');
        $fields['class_group_id'] = empty($this->request->getPost('class_group_id')) ? null : $this->request->getPost('class_group_id');
        $image = $this->request->getFile('image');

        if (!empty($_FILES['image']['name'])) {
            // thumb image uploading section (start)
            $target_dir = FCPATH . 'assets/upload/course/';
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            $name = $image->getRandomName();
            $image->move($target_dir, $name);

            // Image cropping of the uploaded image
            $nameimg = 'course_' . $image->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $nameimg);
            $this->crop->withFile($target_dir . '' . $name)->fit(1116 ,500, 'center')->save($target_dir . '' . 'big_'.$nameimg);
            unlink($target_dir . '' . $name);

            $fields['image'] = $nameimg;
        }

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

    public function filter(){
        $st_date = $this->request->getPost('st_date');
        $end_date = $this->request->getPost('end_date');
        $data = $this->class_subscribeModel->like('createdDtm' ,$st_date)->like('subs_end_date' ,$end_date)->findAll();
        $view ='no data available';
        $view ='<thead>
            <tr>
                <th>Id</th>
                <th>Student</th>
                <th>Class</th>
                <th>Class Group</th>
                <th>Package</th>
                <th>Price</th>
                <th>Subscribe End Date</th>
                <th>status</th>
            </tr>
            </thead>';
        foreach ($data as $val) {
            $class = get_data_by_id('class_id','class_subscribe_package','class_subscription_package_id',$val->class_subscription_package_id);
            $class_group_id = get_data_by_id('class_group_id','class_subscribe_package','class_subscription_package_id',$val->class_subscription_package_id);
            $view .= '<tr>
                    <td>'.$val->class_subscribe_id.'</td>
                    <td>'.get_data_by_id('name','student','std_id',$val->std_id).'</td>
                    <td>'.get_data_by_id('name','class','class_id',$class).'</td>
                    <td>'.get_data_by_id('group_name','class_group','class_group_id',$class_group_id).'</td>
                    <td>'.$val->subs_end_date.'</td>
                    <td>'.statusView($val->status).'</td>
            </tr>';
        }

        print $view;
    }

    public function subscribe_status(){
        $response = array();

        $status = $this->request->getPost('status');
        $subscribe_id = $this->request->getPost('subscribe_id');

        if ($status == 1) {
            $data['status'] = '1';
            $table = DB()->table('class_subscribe');
            $table->where('class_subscribe_id',$subscribe_id)->update($data);


            $dataPay['pay_status'] = 'Successful';
            $tablePay = DB()->table('payment');
            $tablePay->where('class_subscribe_id',$subscribe_id)->update($dataPay);

            $response['success'] = true;
            $response['messages'] = 'Successfully Active';
        }else{
            $data['status'] = '0';
            $table = DB()->table('class_subscribe');
            $table->where('class_subscribe_id',$subscribe_id)->update($data);

            $response['success'] = true;
            $response['messages'] = 'Successfully Inactive';
        }




        return $this->response->setJSON($response);



    }


}
