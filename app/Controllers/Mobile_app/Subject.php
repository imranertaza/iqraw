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


class Subject extends BaseController
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
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'My Subject';
            $data['footer_icon'] = 'Home';

            $classId = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $classGroupId = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

                $wArray =  "(`class_group_id` IS NULL OR `class_group_id` = '$classGroupId')";
                $data['subject'] = $this->subjectModel->where('class_id', $classId)->where($wArray)->findAll();

            unset($_SESSION['quiz']);
            unset($_SESSION['chapter_joined_id']);

            echo view('Student/header',$data);
            echo view('Student/class',$data);
            echo view('Student/footer');
        }
    }

    public function chapter($subjectId)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $subject = get_data_by_id('name', 'subject', 'subject_id', $subjectId);
            $data['back_url'] = base_url('/Mobile_app/Subject');
            $data['page_title'] = $subject;
            $data['footer_icon'] = 'Home';
            $data['chapter'] = $this->chapterModel->where('subject_id', $subjectId)->findAll();

            //subcribe
            $classId = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $classGroupId = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

            $wArray =  "(`class_group_id` IS NULL OR `class_group_id` = '$classGroupId')";
            $subscribePackage = $this->class_subscribe_packageModel->where('class_id', $classId)->where($wArray)->countAllResults();


            if (!empty($subscribePackage)){
//                $subscrib = $this->class_subscribeModel->where('std_id',$this->session->std_id)->where('status','1')->where('subs_end_date >=',date('Y-m-d'))->countAllResults();

                $subscrib = $this->class_subscribeModel->join('class_subscribe_package', 'class_subscribe_package.class_subscription_package_id = class_subscribe.class_subscription_package_id')->where('class_subscribe.std_id',$this->session->std_id)->where('class_subscribe.status','1')->where('class_subscribe_package.end_date >=',date('Y-m-d'))->countAllResults();

                if (empty($subscrib)){
                    // Checking if subscription expires or not, if expire, status is updating
                    $statusData['status'] = '0';
                    $table = DB()->table('class_subscribe');
                    $table->where('std_id',$this->session->std_id)->where('status','1')->update($statusData);
                    return redirect()->to(site_url('/Mobile_app/Class_subscribe'));
                }
            }



            echo view('Student/header', $data);
            echo view('Student/chapter', $data);
            echo view('Student/footer');


        }
    }




}
