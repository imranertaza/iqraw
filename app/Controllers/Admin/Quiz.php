<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Quiz_questionModel;
use App\Models\QuizModel;
use App\Models\SubjectModel;


class Quiz extends BaseController
{
    protected $validation;
    protected $session;
    protected $quizModel;
    protected $subjectModel;
    protected $quiz_questionModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Quiz';

    public function __construct()
    {
        $this->quizModel = new QuizModel();
        $this->quiz_questionModel = new Quiz_questionModel();
        $this->subjectModel = new SubjectModel();
        $this->permission = new Permission();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
    }

    public function index()
    {
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Quiz';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Quiz/quiz', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }

    }

    public function getAll()
    {
        $role = $this->session->admin_role;
        //[mod_access] [create] [read] [update] [delete]
        $perm = $this->permission->module_permission_list($role,$this->module_name);
        $response = array();

        $data['data'] = array();

        $result = $this->quizModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                // $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->quiz_exam_info_id . ')"><i class="fa fa-edit"></i></button>';
                $ops .= '	<a href="'.base_url('Admin/Quiz/update/'.$value->quiz_exam_info_id).'" class="btn btn-sm btn-info"  ><i class="fa fa-edit"></i></a>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->quiz_exam_info_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(

                $value->quiz_exam_info_id,
                $value->quiz_name,
                get_data_by_id('name', 'class', 'class_id', $value->class_id),
                get_data_by_id('name', 'subject', 'subject_id', $value->subject_id),
                $value->published_date,
                $value->total_questions,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }

    public function update($id){        
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Quiz';

            $data['exam'] = $this->quizModel->where('quiz_exam_info_id',$id)->first();
            $data['examQuest'] = $this->quiz_questionModel->where('quiz_exam_info_id',$id)->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Quiz/update', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }

    }
    

    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('quiz_exam_info_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->quizModel->where('quiz_exam_info_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['quiz_name'] = $this->request->getPost('quiz_name');
        $fields['total_questions'] = $this->request->getPost('total_questions');
        $fields['published_date'] = $this->request->getPost('published_date');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'class_id' => ['label' => 'class_id', 'rules' => 'required'],
            'subject_id' => ['label' => 'subject_id', 'rules' => 'required'],
            'quiz_name' => ['label' => 'quiz_name', 'rules' => 'required'],
            'total_questions' => ['label' => 'total_questions', 'rules' => 'required'],
            'published_date' => ['label' => 'published_date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->quizModel->insert($fields)) {

                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Insertion error!';

            }

        }

        return $this->response->setJSON($response);
    }

    public function update_action()
    {

        $response = array();

        $fields['quiz_exam_info_id'] = $this->request->getPost('quiz_exam_info_id');
        $fields['class_id'] = $this->request->getPost('class_id');
        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['quiz_name'] = $this->request->getPost('quiz_name');
        $fields['total_questions'] = $this->request->getPost('total_questions');
        $fields['published_date'] = $this->request->getPost('published_date');
        $fields['status'] = $this->request->getPost('status');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'subject_id' => ['label' => 'subject_id', 'rules' => 'required'],
            'quiz_name' => ['label' => 'quiz_name', 'rules' => 'required'],
            'total_questions' => ['label' => 'total_questions', 'rules' => 'required'],
            'published_date' => ['label' => 'published_date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->quizModel->update($fields['quiz_exam_info_id'], $fields)) {

                 //question table query (start)
            $quiz_question_id = $this->request->getPost('quiz_question_id[]');
            $question = $this->request->getPost('question[]');
            $one = $this->request->getPost('one[]');
            $two = $this->request->getPost('two[]');
            $three = $this->request->getPost('three[]');
            $four = $this->request->getPost('four[]');
            $correct_answer = $this->request->getPost('correct_answer[]');
            

            if(!empty($question)){
                foreach($question as $key => $val){
                    $dataQuestion['question'] = $question[$key];
                    $dataQuestion['one'] = $one[$key];
                    $dataQuestion['two'] = $two[$key];
                    $dataQuestion['three'] = $three[$key];
                    $dataQuestion['four'] = $four[$key];
                    $dataQuestion['correct_answer'] = $correct_answer[$key];

                    $tableQuiz = DB()->table('quiz_exam_questions');
                    if(!empty($quiz_question_id[$key])){
                        $tableQuiz->where('quiz_question_id',$quiz_question_id[$key])->update($dataQuestion);
                    }else{
                        $dataQuestion['quiz_exam_info_id'] = $fields['quiz_exam_info_id'];
                        $tableQuiz->insert($dataQuestion);
                    }
                }
            }
            //question table query (end)

                $response['success'] = true;
                $response['messages'] = 'Successfully updated';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Update error!';
            }
        }
        return $this->response->setJSON($response);

    }

    public function remove()
    {
        $response = array();

        $id = $this->request->getPost('quiz_exam_info_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->quizModel->where('quiz_exam_info_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function deletQuiz()
    {
        $response = array();

        $id = $this->request->getPost('quiz_question_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->quiz_questionModel->where('quiz_question_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function get_subject(){
        $class_id = $this->request->getPost('class_id');

        $subject = $this->subjectModel->where('class_id',$class_id)->findAll();

        $view = '<option value="">Please select</option>';
        if (!empty($subject)){
            foreach ($subject as $val) {
                $view .='<option value="'.$val->subject_id.'">'.$val->name.'</option>';
            }
        }
        print $view;
    }

    public function filter(){
        $subject_id = $this->request->getPost('subject_id');
        $class_id = $this->request->getPost('class_id');
        $data = $this->quizModel->like('subject_id' ,$subject_id)->like('class_id' ,$class_id)->findAll();
        $view ='no data available';
        $view ='<thead>
                <tr>
                    <th width="40">Id</th>
                    <th>Quiz Name</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Published Date</th>
                    <th>Total Questions</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>';
        foreach ($data as $val) {

            $view .= '<tr>
                    <td>'.$val->quiz_exam_info_id.'</td>
                    <td>'.$val->quiz_name.'</td>
                    <td>'.get_data_by_id('name', 'class', 'class_id', $val->class_id).'</td>
                    <td>'.get_data_by_id('name', 'subject', 'subject_id', $val->subject_id).'</td>
                    <td>'.$val->published_date.'</td>
                    <td>'.$val->total_questions.'</td>
                    <td>'.statusView($val->status).'</td>
                    <td>
                    <div class="btn-group">	
                    <a href="'.base_url('Admin/Quiz/update/'.$val->quiz_exam_info_id).'" class="btn btn-sm btn-info"  ><i class="fa fa-edit"></i></a>
                    <button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $val->quiz_exam_info_id . ')"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
            </tr>';
        }

        print $view;
    }

}
