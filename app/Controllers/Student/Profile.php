<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\StudentModel;


class Profile extends BaseController
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
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/');
            $data['page_title'] = 'Profile';


            $query = $this->student->where('std_id',$this->session->std_id)->get();
            $data['user'] = $query->getRow();

            echo view('Student/header',$data);
            echo view('Student/profile',$data);
            echo view('Student/footer');
        }
    }




}
