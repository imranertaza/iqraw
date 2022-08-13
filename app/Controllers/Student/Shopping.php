<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\History_user_coin_Model;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductModel;
use App\Models\StudentModel;


class Shopping extends BaseController
{
    protected $validation;
    protected $session;
    protected $productModel;
    protected $productCategoryModel;
    protected $cart;
    protected $orderModel;
    protected $orderItemModel;
    protected $studentModel;
    protected $history_user_coin_Model;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->studentModel = new StudentModel();
        $this->history_user_coin_Model = new History_user_coin_Model();
        $this->cart = \Config\Services::cart();
        $this->productCategoryModel = new ProductCategoryModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/');
            $data['cart_url'] = base_url('/Student/Shopping/cart');
            $data['category_url'] = base_url('/Student/Shopping/category');
            $data['page_title'] = 'Shopping';
            $data['footer_icon'] = 'Shopping';

            $gen = get_data_by_id('gender', 'student', 'std_id', $this->session->std_id);
            $gender = ($gen == 'Male') ? 'Women' : 'Man';

            $data['product'] = $this->productModel->where('gender_type !=', $gender)->findAll();


            echo view('Student/shopping_header', $data);
            echo view('Student/shopping', $data);
            echo view('Student/footer');
        }
    }

    public function category($id)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/');
            $data['cart_url'] = base_url('/Student/Shopping/cart');
            $data['category_url'] = base_url('/Student/Shopping/category');
            $data['page_title'] = 'Shopping';
            $data['footer_icon'] = 'Shopping';

            $gen = get_data_by_id('gender', 'student', 'std_id', $this->session->std_id);
            $gender = ($gen == 'Male') ? 'Women' : 'Man';

            $proCat = $this->productCategoryModel->where('parent_pro_cat_id', $id)->findAll();
            $data['product'] = array();
            foreach ($proCat as $cat) {
                $product = $this->productModel->where('prod_cat_id', $cat->prod_cat_id)->where('products.gender_type !=', $gender)->findAll();
                foreach ($product as $key => $pro) {
                    array_push($data['product'], $pro);
                }
            }

            echo view('Student/shopping_header', $data);
            echo view('Student/shopping', $data);
            echo view('Student/footer');
        }
    }

    public function details($id)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Shopping');
            $data['cart_url'] = base_url('/Student/Shopping/cart');
            $data['page_title'] = 'Product';
            $data['footer_icon'] = 'Shopping';

            $data['product'] = $this->productModel->where('prod_id', $id)->first();


            echo view('Student/shopping_header', $data);
            echo view('Student/product_details', $data);
            echo view('Student/footer');
        }
    }

    public function addToCart()
    {

        $proId = $this->request->getPost('proId');

        $product = $this->productModel->find($proId);
        $this->cart->insert(array(
            'id' => $product->prod_id,
            'qty' => 1,
            'price' => $product->price,
            'name' => $product->name,
        ));
        return 'Add to cart success';
    }

    public function updatePlus()
    {

        $rowid = $this->request->getPost('proId');
        $oldQty = $this->cart->getItem($rowid);
        $proOldQty = get_data_by_id('quantity', 'products', 'prod_id', $oldQty['id']);
        if ($proOldQty >= $oldQty['qty']) {
            $this->cart->update(array(
                'rowid' => $rowid,
                'qty' => $oldQty['qty'] + 1,
            ));
            $msg = 'Update to cart success';
        } else {
            $msg = 'Input quantity is too large';
        }

        return $msg;
    }

    public function updateMinus()
    {

        $rowid = $this->request->getPost('proId');
        $oldQty = $this->cart->getItem($rowid);
        $proOldQty = get_data_by_id('quantity', 'products', 'prod_id', $oldQty['id']);
        $total = $oldQty['qty'] - 1;
        if ($proOldQty >= $oldQty['qty']) {
            if ($total != 0) {
                $this->cart->update(array(
                    'rowid' => $rowid,
                    'qty' => $total,
                ));
            } else {
                $this->cart->remove($rowid);
            }
            $msg = 'Update to cart success';
        } else {
            $msg = 'Input quantity is too large';
        }

        return $msg;
    }

    public function search()
    {
        $keyWord = $this->request->getPost('keyWord');

        $gen = get_data_by_id('gender', 'student', 'std_id', $this->session->std_id);
        $gender = ($gen == 'Male') ? 'Women' : 'Man';
        $table = DB()->table('products');
        $product = $table->where('gender_type !=', $gender)->like('name', $keyWord)->get()->getResult();

        $view = '';
        foreach ($product as $pro) {
            $url = base_url('/Student/Shopping/details/' . $pro->prod_id);
            $img = no_image_view('/assets/upload/product/' . $pro->prod_id . '/' . $pro->picture, '/assets/upload/product/no_img.svg', $pro->picture);
            $view .= '<div class="col-6">
                    <a href="' . $url . '">
                        <img src="' . $img . '"
                             alt="pro-img" class="pro-img">
                        <img src="' . base_url() . '/assets/image/cart-plus.svg" alt="icon" class="icon">
                        <p class="pro-p">' . $pro->price . '৳ </p>
                        <p class="pro-p-t">' . $pro->name . '</p>
                    </a>
                </div>';
        }

        print $view;
    }

    public function cart()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Shopping');
            $data['cart_url'] = base_url('/Student/Shopping/cart');
            $data['footer_icon'] = 'Shopping';

            echo view('Student/shopping_header', $data);
            echo view('Student/cart', $data);
            echo view('Student/footer');
        }
    }

    public function checkout()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Shopping/cart');
            $data['cart_url'] = base_url('/Student/Shopping/cart');
            $data['footer_icon'] = 'Shopping';

            echo view('Student/shopping_header', $data);
            echo view('Student/checkout', $data);
            echo view('Student/footer');
        }
    }

    public function buy_action()
    {
        $payment = $this->request->getPost('btnradio');
        $cart = $this->cart->contents();

        $total = $this->cart->total();
        $std_id = $this->session->std_id;

        DB()->transStart();

        if ( !empty($payment) && $payment == 1){
            $pymnt_method_id = 1;
        }else{
            $pymnt_method_id = 2;
        }
            $orData = [
                'std_id' => $std_id,
                'pymnt_method_id' => $pymnt_method_id,
                'amount' => $total,
                'final_amount' => $total,
                'status' => '2',
                'createdBy' => $std_id,
            ];
            $this->orderModel->insert($orData);
            $orderId = $this->orderModel->getInsertID();

            foreach ($cart as $item) {
                $subTotl = $item['price'] * $item['qty'];

                //product Qty update
                $oldproQty = get_data_by_id('quantity', 'products', 'prod_id', $item['id']);
                $newQty['quantity'] = $oldproQty - $item['qty'];
                $this->productModel->update($item['id'], $newQty);

                //order item insert
                $dataOrItem = [
                    'order_id' => $orderId,
                    'prod_id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'total_price' => $subTotl,
                    'final_price' => $subTotl,
                    'createdBy' => $std_id,
                ];
                $this->orderItemModel->insert($dataOrItem);

            }

        if ( !empty($payment) && $payment == 1){

            $oldcoin = get_data_by_id('coin','student','std_id',$std_id);
            $restCoin = $oldcoin - $total;

            //coin update
            $coinData = array('coin' => $restCoin,);
            $this->studentModel->update($std_id,$coinData);

            //history coin insert
            $historyData = array(
                'std_id' => $std_id,
                'order_id' => $orderId,
                'particulars' => 'Order product cost',
                'trangaction_type' => 'Dr.',
                'amount' => $total,
                'rest_balance' => $restCoin,
            );
            $this->history_user_coin_Model->insert($historyData);
        }

        DB()->transComplete();

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Your order has been confirmed <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
        $this->cart->destroy();
        return redirect()->to(site_url('/Student/Shopping/invoice/'.$orderId));

    }

    public function invoice($id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Shopping/order_list');
            $data['cart_url'] = base_url('/Student/Shopping/cart');
            $data['page_title'] = 'Invoice';
            $data['footer_icon'] = 'Shopping';

            $data['order'] = $this->orderModel->find($id);
            $data['orderItem'] = $this->orderItemModel->where('order_id',$id)->findAll();

            echo view('Student/header', $data);
            echo view('Student/invoice', $data);
            echo view('Student/footer');
        }
    }

    public function order_list(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Shopping/');
            $data['cart_url'] = base_url('/Student/Shopping/cart');
            $data['page_title'] = 'Order list';
            $data['footer_icon'] = 'Shopping';

            $data['order'] = $this->orderModel->findAll();

            echo view('Student/header', $data);
            echo view('Student/order_list', $data);
            echo view('Student/footer');
        }
    }


}


