<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\History_user_coin_Model;
use App\Models\History_user_point_Model;
use App\Models\StudentModel;
use App\Models\Vocabulary_exam_joinedModel;
use App\Models\Vocabulary_exam_r_quizModel;
use App\Models\Vocabulary_examModel;
use App\Models\Vocabulary_readModel;
use App\Models\VocabularyModel;


class Vocabulary extends BaseController
{
    protected $validation;
    protected $session;
    protected $studentModel;
    protected $vocabularyModel;
    protected $vocabulary_examModel;
    protected $vocabulary_exam_r_quizModel;
    protected $vocabulary_exam_joinedModel;
    protected $history_user_point_Model;
    protected $history_user_coin_Model;
    protected $vocabulary_read_Model;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->vocabularyModel = new VocabularyModel();
        $this->vocabulary_examModel = new Vocabulary_examModel();
        $this->vocabulary_exam_r_quizModel = new Vocabulary_exam_r_quizModel();
        $this->vocabulary_exam_joinedModel = new Vocabulary_exam_joinedModel();
        $this->history_user_point_Model = new History_user_point_Model();
        $this->history_user_coin_Model = new History_user_coin_Model();
        $this->vocabulary_read_Model = new Vocabulary_readModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $std_id = $this->session->std_id;

            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'Vocabulary';
            $data['footer_icon'] = 'Home';
            //session unset
            unset($_SESSION['voc_mcq_joined_id']);
            unset($_SESSION['voc_quiz_exam']);

            $vocLimit = get_data_by_id('value','settings','label','vocabulary_quiz_view_frontEnd');

            //insert vocabulary_read data (start)
            $count = $this->vocabulary_read_Model->where('std_id',$std_id)->countAllResults();
            if (empty($count)){
                $vocReData = [
                    'std_id' => $std_id,
                    'count' => '0',
                    'last_seen_date' => date('Y-m-d'),
                    'createdBy' => $std_id,
                ];
                $this->vocabulary_read_Model->insert($vocReData);
            }
            //insert vocabulary_read data (end)


            //update count daily data (start)
            $checkSeen = $this->vocabulary_read_Model->where('std_id',$std_id)->first();
            if ($checkSeen->last_seen_date < date('Y-m-d')){
                $viewCount = $this->vocabulary_read_Model->where('std_id',$std_id)->first();
                $total = $viewCount->count + $vocLimit;
                $vocReData = [
                    'count' => $total,
                    'last_seen_date' => date('Y-m-d'),
                    'updatedBy' => $std_id,
                ];
                $idData['voc_read_id'] = $viewCount->voc_read_id;
                $this->vocabulary_read_Model->update($idData,$vocReData);
            }
            //update count daily data (end)


            //limit count (start)
            $viewCount = $this->vocabulary_read_Model->where('std_id',$std_id)->first();
            //limit count (end)

            $data['vocabulary'] = $this->vocabularyModel->findAll($vocLimit,$viewCount->count);

            $data['vocabularyExam'] = $this->vocabulary_examModel->where('status','Published')->where('published_date',date('Y-m-d'))->findAll();


            echo view('Student/header',$data);
            echo view('Student/vocabulary',$data);
            echo view('Student/footer');
        }
    }

    public function exam_join($voc_exam_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Vocabulary');
            $data['page_title'] = 'Vocabulary Quiz Exam';
            $data['footer_icon'] = 'Home';


            $check = already_join_voc_exam_check($voc_exam_id);
            if ($check == 0) {
                $joinData = array(
                    'voc_exam_id' => $voc_exam_id,
                    'std_id' => $this->session->std_id,
                    'createdBy' => $this->session->std_id,
                );
                $this->vocabulary_exam_joinedModel->insert($joinData);
                $insertId = $this->vocabulary_exam_joinedModel->getInsertID();
                $this->session->set('voc_mcq_joined_id',$insertId);
            }


            $data['quiz'] = $this->vocabulary_exam_r_quizModel->where('voc_exam_id',$voc_exam_id)->paginate(1);
            $data['pager'] = $this->vocabulary_exam_r_quizModel->pager;
            $data['voc_exam_id'] = $voc_exam_id;


            echo view('Student/header',$data);
            echo view('Student/vocabulary_exam',$data);
            echo view('Student/footer');

        }
    }

    public function ans_quiz(){
        $qId = $this->request->getPost('quizId');
        $ans = $this->request->getPost('ans');


        $vocquizexam = empty($this->session->voc_quiz_exam) ? array() : $this->session->voc_quiz_exam;
        $quizans = [
            'quizId' => $qId,
            'quizAns' => $ans,
        ];
        array_push($vocquizexam,$quizans);
        $this->session->set('voc_quiz_exam',$vocquizexam);

        $corAns = get_data_by_id('correct_answer','vocabulary_quiz','voc_quiz_id',$qId);
        if ($corAns == $ans){
            $oldCorAns = get_data_by_id('correct_answers','vocabulary_exam_joined','voc_mcq_joined_id',$this->session->voc_mcq_joined_id);
            $oldPoints = get_data_by_id('earn_points','vocabulary_exam_joined','voc_mcq_joined_id',$this->session->voc_mcq_joined_id);
            $oldCoins = get_data_by_id('earn_coins','vocabulary_exam_joined','voc_mcq_joined_id',$this->session->voc_mcq_joined_id);

            $points_vocabulary_mcq = get_data_by_id('value','settings','label','points_vocabulary_mcq');

            $data['voc_mcq_joined_id'] = $this->session->voc_mcq_joined_id;
            $data['correct_answers'] = $oldCorAns + 1;
            $data['earn_points'] = $oldPoints + $points_vocabulary_mcq;
            $data['earn_coins'] = $oldCoins + $points_vocabulary_mcq;
            $this->vocabulary_exam_joinedModel->update($data['voc_mcq_joined_id'],$data);


            $myOldPoint = get_data_by_id('point','student','std_id',$this->session->std_id);
            $myOldCoin = get_data_by_id('coin','student','std_id',$this->session->std_id);
            $stData['std_id'] = $this->session->std_id;
            $stData['point'] = $myOldPoint + $points_vocabulary_mcq;
            $stData['coin'] = $myOldCoin + $points_vocabulary_mcq;
            $this->studentModel->update($stData['std_id'],$stData);


            //point history create
            $point_history = array(
                'std_id' => $this->session->std_id,
                'mcq_joined_id' => $this->session->voc_mcq_joined_id,
                'particulars' => 'Vocabulary quiz point get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_vocabulary_mcq,
                'rest_balance' => $myOldPoint + $points_vocabulary_mcq,
            );
            $this->history_user_point_Model->insert($point_history);



            //coin history create
            $coin_history = array(
                'std_id' => $this->session->std_id,
                'mcq_joined_id' => $this->session->voc_mcq_joined_id,
                'particulars' => 'Vocabulary quiz coin get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_vocabulary_mcq,
                'rest_balance' => $myOldCoin + $points_vocabulary_mcq,
            );
            $this->history_user_coin_Model->insert($coin_history);

        }else{
            $oldInCorAns = get_data_by_id('incorrect_answers','vocabulary_exam_joined','voc_mcq_joined_id',$this->session->voc_mcq_joined_id);
            $data2['voc_mcq_joined_id'] = $this->session->voc_mcq_joined_id;
            $data2['incorrect_answers'] = $oldInCorAns + 1;
            $this->vocabulary_exam_joinedModel->update($data2['voc_mcq_joined_id'],$data2);
        }

    }

    public function result_view(){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {
            if (empty($this->session->voc_mcq_joined_id)){
                return redirect()->to('/Mobile_app/Vocabulary');
            }

            $data['back_url'] = base_url('/Mobile_app/Vocabulary');
            $data['page_title'] = 'Vocabulary Quiz Result';
            $data['footer_icon'] = 'Home';

            $data['result'] = $this->vocabulary_exam_joinedModel->where('voc_mcq_joined_id',$this->session->voc_mcq_joined_id)->first();

            echo view('Student/header',$data);
            echo view('Student/vocabulary_exam_result',$data);
            echo view('Student/footer');
        }

    }




}
