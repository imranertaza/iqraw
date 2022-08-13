<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\StoreModel;

class Order extends BaseController
{
	
    protected $orderModel;
    protected $orderItemModel;
    protected $validation;
    protected $session;
    protected $permission;
    private $module_name = 'Order';
	
	public function __construct()
	{
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
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
            $data['controller'] = 'Admin/Order';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Order/order', $data);
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
 
		$result = $this->orderModel->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
            if ($perm['read'] ==1) {
                $ops .= '	<a href="'.base_url().'/Admin/Order/invoice/'.$value->order_id.'" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>';
            }
			$ops .= '</div>';
			
			$data['data'][$key] = array(
				$value->order_id,
				get_data_by_id('name','student','std_id',$value->std_id),
				$value->amount,
				$value->final_amount,
                invoiceStatusView($value->status),
				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}

	public function invoice($id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Order';
            $data['order'] = $this->orderModel->find($id);
            $data['orderItem'] = $this->orderItemModel->where('order_id',$id)->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Order/invoice', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function orderStatusUpdate(){
        $response = array();
        $order_id = $this->request->getPost('orderId');
        $fields['status'] = $this->request->getPost('status');
        if ($this->orderModel->update($order_id, $fields)) {

            $response['success'] = true;
            $response['messages'] = 'Status has been updated successfully';

        } else {

            $response['success'] = false;
            $response['messages'] = 'Insertion error!';

        }

        return $this->response->setJSON($response);
    }
	

		
}	