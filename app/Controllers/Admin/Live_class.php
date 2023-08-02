<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\ChatRoomModel;
use App\Models\Live_class_Model;
use App\Models\Class_group_joinedModel;
use App\Libraries\Permission;
use App\Models\LiveChatHistoryModel;

class Live_class extends BaseController
{
	
    protected $Live_class_Model;
    protected $validation;
    protected $session;
    protected $permission;
    private $module_name = 'Liveclass';
    private $class_group_joinedModel;
    protected $liveChatHistoryModel;
    protected $chatRoomModel;

    public function __construct()
	{
	    $this->Live_class_Model = new Live_class_Model();
       	$this->validation =  \Config\Services::validation();
       	$this->session = \Config\Services::session();
       	$this->permission = new Permission();
       	$this->class_group_joinedModel = new Class_group_joinedModel();
        $this->liveChatHistoryModel = new LiveChatHistoryModel();
        $this->chatRoomModel = new ChatRoomModel();

	}


	public function index()
	{
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Live_class';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Live_class/live_class', $data);
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
 
		$result =$this->Live_class_Model->findAll();
		
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->live_id . ')"><i class="fa fa-trash"></i></button>';
            }
			$ops .= '</div>';

            $viewLink = '<a href="'.base_url().'/Admin/Live_class/Manage/'.$value->live_id.'">View</a>';

			$data['data'][$key] = array(
                get_data_by_id('name','class','class_id',$value->class_id),
                get_data_by_id('group_name','class_group','class_group_id',$value->class_group_id),
                $value->youtube_code,
                $value->live_status,
                $viewLink,
				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function add()
	{

        $response = array();

        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['class_group_id'] = !empty($this->request->getPost('class_group_id')) ? $this->request->getPost('class_group_id') : null;
        $fields['youtube_code'] = $this->request->getPost('youtube_url');

        $this->validation->setRules([
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'youtube_code' => ['label' => 'Youtube Code', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->Live_class_Model->insert($fields)) {

                $response['success'] = true;
                $response['messages'] = 'Live Class has been started successfully';
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
		
		$id = $this->request->getPost('live_id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		    // Delete all chat history of this live
            $this->liveChatHistoryModel->where('live_id', $id)->delete();
            $this->chatRoomModel->where('live_id', $id)->delete();

			if ($this->Live_class_Model->delete($id)) {
								
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

//    public function Manage($class_id, $classGroupId=null){
    public function Manage($live_id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Live_class';
            $data['live_id'] = $live_id;
            $data['chats'] = $this->liveChatHistoryModel->where('live_id', $data['live_id'])->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Live_class/manage', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }
		
}	