<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Login extends BaseController
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
            echo view('Web/header');
            echo view('Web/login');
            echo view('Web/footer');
        } else {
            return redirect()->to(site_url("/Web/Dashboard"));
        }
    }

    public function login_action(){
        $data['phone'] = $this->request->getPost('phone');
        $data['password'] = SHA1($this->request->getPost('password'));

        $this->validation->setRules([
            'phone' => ['label' => 'Phone', 'rules' => 'required|numeric'],
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[155]'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('/Web/Login');
        } else {
            $result = $this->checkUser($data['phone'], $data['password']);

            if (!empty($result)) {
                $sessionArray = array(
                    'std_id' => $result->std_id,
                    'name' => $result->name,
                    'isLoggedInWeb' => TRUE
                );
                $this->session->set($sessionArray);

                $pay_course_id = $this->session->pay_course_id;
                if (!isset($pay_course_id)){
                    return redirect()->to(site_url("/Web/Dashboard"));
                }else{
                    return redirect()->to( site_url($this->session->redirect_url));
                }
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Phone or password mismatch</div>');
                return redirect()->to('/Web/login');
            }

        }
    }




    public function sign_up(){
        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {

            echo view('Web/header');
            echo view('Web/register');
            echo view('Web/footer');
        }else {
            return redirect()->to(site_url("/Web/Dashboard"));
        }
    }

    public function sign_up_action(){
        $data['name'] = $this->request->getPost('name');
        $data['phone'] = $this->request->getPost('phone');
        $data['status'] = '1';
        $data['createdBy'] = '1';
        $data['password'] = SHA1($this->request->getPost('password'));
        $con_password = SHA1($this->request->getPost('con_password'));
        $this->validation->setRules([
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[155]'],
            'name' => ['label' => 'Name', 'rules' => 'required'],

        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('/Web/Login/sign_up');
        } else {
            $result = $this->checkUserAvailable($data['phone']);
            if (!empty($result)){
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">This phone number already used!</div>');
                return redirect()->to('/Web/Login/sign_up');
            }else{
                if ($data['password'] == $con_password){

                    $table = DB()->table('student');
                    $table->insert($data);

                    $result = $this->checkUser($data['phone'], $data['password']);
                    if (!empty($result)) {
                        $sessionArray = array(
                            'std_id' => $result->std_id,
                            'name' => $result->name,
                            'isLoggedInWeb' => TRUE
                        );
                        $this->session->set($sessionArray);

                        $pay_course_id = $this->session->pay_course_id;
                        if (!isset($pay_course_id)){
                            return redirect()->to(site_url("/Web/Dashboard"));
                        }else{
                            return redirect()->to( site_url($this->session->redirect_url));
                        }
                    }

                }else{
                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Password Or conform password not match!</div>');
                    return redirect()->to('/Web/Login/sign_up');
                }
            }
        }
    }

    private function checkUserAvailable($phone)
    {
        $table = DB()->table('student');
        $query = $table->where('phone', $phone)->get();
        $user = $query->getRow();

        if (!empty($user)) {
            return '1';
        } else {
            return '0';
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

    public function logout(){
        unset($_SESSION['std_id']);
        unset($_SESSION['name']);
        unset($_SESSION['isLoggedInWeb']);
        unset($_SESSION['pay_course_id']);
        unset($_SESSION['redirect_url']);

//        $this->session->destroy();
        return redirect()->to('/Web/Login');
    }
}