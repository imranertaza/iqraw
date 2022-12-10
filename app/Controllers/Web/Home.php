<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $validation;
    protected $session;

    public function __construct(){
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index(){


        echo view('Web/header');
        echo view('Web/index');
        echo view('Web/footer');
    }

    public function product(){


        echo view('Web/header');
        echo view('Web/product');
        echo view('Web/footer');
    }

    public function about_us(){


        echo view('Web/header');
        echo view('Web/about_us');
        echo view('Web/footer');
    }

    public function contact_us(){


        echo view('Web/header');
        echo view('Web/contact_us');
        echo view('Web/footer');
    }

    public function refundpolicy(){


        echo view('Web/header');
        echo view('Web/refundpolicy');
        echo view('Web/footer');
    }

    public function privacypolicy(){


        echo view('Web/header');
        echo view('Web/privacypolicy');
        echo view('Web/footer');
    }

    public function tarmsandcondition(){


        echo view('Web/header');
        echo view('Web/tarmsandcondition');
        echo view('Web/footer');
    }

    public function course(){

        $table = DB()->table('course');
        $data['course'] = $table->where('class_id',null)->where('class_group_id',null)->get()->getResult();

        echo view('Web/header');
        echo view('Web/course',$data);
        echo view('Web/footer');
    }

    public function course_detail($course_id){
        $table = DB()->table('course');
        $data['course'] = $table->where('course_id',$course_id)->get()->getRow();

        echo view('Web/header');
        echo view('Web/course_detail',$data);
        echo view('Web/footer');
    }

    public function payment($course_id){
        $sessionpay = array(
            'pay_course_id' => $course_id,
            'redirect_url' => '/Web/Home/payment/'.$course_id,
        );
        $this->session->set($sessionpay);

        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login/sign_up"));
        } else {
            $table = DB()->table('course');
            $data['course'] = $table->where('course_id',$course_id)->get()->getRow();

            echo view('Web/header');
            echo view('Web/course_pay',$data);
            echo view('Web/footer');
        }
    }

    public function payment_action(){
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            $data['paument_type'] = $this->request->getPost('paument_type');
            $data['course_id'] = $this->request->getPost('course_id');


            return redirect()->to(site_url('/Web/Home/payment_success/'));
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

}
