<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\Course_videoModel;
use App\Models\CourseModel;
use App\Models\History_user_coin_Model;
use App\Models\History_user_point_Model;
use App\Models\Quiz_exam_joinedModel;
use App\Models\Quiz_questionModel;
use App\Models\QuizModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use CodeIgniter\Database\RawSql;


class Course extends BaseController
{
    protected $validation;
    protected $session;
    protected $courseModel;
    protected $course_videoModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->course_videoModel = new Course_videoModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/');
            $data['page_title'] = 'Course';
            $data['footer_icon'] = 'Home';

            $classID = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $groupID = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

            $data['course'] = $this->courseModel->where('class_id',$classID)->where('class_group_id',$groupID)->orWhere('class_id',null)->findAll();

            echo view('Student/header',$data);
            echo view('Student/course_list',$data);
            echo view('Student/footer');
        }
    }

    public function video($course_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Course');
            $data['page_title'] = 'Course Video';
            $data['footer_icon'] = 'Home';

            $classID = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $groupID = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

            $data['video'] = $this->course_videoModel->where('course_id',$course_id)->findAll();

            echo view('Student/header',$data);
            echo view('Student/course_video_list',$data);
            echo view('Student/footer');
        }
    }

    public function subscribe($course_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Course/video/'.$course_id);
            $data['page_title'] = 'Course Subscribe';
            $data['footer_icon'] = 'Home';


            $data['course'] = $this->courseModel->where('course_id',$course_id)->first();

            echo view('Student/header',$data);
            echo view('Student/course_subscribe',$data);
            echo view('Student/footer');
        }
    }

    public function video_view($course_video_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $courVid = $this->course_videoModel->where('course_video_id',$course_video_id)->first();

            $data['back_url'] = base_url('/Student/Course/video/'.$courVid->course_id);
            $data['page_title'] = 'Course Video';
            $data['footer_icon'] = 'Home';


            $data['video'] = $courVid;

            echo view('Student/header',$data);
            echo view('Student/course_video',$data);
            echo view('Student/footer');
        }
    }
    




}
