<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\Class_subscribeModel;


class Payment extends BaseController
{
    protected $validation;
    protected $session;
    protected $class_subscribeModel;

    public function __construct()
    {
        $this->class_subscribeModel = new Class_subscribeModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'Payment';
            $data['footer_icon'] = 'Home';

            $data['package'] = $this->class_subscribeModel->where('std_id',$this->session->std_id)->findAll();

            echo view('Student/header',$data);
            echo view('Student/payment_list',$data);
            echo view('Student/footer');
        }
    }





}
