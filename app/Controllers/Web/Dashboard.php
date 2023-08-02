<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $validation;
    protected $session;

    public function __construct(){
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index(){

        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            unset($_SESSION['packId']);
            unset($_SESSION['redirect_url']);

            $std_id = $this->session->std_id;

            $table = DB()->table('course_subscribe');
            $data['couSub'] = $table->where('std_id',$std_id)->get()->getResult();

            $tablePack = DB()->table('class_subscribe');
            $data['pack'] = $tablePack->where('std_id',$std_id)->get()->getResult();

            echo view('Web/header');
            echo view('Web/dashboard',$data);
            echo view('Web/footer');
        }
    }

    public function course($course_id){
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            $std_id = $this->session->std_id;

            $table = DB()->table('course');
            $data['course'] = $table->where('course_id',$course_id)->get()->getRow();

            $catTable = DB()->table('course_category');
            $data['coursecategory'] = $catTable->where('course_id',$course_id)->get()->getResult();

            echo view('Web/header');
            echo view('Web/course_video',$data);
            echo view('Web/footer');
        }
    }




}
