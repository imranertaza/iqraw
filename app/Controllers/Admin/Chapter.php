<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Chapter_quizModel;
use App\Models\Chapter_videoModel;
use App\Models\ChapterModel;
use App\Models\SubjectModel;


class Chapter extends BaseController
{
    protected $validation;
    protected $session;
    protected $chapterModel;
    protected $subjectModel;
    protected $chapterVideoModel;
    protected $chapterQuizModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Chapter';

    public function __construct()
    {
        $this->chapterModel = new ChapterModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterVideoModel = new Chapter_videoModel();
        $this->chapterQuizModel = new Chapter_quizModel();
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
            $data['controller'] = 'Admin/Chapter';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Chapter/chapter', $data);
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

        $result = $this->chapterModel->findAll();

        foreach ($result as $key => $value) {
            $class_id = get_data_by_id('class_id','subject','subject_id',$value->subject_id);
            $down = '<a href="'.base_url('assets/upload/chapter/'.$value->hand_note).'" download="'.$value->name.'"  class="btn btn-success" id="edit-form-btn">Download</a>';
            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                // $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->chapter_id . ')"><i class="fa fa-edit"></i></button>';
                $ops .= '	<a href="'.base_url('Admin/Chapter/update/'.$value->chapter_id).'" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></a>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->chapter_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->chapter_id,
                get_data_by_id('name', 'class', 'class_id', $class_id),
                get_data_by_id('name', 'subject', 'subject_id', $value->subject_id),
                $value->name,
                !empty($value->hand_note)?$down:'',
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }

    public function update($chapter_id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Chapter';
            $data['chapter'] = $this->chapterModel->where('chapter_id', $chapter_id)->first();
            $data['chapterVideo'] = $this->chapterVideoModel->where('chapter_id', $chapter_id)->first();
            $data['chapterQuize'] = $this->chapterQuizModel->where('chapter_id', $chapter_id)->findAll();

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Chapter/update', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function update_action(){

        $response = array();
        $chapter_id = $this->request->getPost('chapter_id');

        $fields['chapter_id'] = $this->request->getPost('chapter_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['status'] = $this->request->getPost('status');
        $hand_note = $this->request->getFile('hand_note');

        $oldimg = get_data_by_id('hand_note','chapter','chapter_id',$chapter_id);
        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/chapter/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        if (!empty($_FILES['hand_note']['name'])) {
            if(!empty($oldimg)) {
                unlink($target_dir . '' . $oldimg);
            }

            $name = 'hand_note_' . $hand_note->getRandomName();
            $hand_note->move($target_dir, $name);

            $fields['hand_note'] = $name;
        }
        // thumb image uploading section (End)


        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'subject_id' => ['label' => 'Subject', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            $this->chapterModel->update($fields['chapter_id'], $fields);

            //video table query (start)
            $check = get_data_by_id('video_id', 'chapter_video', 'chapter_id', $chapter_id);

            $dataVideo['name'] = $this->request->getPost('title');
            $dataVideo['URL'] = $this->request->getPost('URL');

            $tableVideo = DB()->table('chapter_video');
            if(!empty($check)){               
                $tableVideo->where('chapter_id', $chapter_id)->update($dataVideo);
            }else{
                $dataVideo['chapter_id'] = $chapter_id;
                $tableVideo->insert($dataVideo);
            }
            //video table query (end)



            //question table query (start)
            $quiz_id = $this->request->getPost('quiz_id[]');
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

                    $tableQuiz = DB()->table('chapter_quiz');
                    if(!empty($quiz_id[$key])){
                        $tableQuiz->where('quiz_id',$quiz_id[$key])->update($dataQuestion);
                    }else{
                        $dataQuestion['chapter_id'] = $chapter_id;
                        $tableQuiz->insert($dataQuestion);
                    }
                }
            }
            //question table query (end)

            $response['success'] = true;
            $response['messages'] = 'Successfully updated';
            return $this->response->setJSON($response);

        }
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('chapter_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->chapterModel->where('chapter_id', $id)->first();
            $class_id = get_data_by_id('class_id','subject','subject_id',$data->subject_id);
            $data->class_id = $class_id;
            $data->subject_id2 = getListInOptionParentIdBySub($data->subject_id, 'subject_id', 'name', 'subject','class_id',$class_id);

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['name'] = $this->request->getPost('name');
        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['createdBy'] = $this->session->user_id;
        $hand_note = $this->request->getFile('hand_note');

        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/chapter/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        if (!empty($_FILES['hand_note']['name'])) {
            $name = 'hand_note_' . $hand_note->getRandomName();
            $hand_note->move($target_dir, $name);

            $fields['hand_note'] = $name;
        }
        // thumb image uploading section (End)



        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'subject_id' => ['label' => 'Subject', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->chapterModel->insert($fields)) {

                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Insertion error!';

            }

        }

        return $this->response->setJSON($response);
    }

    public function edit()
    {

        $response = array();

        $chapter_id = $this->request->getPost('chapter_id');

        $fields['chapter_id'] = $this->request->getPost('chapter_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['subject_id'] = $this->request->getPost('subject_id');
        $fields['status'] = $this->request->getPost('status');
        $hand_note = $this->request->getFile('hand_note');

        $oldimg = get_data_by_id('hand_note','chapter','chapter_id',$chapter_id);
        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/chapter/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        if (!empty($_FILES['hand_note']['name'])) {
            if(!empty($oldimg)) {
                unlink($target_dir . '' . $oldimg);
            }

            $name = 'hand_note_' . $hand_note->getRandomName();
            $hand_note->move($target_dir, $name);

            $fields['hand_note'] = $name;
        }
        // thumb image uploading section (End)


        $this->validation->setRules([
            'chapter_id' => ['label' => 'Class', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'subject_id' => ['label' => 'Subject', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->chapterModel->update($fields['chapter_id'], $fields)) {

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

        $id = $this->request->getPost('chapter_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->chapterModel->where('chapter_id', $id)->delete()) {

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

        $id = $this->request->getPost('quiz_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->chapterQuizModel->where('quiz_id', $id)->delete()) {

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
        $id = $this->request->getPost('class_id');
        $data = $this->subjectModel->where('class_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $view .= '<option value="'.$val->subject_id.'">'.$val->name.'</option>';
        }

        print $view;
    }

    public function filter(){
        $subject_id = $this->request->getPost('subject_id');
        $data = $this->chapterModel->where('subject_id' ,$subject_id)->findAll();

        $view ='no data available';
        $view ='<thead>
        <tr>
            <th width="60">Id</th>
            <th>Name</th>
            <th>Phone</th>
            <th>School Name</th>
            <th>Class</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>';
        foreach ($data as $val) {
            $class_id = get_data_by_id('class_id','subject','subject_id',$val->subject_id);
            $down = '<a href="'.base_url('assets/upload/chapter/'.$val->hand_note).'" download="'.$val->name.'"  class="btn btn-success" id="edit-form-btn">Download</a>';
            $h = !empty($val->hand_note)?$down:"";
            $view .= '<tr>
                    <td>'.$val->chapter_id.'</td>
                    <td>'.get_data_by_id('name', 'class', 'class_id', $class_id).'</td>
                    <td>'.get_data_by_id('name', 'subject', 'subject_id', $val->subject_id).'</td>
                    <td>'.$val->name.'</td>
                    <td>'.$h.'</td>
                    <td>'.statusView($val->status).'</td>
                    <td>
                    <div class="btn-group">	
                    <a href="'.base_url('Admin/Chapter/update/'.$val->chapter_id).'" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></a>
                    <button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $val->chapter_id . ')"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
            </tr>';
        }

        print $view;
    }

}
