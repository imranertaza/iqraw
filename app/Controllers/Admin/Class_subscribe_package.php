<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Class_group_joinedModel;
use App\Models\Class_subscribe_packageModel;
use App\Libraries\Permission;

class Class_subscribe_package extends BaseController
{
	
    protected $class_subscribe_packageModel;
    protected $class_group_joinedModel;
    protected $validation;
    protected $session;
    protected $permission;
    private $module_name = 'Class_subscribe_package';
	
	public function __construct()
	{
	    $this->class_subscribe_packageModel = new Class_subscribe_packageModel();
	    $this->class_group_joinedModel = new Class_group_joinedModel();
       	$this->validation =  \Config\Services::validation();
       	$this->session = \Config\Services::session();
       	$this->permission = new Permission();
		
	}
	
	public function index()
	{
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Class_subscribe_package';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Class_subscribe_package/list', $data);
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
 
		$result =$this->class_subscribe_packageModel->findAll();
		
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->class_subscription_package_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->class_subscription_package_id . ')"><i class="fa fa-trash"></i></button>';
            }
			$ops .= '</div>';
			
			$data['data'][$key] = array(
				$value->class_subscription_package_id,
				$value->name,
                get_data_by_id('name','class','class_id',$value->class_id),
                get_data_by_id('group_name','class_group','class_group_id',$value->class_group_id),
                get_data_by_id('type_name','education_type','edu_type_id',$value->edu_type_id),
				$value->m_fee,
				$value->start_date,
				$value->end_date,
				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('class_subscription_package_id');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data =$this->class_subscribe_packageModel->where('class_subscription_package_id' ,$id)->first();
			
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
        $fields['edu_type_id'] = empty($this->request->getPost('edu_type_id')) ? null : $this->request->getPost('edu_type_id');
        $fields['m_fee'] = $this->request->getPost('m_fee');
        $fields['start_date'] = $this->request->getPost('start_date');
        $fields['end_date'] = $this->request->getPost('end_date');
        $fields['short_description'] = $this->request->getPost('short_description');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'm_fee' => ['label' => 'Fee', 'rules' => 'required'],
            'start_date' => ['label' => 'Start date', 'rules' => 'required'],
            'end_date' => ['label' => 'End date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {
            if ($this->class_subscribe_packageModel->insert($fields)) {

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
		
        $fields['class_subscription_package_id'] = $this->request->getPost('class_subscription_package_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['class_group_id'] = empty($this->request->getPost('class_group_id')) ? null : $this->request->getPost('class_group_id');
        $fields['edu_type_id'] = empty($this->request->getPost('edu_type_id')) ? null : $this->request->getPost('edu_type_id');
        $fields['m_fee'] = $this->request->getPost('m_fee');
        $fields['start_date'] = $this->request->getPost('start_date');
        $fields['short_description'] = $this->request->getPost('short_description');
        $fields['end_date'] = $this->request->getPost('end_date');


        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'm_fee' => ['label' => 'Fee', 'rules' => 'required'],
            'start_date' => ['label' => 'Start date', 'rules' => 'required'],
            'end_date' => ['label' => 'End date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->class_subscribe_packageModel->update($fields['class_subscription_package_id'], $fields)) {
				
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
		
		$id = $this->request->getPost('class_subscription_package_id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->class_subscribe_packageModel->where('class_subscription_package_id', $id)->delete()) {
								
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

        $class_id = $this->request->getPost('class_id');

        $query = $this->class_group_joinedModel->where('class_id',$class_id)->findAll();
        $view ='<option value="">Class Group</option>';
        if (!empty($query)){
            foreach ($query as $val){
                $groupName = get_data_by_id('group_name','class_group','class_group_id',$val->class_group_id);
                $view.='<option value="'.$val->class_group_id.'">'.$groupName.'</option>';
            }
        }

        print $view;
    }

    public function filter(){
        $class_group_id = $this->request->getPost('class_group_id');
        $class_id = $this->request->getPost('class_id');
        if (!empty($class_group_id)) {
            $this->class_subscribe_packageModel->like('class_group_id', $class_group_id);
        }
        $data = $this->class_subscribe_packageModel->like('class_id' ,$class_id)->findAll();

        $view ='no data available';
        $view ='<thead>
            <tr>
                <th width="60">Id</th>
                <th>Name</th>
                <th>Class</th>
                <th>Group</th>
                <th>Education Type</th>
                <th>Fee</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Action</th>
            </tr>
            </thead>';
        foreach ($data as $val) {

            $view .= '<tr>
                    <td>'.$val->class_subscription_package_id.'</td>
                    <td>'.$val->name.'</td>
                    <td>'.get_data_by_id('name','class','class_id',$val->class_id).'</td>
                    <td>'.get_data_by_id('group_name','class_group','class_group_id',$val->class_group_id).'</td>
                    <td>'.get_data_by_id('type_name','education_type','edu_type_id',$val->edu_type_id).'</td>
                    <td>'.$val->m_fee.'</td>
                    <td>'.$val->start_date.'</td>
				    <td>'.$val->end_date.'</td>
                    <td>
                    <div class="btn-group">	
                    <button type="button" class="btn btn-sm btn-info" onclick="edit(' . $val->class_subscription_package_id . ')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $val->class_subscription_package_id . ')"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
            </tr>';
        }

        print $view;
    }
		
}	