<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\Class_descriptionModel;
use App\Models\Class_group_joinedModel;
use App\Models\Class_subscribe_packageModel;
use App\Models\Class_subscribeModel;

class Class_subscribe extends BaseController
{
    protected $validation;
    protected $class_descriptionModel;
    protected $class_subscribe_packageModel;
    protected $class_group_joinedModel;
    protected $class_subscribeModel;
    protected $session;

    public function __construct(){
        $this->class_descriptionModel = new Class_descriptionModel();
        $this->class_subscribe_packageModel = new Class_subscribe_packageModel();
        $this->class_group_joinedModel = new Class_group_joinedModel();
        $this->class_subscribeModel = new Class_subscribeModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index(){
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            $subscrib = $this->class_subscribeModel->join('class_subscribe_package', 'class_subscribe_package.class_subscription_package_id = class_subscribe.class_subscription_package_id')->where('class_subscribe.std_id',$this->session->std_id)->where('class_subscribe.status','1')->where('class_subscribe_package.end_date >=',date('Y-m-d'))->countAllResults();

            if (empty($subscrib)) {

                $classId = get_data_by_id('class_id', 'student', 'std_id', $this->session->std_id);
                $classGroupId = get_data_by_id('class_group_id', 'student', 'std_id', $this->session->std_id);

                $wArray = "(`class_group_id` IS NULL OR `class_group_id` = '$classGroupId')";

                $data['pack'] = $this->class_subscribe_packageModel->where('class_id', $classId)->where($wArray)->where('end_date >=', date('Y-m-d'))->findAll();

                $table2 = DB()->table('student');
                $data['std_info'] = $table2->where('std_id', $this->session->std_id)->get()->getRow();


                echo view('Web/header');
                echo view('Web/class_subscribe',$data);
                echo view('Web/footer');
            }else{
                return redirect()->to(site_url("Web/Dashboard"));
            }
        }
    }

    public function sub_action(){

        unset($_SESSION['packId']);
        unset($_SESSION['redirect_url']);


        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $data['class_subscription_package_id'] = $this->request->getPost('opt_a');
        $data['std_id'] = $this->request->getPost('opt_b');
        $data['std_name'] = $this->request->getPost('cus_name');
        $terms = $this->request->getPost('opt_c');

        $paid_amount = (float) $this->request->getPost('amount');
        $class_subscription_amount = (float) get_data_by_id('m_fee', 'class_subscribe_package', 'class_subscription_package_id', $data['class_subscription_package_id']);

        if (!empty($pay_status == 'Successful')) {
            $sessionArray = array(
                'std_id' => $data['std_id'],
                'name' => $data['std_name'],
                'isLoggedInWeb' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (Start)

        // Checking if the paid amount is correct with course amount
        if ($paid_amount !== $class_subscription_amount){
            return redirect()->to('Web/Class_subscribe');
        }

        // Check login status before execution
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            //Checking if it checks our terms and condition.
            if (!empty($terms)) {
                DB()->transStart();
                // Inserting data to class_subscribe table
                $endDate = date("Y-m-d", strtotime("+30 days"));
                //$data['class_subscription_package_id'] = $this->request->getPost('class_subscription_package_id');
                $data['std_id'] = $this->session->std_id;
                $data['subs_time'] = '1';
                $data['subs_end_date'] = $endDate;
                $data['status'] = '1';
                $data['createdBy'] = $this->session->std_id;

                $this->class_subscribeModel->insert($data);

                $class_subscribe_id = $this->class_subscribeModel->getInsertID();

                // Inserting into payment table as history(Start)
                $data2['class_subscribe_id'] = empty($class_subscribe_id) ? null : $class_subscribe_id;
                $data2['std_id'] = empty($this->session->std_id) ? null : $this->session->std_id;
                $data2['aam_service_charge'] = $this->request->getPost('pg_service_charge_bdt');
                $data2['amount_original'] = $this->request->getPost('amount_original');
                $data2['pay_status'] = $this->request->getPost('pay_status');
                $data2['aam_txnid'] = $this->request->getPost('pg_txnid');
                $data2['mer_txnid'] = $this->request->getPost('mer_txnid');
                $data2['store_amount'] = $this->request->getPost('store_amount');

                $table2 = DB()->table('payment');
                $table2->insert($data2);
                // Inserting into payment table (End)
                DB()->transComplete();

                // If sql transaction failed.
                if (DB()->transStatus() === false) {
                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Transection Failed!</div>');
                    return redirect()->to('/Web/Class_subscribe/canceled');
                }

                return redirect()->to('/Web/Class_subscribe/success');
            }else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Terms fields required!</div>');
                return redirect()->to('Web/Class_subscribe');
            }
        }
    }

    public function success(){
        echo view('Web/header');
        echo view('Web/class_subscribe_success');
        echo view('Web/footer');
    }

    public function canceled(){
        echo view('Web/header');
        echo view('Web/class_subscribe_canceled');
        echo view('Web/footer');
    }

}
