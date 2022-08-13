<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\History_user_coin_Model;
use App\Models\History_user_point_Model;
use App\Models\Mcq_exam_joinedModel;
use App\Models\Skill_quizModel;
use App\Models\Skill_subjectModel;
use App\Models\Skill_videoModel;
use App\Models\StudentModel;


class Skill_development extends BaseController
{
    protected $validation;
    protected $session;
    protected $skill_subjectModel;
    protected $skill_videoModel;
    protected $skill_quizModel;
    protected $mcq_exam_joinedModel;
    protected $studentModel;
    protected $history_user_point_Model;
    protected $history_user_coin_Model;

    public function __construct()
    {
        $this->skill_subjectModel = new Skill_subjectModel();
        $this->skill_videoModel = new Skill_videoModel();
        $this->skill_quizModel = new Skill_quizModel();
        $this->mcq_exam_joinedModel = new Mcq_exam_joinedModel();
        $this->studentModel = new StudentModel();
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
            $data['page_title'] = 'Skill Development';
            $data['footer_icon'] = 'Home';

            $data['subject'] = $this->skill_subjectModel->findAll();

            echo view('Student/header',$data);
            echo view('Student/skill_subject',$data);
            echo view('Student/footer');
        }
    }

    public function video_list($subjectId)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {
            $data['back_url'] = base_url('/Student/Skill_development');
            $data['page_title'] = 'Skill Development Video';
            $data['footer_icon'] = 'Home';

            unset($_SESSION['mcq_joined_id']);
            unset($_SESSION['mcq_exam']);

            $data['video'] = $this->skill_videoModel->where('skill_subject_id',$subjectId)->findAll();

            echo view('Student/header',$data);
            echo view('Student/skill_video',$data);
            echo view('Student/footer');
        }
    }

    public function video($skill_video_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {
            $data['video'] = $this->skill_videoModel->where('skill_video_id',$skill_video_id)->first();

            $data['back_url'] = base_url('/Student/Skill_development/video_list/'.$data['video']->skill_subject_id);
            $data['page_title'] = 'Video View';
            $data['footer_icon'] = 'Home';

            $data['check'] = already_join_mcq_check($skill_video_id);
            $data['checkMCQ'] = $this->skill_quizModel->where('skill_video_id',$skill_video_id)->countAllResults();

            echo view('Student/header',$data);
            echo view('Student/skill_video_view',$data);
            echo view('Student/footer');
        }
    }

    public function join_mcq($skill_video_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {


            $data['back_url'] = base_url('/Student/Skill_development/video/'.$skill_video_id);
            $data['page_title'] = 'Video MCQ';
            $data['footer_icon'] = 'Home';

            $data['video'] = get_data_by_id('URL','skill_video','skill_video_id',$skill_video_id);

            $data['mcq'] = $this->skill_quizModel->where('skill_video_id',$skill_video_id)->paginate(1);
            $data['pager'] = $this->skill_quizModel->pager;


            $check = already_join_mcq_check($skill_video_id);
            if ($check == 0) {
                $joinData = array(
                    'skill_video_id' => $skill_video_id,
                    'std_id' => $this->session->std_id,
                    'createdBy' => $this->session->std_id,
                );
                $this->mcq_exam_joinedModel->insert($joinData);
                $insertId = $this->mcq_exam_joinedModel->getInsertID();
                $this->session->set('mcq_joined_id',$insertId);
            }

            echo view('Student/header',$data);
            echo view('Student/skill_video_mcq',$data);
            echo view('Student/footer');
        }
    }

    public function ans_quiz(){
        $qId = $this->request->getPost('quizId');
        $ans = $this->request->getPost('ans');

        $allMcqexam = empty($this->session->mcq_exam) ? array() : $this->session->mcq_exam;
        $quizans = [
            'quizId'=>$qId,
            'quizAns'=>$ans,
        ];
        array_push($allMcqexam,$quizans);
        $this->session->set('mcq_exam',$allMcqexam);

        $corAns = get_data_by_id('correct_answer','skill_questions','skill_question_id',$qId);
        if ($corAns == $ans){

            $oldCorAns = get_data_by_id('correct_answers','mcq_exam_joined','mcq_joined_id',$this->session->mcq_joined_id);
            $oldPoints = get_data_by_id('earn_points','mcq_exam_joined','mcq_joined_id',$this->session->mcq_joined_id);
            $oldCoins = get_data_by_id('earn_coins','mcq_exam_joined','mcq_joined_id',$this->session->mcq_joined_id);

            $points_video_mcq = get_data_by_id('value','settings','label','points_video_mcq');

            $data['mcq_joined_id'] = $this->session->mcq_joined_id;

            $data['correct_answers'] = $oldCorAns + 1;
            $data['earn_points'] = $oldPoints + $points_video_mcq;
            $data['earn_coins'] = $oldCoins + $points_video_mcq;

            $this->mcq_exam_joinedModel->update($data['mcq_joined_id'],$data);



            $myOldPoint = get_data_by_id('point','student','std_id',$this->session->std_id);
            $myOldCoin = get_data_by_id('coin','student','std_id',$this->session->std_id);
            $stData['std_id'] = $this->session->std_id;
            $stData['point'] = $myOldPoint + $points_video_mcq;
            $stData['coin'] = $myOldCoin + $points_video_mcq;
            $this->studentModel->update($stData['std_id'],$stData);



            //point history create
            $point_history = array(
                'std_id' => $this->session->std_id,
                'mcq_joined_id' => $this->session->mcq_joined_id,
                'particulars' => 'Skill development quiz point get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_video_mcq,
                'rest_balance' => $myOldPoint + $points_video_mcq,
            );
            $this->history_user_point_Model->insert($point_history);



            //coin history create
            $coin_history = array(
                'std_id' => $this->session->std_id,
                'mcq_joined_id' => $this->session->mcq_joined_id,
                'particulars' => 'Skill development quiz coin get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_video_mcq,
                'rest_balance' => $myOldCoin + $points_video_mcq,
            );
            $this->history_user_coin_Model->insert($coin_history);

        }else{
            $oldInCorAns = get_data_by_id('incorrect_answers','mcq_exam_joined','mcq_joined_id',$this->session->mcq_joined_id);
            $data2['mcq_joined_id'] = $this->session->mcq_joined_id;
            $data2['incorrect_answers'] = $oldInCorAns + 1;
            $this->mcq_exam_joinedModel->update($data2['mcq_joined_id'],$data2);
        }
    }

    public function result_view(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Skill_development');
            $data['page_title'] = 'Skill Development MCQ Result';
            $data['footer_icon'] = 'Home';

            if (empty($this->session->mcq_joined_id)){
                return redirect()->to('/Student/Skill_development');
            }

            $data['result'] = $this->mcq_exam_joinedModel->where('mcq_joined_id',$this->session->mcq_joined_id)->first();

            echo view('Student/header',$data);
            echo view('Student/mcq_exam_result',$data);
            echo view('Student/footer');
        }
    }



}
