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
use App\Models\Live_class_Model;
use function _PHPStan_9a6ded56a\React\Promise\Stream\first;


class Live extends BaseController
{
    protected $validation;
    protected $session;
    protected $schoolClassModel;
    protected $class_subscribeModel;
    protected $class_subscribe_packageModel;
    protected $subjectModel;
    protected $chapterModel;
    protected $group_classModel;
    protected $Live_class_Model;

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
        $this->Live_class_Model = new Live_class_Model();

    }
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            $classId = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $classGroupId = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);
            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'Live Class';
            $data['footer_icon'] = 'Home';
            $data['result'] = $this->Live_class_Model->select('youtube_code')->where('class_id', $classId)->where('class_group_id', $classGroupId)->first();

            // Check if this class has live class running
            $live_video_status = $this->Live_class_Model->select('youtube_code')->where('class_id', $classId)->where('class_group_id', $classGroupId)->countAllResults();
            if ($live_video_status != 1) {
                // Redirect to Dashboard
                return redirect()->to(site_url("/Mobile_app/Dashboard"));
            }

            echo view('Student/header_live',$data);
            echo view('Student/live',$data);
            //echo view('Student/footer');
        }
    }


}