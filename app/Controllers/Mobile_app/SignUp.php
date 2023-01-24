<?php

namespace App\Controllers\Mobile_app;

use App\Controllers\BaseController;
use App\Models\Class_group_joinedModel;
use App\Models\Group_classModel;
use App\Models\School_classModel;
use App\Models\StudentModel;


class SignUp extends BaseController
{
    protected $validation;
    protected $session;
    protected $student;
    protected $school_classModel;
    protected $group_classModel;
    protected $class_group_joinedModel;

    public function __construct()
    {
        $this->student = new StudentModel();
        $this->school_classModel = new School_classModel();
        $this->group_classModel = new Group_classModel();
        $this->class_group_joinedModel = new Class_group_joinedModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            echo view('SignUp/header');
            echo view('SignUp/index');
            echo view('SignUp/footer');
        } else {
            return redirect()->to(site_url("/Mobile_app/Dashboard"));
        }
    }

    public function sign_up_action()
    {
        $data['name'] = $this->request->getPost('name');
        $data['father_name'] = $this->request->getPost('father_name');
        $data['address'] = $this->request->getPost('address');
        $data['school_name'] = $this->request->getPost('school_name');
        $data['gender'] = $this->request->getPost('gender');
        $data['religion'] = $this->request->getPost('religion');
        $data['age'] = $this->request->getPost('age');
        $data['phone'] = $this->request->getPost('phone');
        $data['password'] = SHA1($this->request->getPost('password'));
        $data['class_id'] = $this->request->getPost('class_id');
        $data['institute'] = $this->request->getPost('institute');
        $data['class_group_id'] = $this->request->getPost('class_group');
        $data['createdBy'] = 1;


        $this->validation->setRules([
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[155]'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'father_name' => ['label' => 'Father name', 'rules' => 'required'],
            'address' => ['label' => 'Address', 'rules' => 'required'],
            'school_name' => ['label' => 'School Name', 'rules' => 'required'],
            'gender' => ['label' => 'Gender', 'rules' => 'required'],
            'religion' => ['label' => 'Religion', 'rules' => 'required'],
            'age' => ['label' => 'Age', 'rules' => 'required|numeric'],
            'class_id' => ['label' => 'Class', 'rules' => 'required'],
            'institute' => ['label' => 'Institute', 'rules' => 'required'],

        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('/');
        } else {

            $check = $this->checkUser($data['phone'], $data['password']);
            if (empty($check)){
                $this->student->insert($data);
            }else{
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Phone number already in use</div>');
                return redirect()->to(site_url("/Mobile_app/SignUp"));
            }

            $result = $this->checkUser($data['phone'], $data['password']);
            if (!empty($result)) {

                $sessionArray = array(
                    'std_id' => $result->std_id,
                    'name' => $result->name,
                    'isLoggedInStudent' => TRUE
                );
                $this->session->set($sessionArray);
                return redirect()->to(site_url("/Mobile_app/Dashboard"));
            }
        }


    }

    public function signIn()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            echo view('SignUp/header');
            echo view('SignUp/signIn');
            echo view('SignUp/footer');

        } else {
            return redirect()->to(site_url("/Mobile_app/Dashboard"));
        }
    }

    public function login_action()
    {
        $data['phone'] = $this->request->getPost('phone');
        $data['password'] = SHA1($this->request->getPost('password'));

        $this->validation->setRules([
            'phone' => ['label' => 'Phone', 'rules' => 'required|numeric'],
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[155]'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('/login');
        } else {

            $result = $this->checkUser($data['phone'], $data['password']);

            if (!empty($result)) {
                $sessionArray = array(
                    'std_id' => $result->std_id,
                    'name' => $result->name,
                    'isLoggedInStudent' => TRUE
                );
                $this->session->set($sessionArray);
                return redirect()->to(site_url("/Mobile_app/Dashboard"));
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Phone or password mismatch</div>');
                return redirect()->to('/Mobile_app/login');
            }
        }
    }

    private function checkUser($phone, $pass)
    {
        $table = DB()->table('student');
        $query = $table->where('phone', $phone)->get();
        $user = $query->getRow();

        if (!empty($user)) {
            if ($pass == $user->password) {
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function logout()
    {

        unset($_SESSION['std_id']);
        unset($_SESSION['name']);
        unset($_SESSION['isLoggedInStudent']);

//        $this->session->destroy();
        return redirect()->to('/Mobile_app/login');
    }

    public function classGroup(){
        $classId = $this->request->getPost('class_id');
        $classGroJoin = $this->class_group_joinedModel->where('class_id',$classId)->findAll();

        $view = '';
        $i=1;
        $j=1;
        if (!empty($classGroJoin)){
            $view .='<div class="btn-group sel-redio" role="group" aria-label="Basic radio toggle button group">';
            foreach ($classGroJoin as $val) {
                $clName = get_data_by_id('group_name','class_group','class_group_id',$val->class_group_id);
                $ch = ($i == 1)?'checked':'';
                $view .='<input  type="radio" class="btn-check" name="class_group" id="option_'.$i++.'" autocomplete="off"'.$ch.'  value="'.$val->class_group_id.'"/>
                <label class="btn btn-outline-success" for="option_'.$j++.'">'.$clName.'</label>';
            }
            $view .='</div>';
        }

        print $view;
    }



    public function forget_password(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            echo view('SignUp/header');
            echo view('SignUp/forget_password');
            echo view('SignUp/footer');
        } else {
            return redirect()->to(site_url("/Mobile_app/Dashboard"));
        }
    }

    public function send_otp(){
        $phone = $this->request->getPost('phone');

        $table = DB()->table('student');
        $query = $table->where('phone', $phone)->get();
        $user = $query->getRow();

        if (!empty($user)){
            $otp_code = substr((rand()),0, 4);

            setcookie('forget_phone',$phone,time()+ (60 * 2), "/");
            setcookie('forget_otp',$otp_code,time()+ (60 * 2), "/");

//            http://bulksmsbd.net/api/smsapi?api_key=Yyl7HcfrZAEclh1KhnMG&type=text&number=(Receiver)&senderid=8809617611058&message=(Message Content)

            return redirect()->to('Mobile_app/SignUp/otp_submit');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Enter correct phone number!</div>');
            return redirect()->to('Mobile_app/SignUp/forget_password');
        }

    }

    public function otp_submit(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            echo view('SignUp/header');
            echo view('SignUp/otp_submit');
            echo view('SignUp/footer');
        } else {
            return redirect()->to(site_url("/Mobile_app/Dashboard"));
        }
    }

    public function otp_submit_action(){
        $otp = $this->request->getPost('otp');
        if (isset($_COOKIE['forget_otp'])){
            if($_COOKIE['forget_otp'] == $otp){
                return redirect()->to(site_url("/Mobile_app/SignUp/enter_new_password"));
            }else{
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please enter correct otp</div>');
                return redirect()->to(site_url("/Mobile_app/SignUp/otp_submit"));
            }

        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Your session is expired </div>');
            return redirect()->to(site_url("/Mobile_app/SignUp/forget_password"));
        }



//        return redirect()->to(site_url("/Mobile_app/SignUp/enter_new_password"));
    }

    public function enter_new_password(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            echo view('SignUp/header');
            echo view('SignUp/pass_submit');
            echo view('SignUp/footer');
        } else {
            return redirect()->to(site_url("/Mobile_app/Dashboard"));
        }
    }

    public function reset_password_action(){
        $data['password'] = $this->request->getPost('password');
        $data['con_password'] = $this->request->getPost('con_password');

        $this->validation->setRules([
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[155]'],
            'con_password' => ['label' => 'Confirm Password', 'rules' => 'required|matches[password]'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('/Mobile_app/SignUp/enter_new_password');
        } else {
            if (isset($_COOKIE['forget_phone'])) {
                $updateData['password'] = SHA1($data['password']);
                $table = DB()->table('student');
                $table->where('phone', $_COOKIE['forget_phone'])->update($updateData);
                return redirect()->to('/Mobile_app/SignUp/success');
            }else{
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Your session is expired </div>');
                return redirect()->to(site_url("/Mobile_app/SignUp/forget_password"));
            }
        }
    }

    public function success(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            $data['head'] = 'soccess';
            echo view('SignUp/header',$data);
            echo view('SignUp/pass_success');
            echo view('SignUp/footer');
        } else {
            return redirect()->to(site_url("/Mobile_app/Dashboard"));
        }
    }
}
