<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    private $session;

    public function __construct(){
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index($course_id){
        $sessionpay = array(
            'pay_course_id' => $course_id,
            'redirect_url' => '/Web/Home/payment/'.$course_id,
        );
        $this->session->set($sessionpay);

        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            $check = check_subscribe_by_course_id($course_id);
            if ($check == 1){
                unset($_SESSION['pay_course_id']);
                unset($_SESSION['redirect_url']);
                return redirect()->to(site_url('/Web/Dashboard/course/'.$course_id));
            }else {

                $table = DB()->table('course');
                $data['course'] = $table->where('course_id', $course_id)->get()->getRow();

                $table2 = DB()->table('student');
                $data['std_info'] = $table2->where('std_id', $this->session->std_id)->get()->getRow();

                echo view('Web/header');
                echo view('Web/course_pay', $data);
                echo view('Web/footer');
            }
        }
    }

    public function payment_success_action(){
        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $std_id = $this->request->getPost('opt_b');
        $std_name = $this->request->getPost('cus_name');
        if (!empty($pay_status == 'Successful')) {
            $sessionArray = array(
                'std_id' => $std_id,
                'name' => $std_name,
                'isLoggedInWeb' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (End)


        // Check login status before execution
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            // Inserting into course_subscribe table (Start)
            // $data['paument_type'] = $this->request->getPost('paument_type');
            $data['course_id'] = $this->request->getPost('opt_a');
            $data['std_id'] = $this->session->std_id;
            $data['subs_time'] = '1';
            $data['status'] = '1';
            $data['createdBy'] = $this->session->std_id;

            $table = DB()->table('course_subscribe');
            $table->insert($data);
            // Inserting into course_subscribe table (Start)


            // Inserting into payment table (Start)
            $data2['course_subscribe_id'] = empty(DB()->insertID()) ? null : DB()->insertID();
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

            return redirect()->to(site_url('/Web/Payment/payment_success/'));
        }
    }

    public function payment_success(){
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            unset($_SESSION['pay_course_id']);
            unset($_SESSION['redirect_url']);

//            $table = DB()->table('course');
//            $data['course'] = $table->where('course_id',$course_id)->get()->getRow();

            echo view('Web/header');
            echo view('Web/pay_success');
            echo view('Web/footer');
        }
    }

    public function payment_fail_action(){
        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $std_id = $this->request->getPost('opt_b');
        $std_name = $this->request->getPost('cus_name');
        if (!empty($pay_status == 'Failed')) {
            $sessionArray = array(
                'std_id' => $std_id,
                'name' => $std_name,
                'isLoggedInWeb' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (End)


        // Check login status before execution
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {

            // Inserting into payment table (Start)
            $data2['course_subscribe_id'] = null;
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

            return redirect()->to(site_url('/Web/Payment/payment_fail/'));
        }
    }

    public function payment_fail(){
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            unset($_SESSION['pay_course_id']);
            unset($_SESSION['redirect_url']);

            echo view('Web/header');
            echo view('Web/pay_failed');
            echo view('Web/footer');
        }
    }

    public function payment_cancel(){
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            unset($_SESSION['pay_course_id']);
            unset($_SESSION['redirect_url']);

            echo view('Web/header');
            echo view('Web/pay_cancel');
            echo view('Web/footer');
        }
    }

}