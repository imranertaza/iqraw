<?php

namespace App\Controllers\Mobile_app;
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
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            $data['footer_icon'] = 'Home';
            unset($_SESSION['quiz']);
            unset($_SESSION['result_submit']);
            $query = $this->student->where('std_id',$this->session->std_id)->get();
            $data['student'] = $query->getRow();

            echo view('Student/home_header',$data);
            echo view('Student/dashboard',$data);
            echo view('Student/footer');
        }
    }




}
