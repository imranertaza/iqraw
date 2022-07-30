<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\Quiz_exam_joinedModel;
use App\Models\Quiz_questionModel;
use App\Models\QuizModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use App\Models\Vocabulary_exam_joinedModel;
use App\Models\Vocabulary_exam_r_quizModel;
use App\Models\Vocabulary_examModel;
use App\Models\VocabularyModel;
use CodeIgniter\Database\RawSql;


class Vocabulary extends BaseController
{
    protected $validation;
    protected $session;
    protected $studentModel;
    protected $vocabularyModel;
    protected $vocabulary_examModel;
    protected $vocabulary_exam_r_quizModel;
    protected $vocabulary_exam_joinedModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->vocabularyModel = new VocabularyModel();
        $this->vocabulary_examModel = new Vocabulary_examModel();
        $this->vocabulary_exam_r_quizModel = new Vocabulary_exam_r_quizModel();
        $this->vocabulary_exam_joinedModel = new Vocabulary_exam_joinedModel();
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
            $data['page_title'] = 'Vocabulary';

            //session unset
            unset($_SESSION['voc_mcq_joined_id']);
            unset($_SESSION['voc_quiz_exam']);

            $vocLimit = get_data_by_id('value','settings','label','vocabulary_quiz_view_frontEnd');

            $data['vocabulary'] = $this->vocabularyModel->orderBy('voc_id', 'RANDOM')->findAll($vocLimit);
            $data['vocabularyExam'] = $this->vocabulary_examModel->where('status','Published')->where('published_date',date('Y-m-d'))->findAll();


            echo view('Student/header',$data);
            echo view('Student/vocabulary',$data);
            echo view('Student/footer');
        }
    }

    public function exam_join($voc_exam_id){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Vocabulary');
            $data['page_title'] = 'Vocabulary Quiz Exam';


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
            return redirect()->to('/login');
        } else {
            if (empty($this->session->voc_mcq_joined_id)){
                return redirect()->to('/Student/Vocabulary');
            }

            $data['back_url'] = base_url('/Student/Vocabulary');
            $data['page_title'] = 'Vocabulary Quiz Result';

            $data['result'] = $this->vocabulary_exam_joinedModel->where('voc_mcq_joined_id',$this->session->voc_mcq_joined_id)->first();

            echo view('Student/header',$data);
            echo view('Student/vocabulary_exam_result',$data);
            echo view('Student/footer');
        }

    }




}
