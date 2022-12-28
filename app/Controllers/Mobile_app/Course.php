<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\Course_subscribeModel;
use App\Models\Course_videoModel;
use App\Models\CourseModel;


class Course extends BaseController
{
    protected $validation;
    protected $session;
    protected $courseModel;
    protected $course_subscribeModel;
    protected $course_videoModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->course_videoModel = new Course_videoModel();
        $this->course_subscribeModel = new Course_subscribeModel();
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
            $data['page_title'] = 'Course';
            $data['footer_icon'] = 'Home';

            $classID = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $group = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

            $wArray =  "(`class_group_id` IS NULL OR `class_group_id` = '$group')";
            $data['course'] = $this->courseModel->where('class_id',$classID)->where($wArray)->orWhere('class_id',null)->findAll();

            echo view('Student/header',$data);
            echo view('Student/course_list',$data);
            echo view('Student/footer');
        }
    }

    public function my_course(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'My Course';
            $data['footer_icon'] = 'Home';

            $classID = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $groupID = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

            $wArray =  "(`class_group_id` IS NULL OR `class_group_id` = '$groupID')";
            $data['course'] = $this->courseModel->where('class_id',$classID)->where($wArray)->orWhere('class_id',null)->findAll();

            echo view('Student/header',$data);
            echo view('Student/my_course_list',$data);
            echo view('Student/footer');
        }
    }

    public function category($course_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            $courseName = get_data_by_id('course_name','course','course_id',$course_id);

            $data['back_url'] = base_url('/Mobile_app/Course/my_course');
            $data['page_title'] = $courseName.' Category';
            $data['footer_icon'] = 'Home';

            $data['video'] = $this->course_videoModel->where('course_id',$course_id)->groupBy('course_cat_id')->findAll();

            echo view('Student/header',$data);
            echo view('Student/course_video_category_list',$data);
            echo view('Student/footer');
        }
    }

    public function video($course_cat_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            $courseName = get_data_by_id('category_name','course_category','course_cat_id',$course_cat_id);
            $catId = $this->course_videoModel->where('course_cat_id',$course_cat_id)->first()->course_id;
            $data['back_url'] = base_url('/Mobile_app/Course/category/'.$catId);
            $data['page_title'] = $courseName.' Video';
            $data['footer_icon'] = 'Home';

            $classID = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $groupID = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

            $data['video'] = $this->course_videoModel->where('course_cat_id',$course_cat_id)->findAll();

            echo view('Student/header',$data);
            echo view('Student/course_video_list',$data);
            echo view('Student/footer');
        }
    }

    public function details($course_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course');
            $data['page_title'] = 'Course Details';
            $data['footer_icon'] = 'Home';

            $classID = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $groupID = get_data_by_id('class_group_id','student','std_id',$this->session->std_id);

            $data['course'] = $this->courseModel->where('course_id',$course_id)->first();
            $data['course_id'] = $course_id;

            echo view('Student/header',$data);
            echo view('Student/course_details',$data);
            echo view('Student/footer');
        }
    }

    public function subscribe($course_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course/details/'.$course_id);
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
            return redirect()->to('/Mobile_app/login');
        } else {

            $courVid = $this->course_videoModel->where('course_video_id',$course_video_id)->first();

            $data['back_url'] = base_url('/Mobile_app/Course/video/'.$courVid->course_cat_id);
            $data['page_title'] = 'Course Video';
            $data['footer_icon'] = 'Home';


            $data['video'] = $courVid;

            echo view('Student/header',$data);
            echo view('Student/course_video',$data);
            echo view('Student/footer');
        }
    }
    
    public function sub_action(){
        $data['course_id'] = $this->request->getPost('course_id');
        $data['std_id'] = $this->session->std_id;
        $data['subs_time'] = '1';
        $data['status'] = '1';
        $terms = $this->request->getPost('terms');

        $this->validation->setRules([
            'course_id' => ['label' => 'Course', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('/Course/subscribe/'.$data['course_id']);
        } else {
            if (!empty($terms)) {
                $this->course_subscribeModel->insert($data);
                return redirect()->to('/Mobile_app/Course/success/' . $data['course_id']);
            }else{
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Terms fields required!</div>');
                return redirect()->to('/Course/subscribe/'.$data['course_id']);
            }
        }

    }

    public function success($course_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course/my_course/');
            $data['page_title'] = 'Course Subscribe success';
            $data['footer_icon'] = 'Home';


            echo view('Student/header',$data);
            echo view('Student/success_subscribe',$data);
            echo view('Student/footer');
        }
    }

    public function show_video(){
        $course_video_id = $this->request->getPost('course_video_id');
        $video = $this->course_videoModel->where('course_video_id',$course_video_id)->first();

        //print $video->URL;
        print '<iframe src="https://www.youtube-nocookie.com/embed/'.$video->URL.'" title="YouTube video player" frameborder="20" allow="accelerometer; autoplay; clipboard-write;  encrypted-media=0; gyroscope; picture-in-picture" ></iframe>';
    }



}
