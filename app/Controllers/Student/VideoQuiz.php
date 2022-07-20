<?php

namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Models\Chapter_exam_joinedModel;
use App\Models\Chapter_quizModel;
use App\Models\Chapter_videoModel;
use App\Models\ChapterModel;
use App\Models\School_classModel;
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

    public function __construct()
    {
        $this->schoolClassModel = new School_classModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterModel = new ChapterModel();
        $this->chapterVideoModel = new Chapter_videoModel();
        $this->chapter_exam_joinedModel = new Chapter_exam_joinedModel();
        $this->chapterQuizModel = new Chapter_quizModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();

    }
    public function index($chapterId)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/login');
        } else {

            $pager = \Config\Services::pager();
            $chapter = get_data_by_id('name','chapter','chapter_id',$chapterId);
            $subjectId = get_data_by_id('subject_id','chapter','chapter_id',$chapterId);
            $data['back_url'] = base_url('/Student/Subject/chapter/'.$subjectId);
            $data['page_title'] = $chapter;



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
            return redirect()->to('/login');
        } else {

            $pager = \Config\Services::pager();
            $chapter = get_data_by_id('name','chapter','chapter_id',$chapterId);
            $subjectId = get_data_by_id('subject_id','chapter','chapter_id',$chapterId);
            $data['back_url'] = base_url('/Student/Subject/chapter/'.$subjectId);
            $data['page_title'] = $chapter.' quiz';

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
            return redirect()->to('/login');
        } else {

            $data['back_url'] = base_url('/Student/Dashboard');
            $data['page_title'] = 'Result';

            $data['result'] = $this->chapter_exam_joinedModel->where('chapter_joined_id',$this->session->chapter_joined_id)->first();

            echo view('Student/header',$data);
            echo view('Student/chapter_quiz_result',$data);
            echo view('Student/footer');
        }
    }

}
