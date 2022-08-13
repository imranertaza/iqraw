<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\History_user_coin_Model;
use App\Models\History_user_point_Model;
use App\Models\Quiz_exam_joinedModel;
use App\Models\Quiz_questionModel;
use App\Models\QuizModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use CodeIgniter\Database\RawSql;


class Quiz extends BaseController
{
    protected $validation;
    protected $session;
    protected $studentModel;
    protected $subjectModel;
    protected $quiz_examModel;
    protected $quiz_questionModel;
    protected $quiz_exam_joinedModel;
    protected $history_user_point_Model;
    protected $history_user_coin_Model;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->subjectModel = new SubjectModel();
        $this->quiz_examModel = new QuizModel();
        $this->quiz_exam_joinedModel = new Quiz_exam_joinedModel();
        $this->quiz_questionModel = new Quiz_questionModel();
        $this->history_user_point_Model = new History_user_point_Model();
        $this->history_user_coin_Model = new History_user_coin_Model();
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
            $data['page_title'] = 'Quiz';
            $data['footer_icon'] = 'Home';

            $classId = get_data_by_id('class_id','student','std_id',$this->session->std_id);
            $data['subject'] = $this->subjectModel->where('class_id',$classId)->findAll();

            echo view('Student/header',$data);
            echo view('Student/quiz',$data);
            echo view('Student/footer');
        }
    }

    public function exam($subject_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Quiz');
            $data['page_title'] = 'Quiz Exam';
            $data['footer_icon'] = 'Home';

            //session unset
            unset($_SESSION['qe_joined_id']);
            unset($_SESSION['quiz_exam']);

            $data['quiz_exam'] = $this->quiz_examModel->where('subject_id',$subject_id)->findAll();

            $table = DB()->table('quiz_exam_joined');
            $data['join_quiz_exam'] =$table->select('*')->join('quiz_exam_info','quiz_exam_info.quiz_exam_info_id = quiz_exam_joined.quiz_exam_info_id')->where('quiz_exam_info.subject_id',$subject_id)->get()->getResult();


            echo view('Student/header',$data);
            echo view('Student/quiz_exam',$data);
            echo view('Student/footer');

        }
    }

    public function question($quiz_exam_info_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Quiz');
            $data['page_title'] = 'Quiz Question';
            $data['footer_icon'] = 'Home';

            $check = already_join_check($quiz_exam_info_id);
            if ($check == 0) {
                $joinData = array(
                    'quiz_exam_info_id' => $quiz_exam_info_id,
                    'std_id' => $this->session->std_id,
                    'createdBy' => $this->session->std_id,
                );
                $this->quiz_exam_joinedModel->insert($joinData);
                $insertId = $this->quiz_exam_joinedModel->getInsertID();
                $this->session->set('qe_joined_id',$insertId);
            }

            $data['quiz'] = $this->quiz_questionModel->where('quiz_exam_info_id',$quiz_exam_info_id)->paginate(1);
            $data['pager'] = $this->quiz_questionModel->pager;
            $data['quiz_exam_info_id'] = $quiz_exam_info_id;

            echo view('Student/header',$data);
            echo view('Student/quiz_exam_question',$data);
            echo view('Student/footer');

        }
    }

    public function result(){
        $qId = $this->request->getPost('quizId');
        $ans = $this->request->getPost('ans');

        $allquizexam = empty($this->session->quiz_exam) ? array() : $this->session->quiz_exam;
        $quizans = [
            'quizId'=>$qId,
            'quizAns'=>$ans,
        ];
        array_push($allquizexam,$quizans);
        $this->session->set('quiz_exam',$allquizexam);



        $corAns = get_data_by_id('correct_answer','quiz_exam_questions','quiz_question_id',$qId);
        if ($corAns == $ans){
            $oldCorAns = get_data_by_id('correct_answers','quiz_exam_joined','qe_joined_id',$this->session->qe_joined_id);
            $oldPoints = get_data_by_id('earn_points','quiz_exam_joined','qe_joined_id',$this->session->qe_joined_id);
            $oldCoins = get_data_by_id('earn_coins','quiz_exam_joined','qe_joined_id',$this->session->qe_joined_id);

            $points_semister_mcq = get_data_by_id('value','settings','label','points_semister_mcq');

            $data['qe_joined_id'] = $this->session->qe_joined_id;
            $data['correct_answers'] = $oldCorAns + 1;
            $data['earn_points'] = $oldPoints + $points_semister_mcq;
            $data['earn_coins'] = $oldCoins + $points_semister_mcq;
            $this->quiz_exam_joinedModel->update($data['qe_joined_id'],$data);


            //point-coin update
            $myOldPoint = get_data_by_id('point','student','std_id',$this->session->std_id);
            $myOldCoin = get_data_by_id('coin','student','std_id',$this->session->std_id);
            $stData['std_id'] = $this->session->std_id;
            $stData['point'] = $myOldPoint + $points_semister_mcq;
            $stData['coin'] = $myOldCoin + $points_semister_mcq;
            $this->studentModel->update($stData['std_id'],$stData);


            //point history create
            $point_history = array(
                'std_id' => $this->session->std_id,
                'qe_joined_id' => $this->session->qe_joined_id,
                'particulars' => 'Quiz point get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_semister_mcq,
                'rest_balance' => $myOldPoint + $points_semister_mcq,
            );
            $this->history_user_point_Model->insert($point_history);



            //coin history create
            $coin_history = array(
                'std_id' => $this->session->std_id,
                'qe_joined_id' => $this->session->qe_joined_id,
                'particulars' => 'Quiz coin get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_semister_mcq,
                'rest_balance' => $myOldCoin + $points_semister_mcq,
            );
            $this->history_user_coin_Model->insert($coin_history);



        }else{
            $oldInCorAns = get_data_by_id('incorrect_answers','quiz_exam_joined','qe_joined_id',$this->session->qe_joined_id);
            $data2['qe_joined_id'] = $this->session->qe_joined_id;
            $data2['incorrect_answers'] = $oldInCorAns + 1;
            $this->quiz_exam_joinedModel->update($data2['qe_joined_id'],$data2);
        }

    }

    public function result_view(){

        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            if (empty($this->session->qe_joined_id)){
                return redirect()->to('/Student/Quiz');
            }

            $data['back_url'] = base_url('/Student/Quiz');
            $data['page_title'] = 'Quiz Result';
            $data['footer_icon'] = 'Home';

            $table = DB()->table('quiz_exam_joined');
            $data['result'] = $table->where('qe_joined_id',$this->session->qe_joined_id)->get()->getRow();

            echo view('Student/header',$data);
            echo view('Student/quiz_exam_result',$data);
            echo view('Student/footer');
        }

    }

    public function exam_result($qe_joined_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Quiz');
            $data['page_title'] = 'Quiz Result';
            $data['footer_icon'] = 'Home';

            $table = DB()->table('quiz_exam_joined');
            $data['result'] = $table->where('qe_joined_id',$qe_joined_id)->get()->getRow();

            echo view('Student/header',$data);
            echo view('Student/exam_result',$data);
            echo view('Student/footer');
        }
    }




}
