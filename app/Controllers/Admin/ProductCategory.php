<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\ProductCategoryModel;
use App\Libraries\Permission;

class ProductCategory extends BaseController
{
	
    protected $productCategoryModel;
    protected $validation;
    protected $session;
    protected $permission;
    private $module_name = 'ProductCategory';
	
	public function __construct()
	{
	    $this->productCategoryModel = new ProductCategoryModel();
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
            $data['controller'] = 'Admin/ProductCategory';

            $data['category'] = $this->productCategoryModel->where('parent_pro_cat_id',0)->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/ProductCategory/productCategory', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
			
	}

	public function getAll()
	{
 		$response = array();		
		
	    $data['data'] = array();
 
		$result = $this->productCategoryModel->select('prod_cat_id, parent_pro_cat_id, product_category, image, status, createdDtm, createdBy, updatedDtm, updatedBy, deleted, deletedRole')->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit('. $value->prod_cat_id .')"><i class="fa fa-edit"></i></button>';
			$ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove('. $value->prod_cat_id .')"><i class="fa fa-trash"></i></button>';
			$ops .= '</div>';
			
			$data['data'][$key] = array(
				$value->prod_cat_id,
                $value->product_category,
                pro_parent_category_by_category_id($value->parent_pro_cat_id),
                statusView($value->status),

				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('prod_cat_id');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->productCategoryModel->where('prod_cat_id' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			
			throw new \CodeIgniter\Exceptions\PageNotFoundException();

		}	
		
	}	
	
	public function add()
	{

        $response = array();
        $id = $this->session->user_id;

        $fields['parent_pro_cat_id'] = $this->request->getPost('parentProCatId');
        $fields['product_category'] = $this->request->getPost('productCategory');
        $fields['status'] = $this->request->getPost('status');
        $fields['createdBy'] = $id;


        $this->validation->setRules([
            'product_category' => ['label' => 'Product category', 'rules' => 'required|max_length[155]'],
            'status' => ['label' => 'Status', 'rules' => 'required'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->productCategoryModel->insert($fields)) {
												
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
        $id = $this->session->user_id;
        $fields['prod_cat_id'] = $this->request->getPost('prodCatId');
        $fields['parent_pro_cat_id'] = $this->request->getPost('parentProCatId');
        $fields['product_category'] = $this->request->getPost('productCategory');
        $fields['status'] = $this->request->getPost('status');
        $fields['updatedBy'] = $id;


        $this->validation->setRules([
            'product_category' => ['label' => 'Product category', 'rules' => 'required|max_length[155]'],
            'status' => ['label' => 'Status', 'rules' => 'required'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->productCategoryModel->update($fields['prod_cat_id'], $fields)) {
				
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
		
		$id = $this->request->getPost('prod_cat_id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->productCategoryModel->where('prod_cat_id', $id)->delete()) {
								
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