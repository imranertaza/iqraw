<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\StudentModel;

class Profile extends BaseController
{
    protected $validation;
    protected $session;
    protected $studentModel;
    protected $crop;

    public function __construct(){
        $this->studentModel = new StudentModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
    }

    public function index(){

        $isLoggedInWeb = $this->session->isLoggedInWeb;
        if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) {
            return redirect()->to(site_url("/Web/Login"));
        } else {
            $std_id = $this->session->std_id;

            $table = DB()->table('student');
            $data['student'] = $table->where('std_id',$std_id)->get()->getRow();

            echo view('Web/header');
            echo view('Web/profile',$data);
            echo view('Web/footer');
        }
    }
    public function update_action(){
        $fields['std_id'] = $this->session->std_id;
        $fields['name'] = $this->request->getPost('name');
        $fields['phone'] = $this->request->getPost('phone');
        $fields['father_name'] = $this->request->getPost('father_name');
        $fields['address'] = $this->request->getPost('address');
        $fields['gender'] = $this->request->getPost('gender');
        $fields['age'] = $this->request->getPost('age');
        $fields['religion'] = $this->request->getPost('religion');
        $fields['institute'] = $this->request->getPost('institute');
        $fields['school_name'] = $this->request->getPost('school_name');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['class_group_id'] = $this->request->getPost('class_group_id');

        $image = $this->request->getFile('pic');

        if (!empty($_FILES['pic']['name'])) {
            // thumb image uploading section (start)
            $target_dir = FCPATH . 'assets/upload/profile/'.$fields['std_id'].'/';
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            $name = $image->getRandomName();
            $image->move($target_dir, $name);

            // Image cropping of the uploaded image
            $nameimg = 'pro_' . $image->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(80, 80, 'center')->save($target_dir . '' . $nameimg);
            unlink($target_dir . '' . $name);

            $fields['pic'] = $nameimg;
        }

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'gender' => ['label' => 'Gender', 'rules' => 'required'],
            'religion' => ['label' => 'Religion', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">This phone number already used!</div>');
            return redirect()->to('/Web/Profile');

        } else {
            $this->studentModel->update($fields['std_id'],$fields);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Update Successfully</div>');
            return redirect()->to('/Web/Profile');
        }
    }




}
