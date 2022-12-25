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

            // SELECT * FROM `subject` WHERE `class_id` = '15' AND ((`class_group_id` IS NULL) OR (`class_group_id` = '1'))
            if (!empty($classGroupId)) {
                $wArray =  "(`class_group_id` IS NULL OR `class_group_id` = '$classGroupId')";
                $data['subject'] = $this->subjectModel->where('class_id', $classId)->where($wArray)->findAll();
//                print $this->subjectModel->getLastQuery();
//                die();
            }else{
                $data['subject'] = $this->subjectModel->where('class_id', $classId)->findAll();
            }

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

            $subscribePackageId = $this->class_subscribe_packageModel->where('class_id', $classId)->where('class_group_id', $classGroupId)->first();

            if (!empty($subscribePackageId)){
                $subscrib = $this->class_subscribeModel->where('std_id',$this->session->std_id)->where('class_subscription_package_id',$subscribePackageId->class_subscription_package_id)->where('subs_end_date >=',date('Y-m-d'))->countAllResults();
                if (empty($subscrib)){

                    $this->class_subscribeModel->where('std_id',$this->session->std_id)->where('class_subscription_package_id',$subscribePackageId->class_subscription_package_id)->delete();
                    
                    return redirect()->to(site_url('/Mobile_app/Class_subscribe/index/'.$subscribePackageId->class_subscription_package_id));
                }
            }

            echo view('Student/header', $data);
            echo view('Student/chapter', $data);
            echo view('Student/footer');


        }
    }




}
