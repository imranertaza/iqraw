<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\StudentModel;


class Login extends BaseController
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
            echo view('Admin/login');

        }else {
            return redirect()->to(site_url("/Admin/Dashboard"));
        }
    }

    public function action(){
        $this->validation->setRule('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->validation->setRule('password', 'Password', 'required|max_length[32]');

        if($this->validation->withRequest($this->request)->run() == FALSE){

            $this->session->setFlashdata('error', '<div class="alert alert-danger alert-dismissible fade show" role="alert">All field is required</div>');
            return redirect()->to(site_url("/admin"));
        }
        else
        {
            // $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $email = strtolower($this->request->getPost('email'));
            $password = $this->request->getPost('password');

            $result = $this->loginMe($email, $password);

            if(!empty($result)){

                // Remember me (Remembering the user email and password) Start
                if (!empty($this->request->getPost("remember"))) {

                    setcookie('login_email',$email,time()+ (86400 * 30), "/");
                    setcookie('login_password',$password,time() + (86400 * 30), "/");

                }else{
                    if (isset($_COOKIE['login_email'])) {
                        setcookie('login_email','', 0, "/");
                    }
                    if (isset($_COOKIE['login_password'])) {
                        setcookie('login_password','', 0, "/");
                    }
                }
                // Remember me (Remembering the user email and password) End


                $sessionArray = array(
                    'user_id'=>$result->user_id,
                    'adminName'=>$result->name,
                    'admin_role'=>$result->role_id,
                    'isLoggedIAdmin' => TRUE
                );

                $this->session->set($sessionArray);

                return redirect()->to(site_url("/Admin/Dashboard"));


            }
            else
            {
                $this->session->setFlashdata('error', 'Email or password mismatch');
                return redirect()->to(site_url("/admin"));
            }
        }
    }

    private function loginMe($email, $password){
        $table = DB()->table('users');
        $query = $table->where('email', $email)->get();
        $user = $query->getRow();

        if (!empty($user)) {
            if (SHA1($password) == $user->password) {
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

        unset($_SESSION['user_id']);
        unset($_SESSION['adminName']);
        unset($_SESSION['isLoggedIAdmin']);

//        $this->session->destroy();
        return redirect()->to('/admin');
    }





}
