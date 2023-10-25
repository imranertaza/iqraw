<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\StudentModel;


class Dashboard extends BaseController
{
    protected $validation;
    protected $session;
    protected $student;

    public function __construct()
    {
        $this->student = new StudentModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index(){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        }else {
            echo view('Admin/header');
            echo view('Admin/sidebar');
            echo view('Admin/dashboard');
            echo view('Admin/footer');
        }

    }






}
