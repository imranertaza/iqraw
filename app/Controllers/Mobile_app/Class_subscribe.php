<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\ChapterModel;
use App\Models\Class_subscribe_packageModel;
use App\Models\Class_subscribeModel;
use App\Models\Group_classModel;
use App\Models\School_classModel;
use App\Models\SubjectModel;
use mysql_xdevapi\Table;


class Class_subscribe extends BaseController
{
    protected $validation;
    protected $session;
    protected $schoolClassModel;
    protected $class_subscribeModel;
    protected $class_subscribe_packageModel;
    protected $subjectModel;
    protected $chapterModel;
    protected $group_classModel;

    public function __construct()
    {
        $this->schoolClassModel = new School_classModel();
        $this->class_subscribe_packageModel = new Class_subscribe_packageModel();
        $this->class_subscribeModel = new Class_subscribeModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterModel = new ChapterModel();
        $this->group_classModel = new Group_classModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index($subscribePackageId)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            $data['back_url'] = base_url('/Mobile_app/Subject');
            $data['page_title'] = 'Subject Subscribe';
            $data['footer_icon'] = 'Home';

            $data['pack'] = $this->class_subscribe_packageModel->where('class_subscription_package_id',$subscribePackageId)->first();

            $table2 = DB()->table('student');
            $data['std_info'] = $table2->where('std_id', $this->session->std_id)->get()->getRow();

            echo view('Student/header',$data);
            echo view('Student/class_subscribe',$data);
            echo view('Student/footer');
        }
    }

    public function sub_action(){
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
                'isLoggedInStudent' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (Start)

        // Checking if the paid amount is correct with course amount
        if ($paid_amount !== $class_subscription_amount){
            return redirect()->to('Mobile_app/Class_subscribe/index/'.$data['class_subscription_package_id']);
        }

        // Check login status before execution
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
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
                    return redirect()->to('/Mobile_app/Class_subscribe/canceled/');
                }

                return redirect()->to('/Mobile_app/Class_subscribe/success/');
            }else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Terms fields required!</div>');
                return redirect()->to('Mobile_app/Class_subscribe/index/'.$data['class_subscription_package_id']);
            }
        }
    }

    public function success(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Subject/');
            $data['page_title'] = 'Class Subscribe Success!';
            $data['footer_icon'] = 'Home';

            echo view('Student/header',$data);
            echo view('Student/class_subscribe_success',$data);
            echo view('Student/footer');
        }
    }

    public function failed_action(){
        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $data['std_id'] = $this->request->getPost('opt_b');
        $data['std_name'] = $this->request->getPost('cus_name');
        if (!empty($pay_status == 'Failed')) {
            $sessionArray = array(
                'std_id' => $data['std_id'],
                'name' => $data['std_name'],
                'isLoggedInStudent' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (Start)


        // Check login status before execution
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            // Inserting into payment table as history(Start)
            $data2['class_subscribe_id'] = null;
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

            return redirect()->to('Mobile_app/Class_subscribe/failed/');
        }
    }

    public function failed(){
        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $data['std_id'] = $this->request->getPost('opt_b');
        $data['std_name'] = $this->request->getPost('cus_name');
        if (!empty($pay_status == 'Failed')) {
            $sessionArray = array(
                'std_id' => $data['std_id'],
                'name' => $data['std_name'],
                'isLoggedInStudent' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (Start)


        // Check login status before execution
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Subject/');
            $data['page_title'] = 'Class Subscribe Failed';
            $data['footer_icon'] = 'Home';

            echo view('Student/header',$data);
            echo view('Student/class_subscribe_failed',$data);
            echo view('Student/footer');
        }
    }

    public function canceled(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Subject/');
            $data['page_title'] = 'Class Subscribe Canceled';
            $data['footer_icon'] = 'Home';

            echo view('Student/header',$data);
            echo view('Student/class_subscribe_canceled',$data);
            echo view('Student/footer');
        }
    }




}
