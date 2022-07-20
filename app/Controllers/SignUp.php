<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;


class SignUp extends BaseController
{
    protected $validation;
    protected $session;
    protected $student;

    public function __construct()
    {
        $this->student = new StudentModel();
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
            return redirect()->to(site_url("/Student/Dashboard"));
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
        $data['class_group'] = $this->request->getPost('class_group');


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
            'class_group' => ['label' => 'Class Group', 'rules' => 'required'],

        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('/');
        } else {
            $this->student->insert($data);

            $result = $this->checkUser($data['phone'], $data['password']);
            if (!empty($result)) {
                $sessionArray = array(
                    'std_id' => $result->std_id,
                    'name' => $result->name,
                    'isLoggedInStudent' => TRUE
                );
                $this->session->set($sessionArray);
                return redirect()->to(site_url("/Student/Dashboard"));
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
            return redirect()->to(site_url("/Student/Dashboard"));
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
                return redirect()->to(site_url("/Student/Dashboard"));
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Phone or password mismatch</div>');
                return redirect()->to('/login');
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

        $this->session->destroy();
        return redirect()->to('/login');
    }

}
