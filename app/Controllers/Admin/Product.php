<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\BrandModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductModel;
use App\Libraries\Permission;
use App\Models\StoreModel;

class Product extends BaseController
{

    protected $productModel;
    protected $validation;
    protected $session;
    protected $permission;
    protected $productCategoryModel;
    protected $brandModel;
    protected $storeModel;
    protected $crop;
    private $module_name = 'Product';

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->permission = new Permission();
        $this->productCategoryModel = new ProductCategoryModel();
        $this->brandModel = new BrandModel();
        $this->storeModel = new StoreModel();
        $this->crop = \Config\Services::image();

    }

    public function index()
    {
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Product';

            $data['proCategory'] = $this->productCategoryModel->where('parent_pro_cat_id',0)->findAll();
            $data['brand'] = $this->brandModel->findAll();
            $data['store'] = $this->storeModel->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Product/product', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }


    }

    public function update($id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Product';

            $data['proCategory'] = $this->productCategoryModel->where('parent_pro_cat_id',0)->findAll();
            $data['brand'] = $this->brandModel->findAll();
            $data['store'] = $this->storeModel->findAll();
            $data['product'] = $this->productModel->where('prod_id', $id)->first();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['update'] == 1) {
                echo view('Admin/Product/update', $data);
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

        $result = $this->productModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
//            $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->prod_id . ')"><i class="fa fa-edit"></i></button>';
            $ops .= '<a href="'.base_url('Admin/Product/update/'.$value->prod_id).'" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></a>';
            $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->prod_id . ')"><i class="fa fa-trash"></i></button>';
            $ops .= '</div>';
            $pro = no_image_view('/assets/upload/product/'.$value->prod_id.'/'.$value->picture,'/assets/upload/product/no_img.svg',$value->picture);

            $data['data'][$key] = array(
                $value->prod_id,
                get_data_by_id('name','store','store_id',$value->store_id),
                $value->name,
                $value->price,
                $value->quantity,
                showUnitName($value->unit),
                get_data_by_id('name','brand','brand_id',$value->brand_id),
                '<img src="'.$pro.'" width="80">',
                get_data_by_id('product_category','product_category','prod_cat_id',$value->prod_cat_id),
                statusView($value->status),

                $ops,
            );
        }

        return $this->response->setJSON($data);
    }

    public function subcategory(){
        $id = $this->request->getPost('subId');
        $subCat = $this->productCategoryModel->where('parent_pro_cat_id',$id)->findAll();
        $view = '<option value="">Please Select</option>';
        foreach ($subCat as $item) {
            $view .= '<option value="'.$item->prod_cat_id.'">'.$item->product_category.'</option>';
        }
        return $view;

    }

    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('prod_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->productModel->where('prod_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();

        $fields['store_id'] = $this->request->getPost('storeId');
        $fields['name'] = $this->request->getPost('name');
        $fields['price'] = $this->request->getPost('price');
        $fields['quantity'] = $this->request->getPost('quantity');
        $fields['unit'] = $this->request->getPost('unit');
        $fields['brand_id'] = $this->request->getPost('brandId');
        $fields['prod_cat_id'] = $this->request->getPost('prodCatId');
        $fields['product_type'] = $this->request->getPost('productType');
        $fields['description'] = $this->request->getPost('description');
        $fields['gender_type'] = $this->request->getPost('gender_type');
        $fields['status'] = $this->request->getPost('status');





        $this->validation->setRules([
            'store_id' => ['label' => 'Store id', 'rules' => 'required|numeric|max_length[11]'],
            'name' => ['label' => 'Name', 'rules' => 'required|max_length[55]'],
            'quantity' => ['label' => 'Quantity', 'rules' => 'required|numeric|max_length[11]'],
            'unit' => ['label' => 'Unit', 'rules' => 'required|numeric|max_length[11]'],
            'prod_cat_id' => ['label' => 'Prod cat id', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->productModel->insert($fields)) {
                $proId = $this->productModel->getInsertID();

                if (!empty($_FILES['picture']['name'])) {

                    $target_dir = FCPATH . 'assets/upload/product/'.$proId.'/';
                    if(!file_exists($target_dir)){
                        mkdir($target_dir,0777);
                    }

                    $picture= $this->request->getFile('picture');
                    $name = $picture->getRandomName();
                    $picture->move($target_dir,$name);

                    $lo_nameimg = 'pro_'.$picture->getName();
                    $this->crop->withFile($target_dir.''.$name)->fit(172, 168, 'center')->save($target_dir.''.$lo_nameimg);
                    unlink($target_dir.''.$name);
                    $data['picture'] = $lo_nameimg;
                    $data['prod_id'] = $proId;

                    $this->productModel->update($data['prod_id'],$data);

                }

                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Insertion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function updateAction(){
        $response = array();

        $fields['prod_id'] = $this->request->getPost('prodId');
        $fields['store_id'] = $this->request->getPost('storeId');
        $fields['name'] = $this->request->getPost('name');
        $fields['price'] = $this->request->getPost('price');
        $fields['quantity'] = $this->request->getPost('quantity');
        $fields['unit'] = $this->request->getPost('unit');
        $fields['brand_id'] = $this->request->getPost('brandId');
        $fields['prod_cat_id'] = $this->request->getPost('prodCatId');
        $fields['product_type'] = $this->request->getPost('productType');
        $fields['description'] = $this->request->getPost('description');
        $fields['gender_type'] = $this->request->getPost('gender_type');
        $fields['status'] = $this->request->getPost('status');

        if (!empty($_FILES['picture']['name'])) {

            $target_dir = FCPATH . 'assets/upload/product/'.$fields['prod_id'].'/';
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            $picture= $this->request->getFile('picture');
            $name = $picture->getRandomName();
            $picture->move($target_dir,$name);

            $lo_nameimg = 'pro_'.$picture->getName();
            $this->crop->withFile($target_dir.''.$name)->fit(172, 168, 'center')->save($target_dir.''.$lo_nameimg);
            unlink($target_dir.''.$name);
            $fields['picture'] = $lo_nameimg;



        }

        $this->validation->setRules([
            'store_id' => ['label' => 'Store id', 'rules' => 'required|numeric|max_length[11]'],
            'name' => ['label' => 'Name', 'rules' => 'required|max_length[55]'],
            'quantity' => ['label' => 'Quantity', 'rules' => 'required|numeric|max_length[11]'],
            'unit' => ['label' => 'Unit', 'rules' => 'required|numeric|max_length[11]'],
            'prod_cat_id' => ['label' => 'Prod cat id', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'status' => ['label' => 'Status', 'rules' => 'required'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->productModel->update($fields['prod_id'], $fields)) {
                $response['success'] = true;
                $response['messages'] = 'Successfully updated';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Update error!';
            }
        }

        return $this->response->setJSON($response);
    }

    public function edit()
    {

        $response = array();

        $fields['prod_id'] = $this->request->getPost('prodId');
        $fields['store_id'] = $this->request->getPost('storeId');
        $fields['name'] = $this->request->getPost('name');
        $fields['quantity'] = $this->request->getPost('quantity');
        $fields['unit'] = $this->request->getPost('unit');
        $fields['brand_id'] = $this->request->getPost('brandId');
        $fields['picture'] = $this->request->getPost('picture');
        $fields['prod_cat_id'] = $this->request->getPost('prodCatId');
        $fields['product_type'] = $this->request->getPost('productType');
        $fields['description'] = $this->request->getPost('description');
        $fields['status'] = $this->request->getPost('status');
        $fields['createdDtm'] = $this->request->getPost('createdDtm');
        $fields['createdBy'] = $this->request->getPost('createdBy');
        $fields['updateDtm'] = $this->request->getPost('updateDtm');
        $fields['updatedBy'] = $this->request->getPost('updatedBy');
        $fields['deleted'] = $this->request->getPost('deleted');
        $fields['deletedRole'] = $this->request->getPost('deletedRole');


        $this->validation->setRules([
            'store_id' => ['label' => 'Store id', 'rules' => 'required|numeric|max_length[11]'],
            'name' => ['label' => 'Name', 'rules' => 'required|max_length[55]'],
            'quantity' => ['label' => 'Quantity', 'rules' => 'required|numeric|max_length[11]'],
            'unit' => ['label' => 'Unit', 'rules' => 'required|numeric|max_length[11]'],
            'brand_id' => ['label' => 'Brand id', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'picture' => ['label' => 'Picture', 'rules' => 'permit_empty|max_length[155]'],
            'prod_cat_id' => ['label' => 'Prod cat id', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'product_type' => ['label' => 'Product type', 'rules' => 'required'],
            'description' => ['label' => 'Description', 'rules' => 'permit_empty'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
            'createdDtm' => ['label' => 'CreatedDtm', 'rules' => 'required'],
            'createdBy' => ['label' => 'CreatedBy', 'rules' => 'required|numeric|max_length[11]'],
            'updateDtm' => ['label' => 'UpdateDtm', 'rules' => 'required'],
            'updatedBy' => ['label' => 'UpdatedBy', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'deleted' => ['label' => 'Deleted', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'deletedRole' => ['label' => 'DeletedRole', 'rules' => 'permit_empty|numeric|max_length[11]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->productModel->update($fields['prod_id'], $fields)) {

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

        $id = $this->request->getPost('prod_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->productModel->where('prod_id', $id)->delete()) {

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