<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\Class_descriptionModel;
use App\Models\Class_group_joinedModel;
use App\Models\Class_subscribe_packageModel;
use App\Models\Course_quizModel;
use App\Models\Course_subscribeModel;
use App\Models\Course_videoModel;
use App\Models\CourseModel;
use App\Models\History_user_coin_Model;
use App\Models\History_user_point_Model;
use App\Models\StudentModel;


class My_class extends BaseController
{
    protected $validation;
    protected $session;
    protected $courseModel;
    protected $course_subscribeModel;
    protected $course_videoModel;
    protected $course_quizModel;
    protected $studentModel;
    protected $history_user_point_Model;
    protected $history_user_coin_Model;
    protected $class_group_joinedModel;
    protected $class_descriptionModel;
    protected $class_subscribe_packageModel;

    public function __construct()
    {
        $this->class_descriptionModel = new Class_descriptionModel();
        $this->class_group_joinedModel = new Class_group_joinedModel();
        $this->class_subscribe_packageModel = new Class_subscribe_packageModel();
        $this->courseModel = new CourseModel();
        $this->course_videoModel = new Course_videoModel();
        $this->studentModel = new StudentModel();
        $this->history_user_point_Model = new History_user_point_Model();
        $this->history_user_coin_Model = new History_user_coin_Model();
        $this->course_quizModel = new Course_quizModel();
        $this->course_subscribeModel = new Course_subscribeModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index(){
        $data['general'] = $this->class_group_joinedModel->where('edu_type_id',1)->findAll();
        $data['madrasha'] = $this->class_group_joinedModel->where('edu_type_id',2)->findAll();
        echo view('Student/my_class',$data);
    }
    public function detail($id){
        $data['description'] = $this->class_descriptionModel->where('class_group_jnt_id',$id)->first();
        if (!empty($data['description'])) {
            echo view('Student/my_class_detail', $data);
        }else{
            return redirect()->to(site_url('Mobile_app'));
        }
    }

    public function enrol($id){
        $class = $this->class_group_joinedModel->where('class_group_jnt_id',$id)->first();

        $data['pack'] = $this->class_subscribe_packageModel->where('class_id',$class->class_id)->where('class_group_id',$class->class_group_id)->where('end_date >=',date('Y-m-d'))->findAll();

        echo view('Student/my_class_enrol',$data);
    }

    public function package_purchase(){
        $packId = $this->request->getPost('class_subscription_package_id');
        $url = base_url('Mobile_app/Class_subscribe');

        $sessionData = array(
            'packId' => $packId,
            'redi_url' => $url,
        );

        $this->session->set($sessionData);

        return redirect()->to(site_url('/Mobile_app/Class_subscribe'));
    }





}
