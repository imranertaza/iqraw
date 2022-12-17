<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\Chapter_exam_joinedModel;
use App\Models\Chapter_quizModel;
use App\Models\Chapter_videoModel;
use App\Models\ChapterModel;
use App\Models\History_user_coin_Model;
use App\Models\History_user_point_Model;
use App\Models\School_classModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;


class VideoQuiz extends BaseController
{
    protected $validation;
    protected $session;
    protected $schoolClassModel;
    protected $subjectModel;
    protected $chapterModel;
    protected $chapterVideoModel;
    protected $chapterQuizModel;
    protected $chapter_exam_joinedModel;
    protected $studentModel;
    protected $history_user_point_Model;
    protected $history_user_coin_Model;

    public function __construct()
    {
        $this->schoolClassModel = new School_classModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterModel = new ChapterModel();
        $this->chapterVideoModel = new Chapter_videoModel();
        $this->chapter_exam_joinedModel = new Chapter_exam_joinedModel();
        $this->chapterQuizModel = new Chapter_quizModel();
        $this->studentModel = new StudentModel();
        $this->history_user_point_Model = new History_user_point_Model();
        $this->history_user_coin_Model = new History_user_coin_Model();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();

    }
    public function index($chapterId)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $pager = \Config\Services::pager();
            $chapter = get_data_by_id('name','chapter','chapter_id',$chapterId);
            $subjectId = get_data_by_id('subject_id','chapter','chapter_id',$chapterId);
            $data['back_url'] = base_url('/Mobile_app/Subject/chapter/'.$subjectId);
            $data['page_title'] = $chapter;
            $data['footer_icon'] = 'Home';



            $data['video'] = $this->chapterVideoModel->where('chapter_id',$chapterId)->first();
            $data['quiz'] = $this->chapterQuizModel->where('chapter_id',$chapterId)->paginate(1);
            $data['pager'] = $this->chapterQuizModel->pager;

            echo view('Student/header',$data);
            echo view('Student/chapter_content',$data);
            echo view('Student/footer');
        }
    }

    public function join_quiz($chapterId){
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $pager = \Config\Services::pager();
            $chapter = get_data_by_id('name','chapter','chapter_id',$chapterId);
            $subjectId = get_data_by_id('subject_id','chapter','chapter_id',$chapterId);
            $data['back_url'] = base_url('/Mobile_app/Subject/chapter/'.$subjectId);
            $data['page_title'] = $chapter.' quiz';
            $data['footer_icon'] = 'Home';

            $data['quiz'] = $this->chapterQuizModel->where('chapter_id',$chapterId)->paginate(1);
            $data['pager'] = $this->chapterQuizModel->pager;
            $data['subjectId'] = $subjectId;

            $check = already_join_chapter_check($chapterId);
            if ($check == 0) {
                $joinData = array(
                    'chapter_id' => $chapterId,
                    'std_id' => $this->session->std_id,
                    'createdBy' => $this->session->std_id,
                );
                $this->chapter_exam_joinedModel->insert($joinData);
                $insertId = $this->chapter_exam_joinedModel->getInsertID();
                $this->session->set('chapter_joined_id',$insertId);
            }

            echo view('Student/header',$data);
            echo view('Student/chapter_content_quiz',$data);
            echo view('Student/footer');
        }
    }

    public function sessionUpdate(){
        $allquiz = empty($this->session->quiz) ? array() : $this->session->quiz;
        $qId = $this->request->getPost('quizId');
        $ans = $this->request->getPost('ans');

        $quizans = [
            'quizId'=>$qId,
            'quizAns'=>$ans,
        ];
        array_push($allquiz,$quizans);

        $this->session->set('quiz',$allquiz);


        $corAns = get_data_by_id('correct_answer','chapter_quiz','quiz_id',$qId);
        if ($corAns == $ans){

            $oldCorAns = get_data_by_id('correct_answers','chapter_exam_joined','chapter_joined_id',$this->session->chapter_joined_id);
            $oldPoints = get_data_by_id('earn_points','chapter_exam_joined','chapter_joined_id',$this->session->chapter_joined_id);
            $oldCoins = get_data_by_id('earn_coins','chapter_exam_joined','chapter_joined_id',$this->session->chapter_joined_id);

            $points_quiz = get_data_by_id('value','settings','label','points_chapter_mcq');

            $data['chapter_joined_id'] = $this->session->chapter_joined_id;

            $data['correct_answers'] = $oldCorAns + 1;
            $data['earn_points'] = $oldPoints + $points_quiz;
            $data['earn_coins'] = $oldCoins + $points_quiz;


            $this->chapter_exam_joinedModel->update($data['chapter_joined_id'],$data);


            $myOldPoint = get_data_by_id('point','student','std_id',$this->session->std_id);
            $myOldCoin = get_data_by_id('coin','student','std_id',$this->session->std_id);
            $stData['std_id'] = $this->session->std_id;
            $stData['point'] = $myOldPoint + $points_quiz;
            $stData['coin'] = $myOldCoin + $points_quiz;
            $this->studentModel->update($stData['std_id'],$stData);


            //point history create
            $point_history = array(
                'std_id' => $this->session->std_id,
                'chapter_joined_id' => $this->session->chapter_joined_id,
                'particulars' => 'Video quiz point get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_quiz,
                'rest_balance' => $myOldPoint + $points_quiz,
            );
            $this->history_user_point_Model->insert($point_history);



            //coin history create
            $coin_history = array(
                'std_id' => $this->session->std_id,
                'chapter_joined_id' => $this->session->chapter_joined_id,
                'particulars' => 'Video quiz coin get',
                'trangaction_type' => 'Cr.',
                'amount' => $points_quiz,
                'rest_balance' => $myOldCoin + $points_quiz,
            );
            $this->history_user_coin_Model->insert($coin_history);

        }else{
            $oldInCorAns = get_data_by_id('incorrect_answers','chapter_exam_joined','chapter_joined_id',$this->session->chapter_joined_id);
            $data2['chapter_joined_id'] = $this->session->chapter_joined_id;
            $data2['incorrect_answers'] = $oldInCorAns + 1;
            $this->chapter_exam_joinedModel->update($data2['chapter_joined_id'],$data2);
        }

    }

    public function result(){

        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'Result';
            $data['footer_icon'] = 'Home';

            $data['result'] = $this->chapter_exam_joinedModel->where('chapter_joined_id',$this->session->chapter_joined_id)->first();

            echo view('Student/header',$data);
            echo view('Student/chapter_quiz_result',$data);
            echo view('Student/footer');
        }
    }

    public function show_video(){
        $video_id = $this->request->getPost('video_id');
        $video = $this->chapterVideoModel->where('video_id',$video_id)->first();

        //print $video->URL;
        print '<iframe src="https://www.youtube-nocookie.com/embed/'.$video->URL.'" title="YouTube video player" frameborder="20" allow="accelerometer; autoplay; clipboard-write;  encrypted-media=0; gyroscope; picture-in-picture" ></iframe>';
    }

}
