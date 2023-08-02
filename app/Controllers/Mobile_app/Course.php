<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\Course_quizModel;
use App\Models\Course_subscribeModel;
use App\Models\Course_videoModel;
use App\Models\CourseModel;
use App\Models\History_user_coin_Model;
use App\Models\History_user_point_Model;
use App\Models\StudentModel;


class Course extends BaseController
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

    public function __construct()
    {
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
            //session unset
            unset($_SESSION['course_exam_joined_id']);
            unset($_SESSION['quizCourse']);
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

            $table2 = DB()->table('student');
            $data['std_info'] = $table2->where('std_id', $this->session->std_id)->get()->getRow();

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
            $std_id = $this->session->std_id;

            $table = DB()->table('course_quiz');
//            $data['checkExam'] = $table->join('course_exam_joined', 'course_exam_joined.course_video_id = course_quiz.course_video_id')->where('course_quiz.course_video_id',$course_video_id)->where('course_exam_joined.std_id', $std_id)->countAllResults();
            $data['checkExam'] = $table->where('course_video_id',$course_video_id)->countAllResults();


            $data['video'] = $courVid;

            echo view('Student/header',$data);
            echo view('Student/course_video',$data);
            echo view('Student/footer');
        }
    }

    public function join_quiz($course_video_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course/video_view/'.$course_video_id);
            $data['page_title'] = 'Course Video Quiz';
            $data['footer_icon'] = 'Home';
            $std_id = $this->session->std_id;

            $data['quiz'] = $this->course_quizModel->where('course_video_id',$course_video_id)->paginate(1);
            $data['pager'] = $this->course_quizModel->pager;

            $check = already_join_course_exam_check($course_video_id);
            if ($check == 0) {
                $joinData = array(
                    'course_video_id' => $course_video_id,
                    'std_id' => $this->session->std_id,
                    'createdBy' => $this->session->std_id,
                );
                $table = DB()->table('course_exam_joined');
                $table->insert($joinData);
                $insertId = DB()->insertID();
                $this->session->set('course_exam_joined_id',$insertId);
            }

            echo view('Student/header',$data);
            echo view('Student/course_video_quiz',$data);
            echo view('Student/footer');
        }
    }

    public function point_calculet(){
        $allCoursequiz = empty($this->session->quizCourse) ? array() : $this->session->quizCourse;
        $qId = $this->request->getPost('quizId');
        $ans = $this->request->getPost('ans');

        $quizans = [
            'quizId'=>$qId,
            'quizAns'=>$ans,
        ];
        array_push($allCoursequiz,$quizans);

        $this->session->set('quizCourse',$allCoursequiz);


        $corAns = get_data_by_id('correct_answer','course_quiz','course_quiz_id',$qId);
        if ($corAns == $ans){

            $oldCorAns = get_data_by_id('correct_answers','course_exam_joined','course_exam_joined_id',$this->session->course_exam_joined_id);

            $oldPoints = get_data_by_id('earn_points','course_exam_joined','course_exam_joined_id',$this->session->course_exam_joined_id);
            $oldCoins = get_data_by_id('earn_coins','course_exam_joined','course_exam_joined_id',$this->session->course_exam_joined_id);

            $points_quiz = get_data_by_id('value','settings','label','points_course_mcq');

            $course_exam_joined_id = $this->session->course_exam_joined_id;

            $data['correct_answers'] = $oldCorAns + 1;
            $data['earn_points'] = $oldPoints + $points_quiz;
            $data['earn_coins'] = $oldCoins + $points_quiz;

            $table = DB()->table('course_exam_joined');
            $table->where('course_exam_joined_id',$course_exam_joined_id)->update($data);


            $myOldPoint = get_data_by_id('point','student','std_id',$this->session->std_id);
            $myOldCoin = get_data_by_id('coin','student','std_id',$this->session->std_id);
            $stData['std_id'] = $this->session->std_id;
            $stData['point'] = $myOldPoint + $points_quiz;
            $stData['coin'] = $myOldCoin + $points_quiz;
            $this->studentModel->update($stData['std_id'],$stData);


            //point history create
            $point_history = array(
                'std_id' => $this->session->std_id,
                'course_exam_joined_id' => $this->session->course_exam_joined_id,
                'particulars' => 'Course quiz point get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_quiz,
                'rest_balance' => $myOldPoint + $points_quiz,
            );
            $this->history_user_point_Model->insert($point_history);



            //coin history create
            $coin_history = array(
                'std_id' => $this->session->std_id,
                'course_exam_joined_id' => $this->session->course_exam_joined_id,
                'particulars' => 'Video quiz coin get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_quiz,
                'rest_balance' => $myOldCoin + $points_quiz,
            );
            $this->history_user_coin_Model->insert($coin_history);

        }else{
            $oldInCorAns = get_data_by_id('incorrect_answers','course_exam_joined','course_exam_joined_id',$this->session->course_exam_joined_id);
//            $data2['course_exam_joined_id'] = $this->session->course_exam_joined_id;
            $data2['incorrect_answers'] = $oldInCorAns + 1;
            $tabCor = DB()->table('course_exam_joined');
            $tabCor->where('course_exam_joined_id',$this->session->course_exam_joined_id)->update($data2);
        }
    }

    public function result_view(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course/my_course');
            $data['page_title'] = 'Course Result';
            $data['footer_icon'] = 'Home';

            $tabCor = DB()->table('course_exam_joined');
            $data['result'] = $tabCor->where('course_exam_joined_id',$this->session->course_exam_joined_id)->get()->getRow();

            echo view('Student/header',$data);
            echo view('Student/course_quiz_result',$data);
            echo view('Student/footer');
        }
    }

    
    public function sub_action(){
        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $data['course_id'] = $this->request->getPost('opt_a');
        $data['std_id'] = $this->request->getPost('opt_b');
        $data['std_name'] = $this->request->getPost('cus_name');
        $data['subs_time'] = '1';
        $data['status'] = '1';
        $terms = $this->request->getPost('opt_c');

        $paid_amount = (float) $this->request->getPost('amount');
        $course_amount = (float) get_data_by_id('price', 'course', 'course_id', $data['course_id']);

        if (!empty($pay_status == 'Successful')) {
            $sessionArray = array(
                'std_id' => $data['std_id'],
                'name' => $data['std_name'],
                'isLoggedInStudent' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (Start)

        // Checking if the paid amount is correct with course amount
        if ($paid_amount !== $course_amount){
            return redirect()->to('Mobile_app/Course/details/'.$data['course_id']);
        }

        // Check login status before execution
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            // Checking the validation
            $this->validation->setRules([
                'course_id' => ['label' => 'Course', 'rules' => 'required'],
            ]);

            if ($this->validation->run($data) == FALSE) {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->validation->listErrors() . '</div>');
                return redirect()->to('/Mobile_app/Course/subscribe/' . $data['course_id']);
            } else {

                //Checking if it checks our terms and condition.
                if (!empty($terms)) {
                    DB()->transStart();
                    // Inserting into course_subscription table
                    $this->course_subscribeModel->insert($data);

                    $course_subscribe_id = $this->course_subscribeModel->getInsertID();

                    // Inserting into payment table (Start)
                    $data2['course_subscribe_id'] = empty($course_subscribe_id) ? null : $course_subscribe_id;
                    $data2['std_id'] = empty($this->session->std_id) ? null : $this->session->std_id;
                    $data2['aam_service_charge'] = $this->request->getPost('pg_service_charge_bdt');
                    $data2['amount_original'] = $this->request->getPost('amount_original');
                    $data2['pay_status'] = $this->request->getPost('pay_status');
                    $data2['aam_txnid'] = $this->request->getPost('pg_txnid');
                    $data2['mer_txnid'] = $this->request->getPost('mer_txnid');
                    $data2['store_amount'] = $this->request->getPost('store_amount');

                    $table2 = DB()->table('payment');
                    $table2->insert($data2);
                    // Inserting into payment table (End)
                    DB()->transComplete();

                    // If sql transaction failed.
                    if (DB()->transStatus() === false) {
                        $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Transection Failed!</div>');
                        return redirect()->to('/Mobile_app/Course/canceled/');
                    }

                    return redirect()->to('/Mobile_app/Course/success/' . $data['course_id']);
                } else {
                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Terms fields required!</div>');
                    return redirect()->to('/Mobile_app/Course/subscribe/' . $data['course_id']);
                }
            }
        }
    }

    public function success($course_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course/my_course/');
            $data['page_title'] = 'Course Subscription Successful!';
            $data['footer_icon'] = 'Home';


            echo view('Student/header',$data);
            echo view('Student/course_subscribe_success',$data);
            echo view('Student/footer');
        }
    }

    public function failed_action(){
        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $data['course_id'] = $this->request->getPost('opt_a');
        $data['std_id'] = $this->request->getPost('opt_b');
        $data['std_name'] = $this->request->getPost('cus_name');
        if (!empty($pay_status == 'Failed')) {
            $sessionArray = array(
                'std_id' => $data['std_id'],
                'name' => $data['std_name'],
                'isLoggedInStudent' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (Start)


        // Check login status before execution
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            // Inserting into payment table (Start)
            $data2['course_subscribe_id'] = null;
            $data2['std_id'] = empty($this->session->std_id) ? null : $this->session->std_id;
            $data2['aam_service_charge'] = $this->request->getPost('pg_service_charge_bdt');
            $data2['amount_original'] = $this->request->getPost('amount_original');
            $data2['pay_status'] = $this->request->getPost('pay_status');
            $data2['aam_txnid'] = $this->request->getPost('pg_txnid');
            $data2['mer_txnid'] = $this->request->getPost('mer_txnid');
            $data2['store_amount'] = $this->request->getPost('store_amount');

            $table2 = DB()->table('payment');
            $table2->insert($data2);

            return redirect()->to('/Mobile_app/Course/failed/');
        }
    }

    public function failed(){
        // Checking if the payment status is success (Start)
        $pay_status = $this->request->getPost('pay_status');
        $data['course_id'] = $this->request->getPost('opt_a');
        $data['std_id'] = $this->request->getPost('opt_b');
        $data['std_name'] = $this->request->getPost('cus_name');
        if (!empty($pay_status == 'Failed')) {
            $sessionArray = array(
                'std_id' => $data['std_id'],
                'name' => $data['std_name'],
                'isLoggedInStudent' => TRUE
            );
            $this->session->set($sessionArray);
        }
        // Checking if the payment status is success (Start)


        // Check login status before execution
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course/');
            $data['page_title'] = 'Course Subscribe Failed.';
            $data['footer_icon'] = 'Home';

            echo view('Student/header',$data);
            echo view('Student/course_subscribe_failed',$data);
            echo view('Student/footer');
        }
    }

    public function canceled(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Course/');
            $data['page_title'] = 'Course Subscribe Canceled.';
            $data['footer_icon'] = 'Home';

            echo view('Student/header',$data);
            echo view('Student/course_subscribe_canceled',$data);
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
