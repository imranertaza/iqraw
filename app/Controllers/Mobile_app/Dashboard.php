<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\Live_class_Model;
use App\Models\StudentModel;


class Dashboard extends BaseController
{
    protected $validation;
    protected $session;
    protected $student;
    private $Live_class_Model;

    public function __construct()
    {
        $this->student = new StudentModel();
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
            $data['footer_icon'] = 'Home';
            unset($_SESSION['quiz']);
            unset($_SESSION['result_submit']);
            unset($_SESSION['packId']);
            unset($_SESSION['redi_url']);
            $query = $this->student->where('std_id',$this->session->std_id)->get();
            $data['student'] = $query->getRow();

            // Check if this class has live class running
            $data['live_video_status'] = $this->Live_class_Model->select('youtube_code')->where('class_id', $classId)->where('class_group_id', $classGroupId)->countAllResults();


            echo view('Student/home_header',$data);
            echo view('Student/dashboard',$data);
            echo view('Student/footer');
        }
    }




}
