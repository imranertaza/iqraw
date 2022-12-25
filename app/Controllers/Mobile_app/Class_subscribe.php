<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\ChapterModel;
use App\Models\Class_subscribe_packageModel;
use App\Models\Class_subscribeModel;
use App\Models\Group_classModel;
use App\Models\School_classModel;
use App\Models\SubjectModel;
use mysql_xdevapi\Table;


class Class_subscribe extends BaseController
{
    protected $validation;
    protected $session;
    protected $schoolClassModel;
    protected $class_subscribeModel;
    protected $class_subscribe_packageModel;
    protected $subjectModel;
    protected $chapterModel;
    protected $group_classModel;

    public function __construct()
    {
        $this->schoolClassModel = new School_classModel();
        $this->class_subscribe_packageModel = new Class_subscribe_packageModel();
        $this->class_subscribeModel = new Class_subscribeModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterModel = new ChapterModel();
        $this->group_classModel = new Group_classModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index($subscribePackageId)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            $data['back_url'] = base_url('/Mobile_app/Subject');
            $data['page_title'] = 'Subject Subscribe';
            $data['footer_icon'] = 'Home';

            $data['pack'] = $this->class_subscribe_packageModel->where('class_subscription_package_id',$subscribePackageId)->first();

            echo view('Student/header',$data);
            echo view('Student/class_subscribe',$data);
            echo view('Student/footer');
        }
    }

    public function sub_action(){
        $endDate = date( "Y-m-d", strtotime( "+30 days" ));

        $data['class_subscription_package_id'] = $this->request->getPost('class_subscription_package_id');
        $data['std_id'] = $this->session->std_id;
        $data['subs_time'] = '1';
        $data['subs_end_date'] = $endDate;
        $data['status'] = '1';
        $data['createdBy'] = $this->session->std_id;

        $this->class_subscribeModel->insert($data);
        return redirect()->to('/Mobile_app/Class_subscribe/success/');
    }

    public function success(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Subject/');
            $data['page_title'] = 'Class Subscribe success';
            $data['footer_icon'] = 'Home';

            echo view('Student/header',$data);
            echo view('Student/success_subscribe',$data);
            echo view('Student/footer');
        }
    }




}
