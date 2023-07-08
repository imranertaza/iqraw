<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\Class_descriptionModel;
use App\Models\Class_group_joinedModel;
use App\Models\Class_subscribe_packageModel;

class Class_detail extends BaseController
{
    protected $validation;
    protected $class_descriptionModel;
    protected $class_subscribe_packageModel;
    protected $class_group_joinedModel;
    protected $session;

    public function __construct(){
        $this->class_descriptionModel = new Class_descriptionModel();
        $this->class_subscribe_packageModel = new Class_subscribe_packageModel();
        $this->class_group_joinedModel = new Class_group_joinedModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index($id){
        $data['description'] = $this->class_descriptionModel->where('class_group_jnt_id',$id)->first();
        $class_g = $this->class_group_joinedModel->where('class_group_jnt_id',$id)->first();
        $data['package'] = $this->class_subscribe_packageModel->where('class_id',$class_g->class_id)->where('class_group_id',$class_g->class_group_id)->where('end_date >=',date('Y-m-d'))->findAll();

        echo view('Web/header');
        echo view('Web/class_detail',$data);
        echo view('Web/footer');
    }

    public function package_subscribe(){
        $packId = $this->request->getPost('class_subscription_package_id');
        $url = base_url('Web/Class_subscribe');

        $sessionData = array(
            'packId' => $packId,
            'redirect_url' => $url,
        );

        $this->session->set($sessionData);

        return redirect()->to(site_url('/Web/Class_subscribe'));
    }



}
