<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Course_categoryModel;
use App\Models\Course_quizModel;
use App\Models\Course_videoModel;


class Course_video extends BaseController
{
    protected $validation;
    protected $session;
    protected $course_videoModel;
    protected $course_categoryModel;
    protected $group_classModel;
    protected $course_quizModel;
    protected $class_group_joinedModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Course_video';

    public function __construct()
    {
        $this->course_videoModel = new Course_videoModel();
        $this->course_categoryModel = new Course_categoryModel();
        $this->course_quizModel = new Course_quizModel();
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
            $data['controller'] = 'Admin/Course_video';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Course_video/course_video', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }

    }

    public function create(){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Course_video';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Course_video/course_video_create', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }
     
    public function quiz_add($course_video_id){
        $isLoggedIAdmin = $this->session->isLoggedIAdmin;
        if (!isset($isLoggedIAdmin) || $isLoggedIAdmin != TRUE) {
            return redirect()->to(site_url("/admin"));
        } else {
            $data['controller'] = 'Admin/Course_video';
            $data['quiz'] = $this->course_quizModel->where('course_video_id',$course_video_id)->findAll();
            $data['course_video_id'] = $course_video_id;
            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Course_video/quiz_add', $data);
            } else {
                echo view('no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function quiz_action(){
        $response = array();
        $course_video_id = $this->request->getPost('course_video_id');

        $course_quiz_id = $this->request->getPost('course_quiz_id[]');
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

                $tableQuiz = DB()->table('course_quiz');
                if(!empty($course_quiz_id[$key])){
                    $tableQuiz->where('course_quiz_id',$course_quiz_id[$key])->update($dataQuestion);
                }else{
                    $dataQuestion['course_video_id'] = $course_video_id;
                    $tableQuiz->insert($dataQuestion);
                }
            }
        }
        //question table query (end)

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';
        return $this->response->setJSON($response);
    }

    public function deletQuiz()
    {
        $response = array();

        $id = $this->request->getPost('course_quiz_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->course_quizModel->where('course_quiz_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function getAll()
    {
        $role = $this->session->admin_role;
        //[mod_access] [create] [read] [update] [delete]
        $perm = $this->permission->module_permission_list($role, $this->module_name);

        $response = array();

        $data['data'] = array();

        $result = $this->course_videoModel->findAll();

        foreach ($result as $key => $value) {
            $down = '<a href="'.base_url('assets/upload/courseVideo/'.$value->hand_note).'" download="course_hand_note"  class="btn btn-success" id="edit-form-btn">Download</a>';
            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<a  href="'.base_url('Admin/Course_video/quiz_add/'.$value->course_video_id).'" class="btn btn-sm btn-info" >Quiz</a>';
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->course_video_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->course_video_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->course_video_id,
                get_data_by_id('course_name','course','course_id',$value->course_id),
                get_data_by_id('category_name','course_category','course_cat_id',$value->course_cat_id),
                $value->title,
                !empty($value->hand_note)?$down:'',
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('course_video_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->course_videoModel->where('course_video_id', $id)->first();



            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();

        $fields['course_id'] = $this->request->getPost('course_id');
        $fields['course_cat_id'] = $this->request->getPost('course_cat_id');


        $course_id = $this->request->getPost('course_id');
        $course_cat_id = $this->request->getPost('course_cat_id');
        $title = $this->request->getPost('title[]');
        $author = $this->request->getPost('author[]');
        $URL = $this->request->getPost('URL[]');
        $createdBy = $this->session->user_id;

        $thumb = $this->request->getFileMultiple('thumb');
        $target_dir = FCPATH . 'assets/upload/courseVideo/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        } 

        $this->validation->setRules([
            'course_id' => ['label' => 'course_id', 'rules' => 'required'],
            'course_cat_id' => ['label' => 'course_cat_id', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            foreach($title as $key => $val){
                $fields['course_id'] = $course_id;
                $fields['course_cat_id'] = $course_cat_id;
                $fields['title'] = $title[$key];
                $fields['author'] = $author[$key];
                $fields['URL'] = $URL[$key];
                $fields['createdBy'] = $createdBy;        
    
    
                // Image upload
                $name = $thumb[$key]->getRandomName();
                $thumb[$key]->move($target_dir, $name);
    
                // Image cropping of the uploaded image
                $thumb_nameimg = 'thumb_' . $thumb[$key]->getName();
                $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $thumb_nameimg);
                unlink($target_dir . '' . $name);
    
                $fields['thumb'] = $thumb_nameimg; 

                $this->course_videoModel->insert($fields);    
    
            }
           

            $response['success'] = true;
            $response['messages'] = 'Data has been inserted successfully';

            

        }

        return $this->response->setJSON($response);
    }

    public function edit()
    {

        $response = array();

        $course_video_id = $this->request->getPost('course_video_id');

        $fields['course_video_id'] = $this->request->getPost('course_video_id');
        $fields['course_id'] = $this->request->getPost('course_id');
        $fields['course_cat_id'] = empty($this->request->getPost('course_cat_id')) ? null : $this->request->getPost('course_cat_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['author'] = $this->request->getPost('author');
        $fields['URL'] = $this->request->getPost('URL');

        $thumb = $this->request->getFile('thumb');
        $oldimg = get_data_by_id('thumb','course_video','course_video_id',$course_video_id);

        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/courseVideo/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        if (!empty($_FILES['thumb']['name'])) {

            unlink($target_dir . '' . $oldimg);
            $name = $thumb->getRandomName();
            $thumb->move($target_dir, $name);

            // Image cropping of the uploaded image
            $thumb_nameimg = 'thumb_' . $thumb->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $thumb_nameimg);
            unlink($target_dir . '' . $name);

            $fields['thumb'] = $thumb_nameimg;
        }
        // thumb image uploading section (End)

        $hand_note = $this->request->getFile('hand_note');

        $oldnot = get_data_by_id('hand_note','course_video','course_video_id',$course_video_id);
        if (!empty($_FILES['hand_note']['name'])) {
            if(!empty($oldnot)) {
                unlink($target_dir . '' . $oldnot);
            }

            $name = 'hand_note_' . $hand_note->getRandomName();
            $hand_note->move($target_dir, $name);

            $fields['hand_note'] = $name;
        }

        $this->validation->setRules([
            'course_id' => ['label' => 'course_id', 'rules' => 'required'],
            'course_cat_id' => ['label' => 'course_cat_id', 'rules' => 'required'],
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'author' => ['label' => 'Author', 'rules' => 'required'],
            'URL' => ['label' => 'URL', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->course_videoModel->update($fields['course_video_id'], $fields)) {

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

        $id = $this->request->getPost('course_video_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->course_videoModel->where('course_video_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }

    public function get_group(){
        $id = $this->request->getPost('class_id');
        $data = $this->class_group_joinedModel->where('class_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $name = get_data_by_id('group_name','class_group','class_group_id',$val->class_group_id);
            $view .= '<option value="'.$val->class_group_id.'">'.$name.'</option>';
        }

        print $view;
    }

    public function get_category(){
        $id = $this->request->getPost('course_id');
        $data = $this->course_categoryModel->where('course_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $view .= '<option value="'.$val->course_cat_id.'">'.$val->category_name.'</option>';
        }

        print $view;
    }

    public function filter(){
        $course_id = $this->request->getPost('course_id');
        $course_cat_id = $this->request->getPost('course_cat_id');
        $data = $this->course_videoModel->where('course_id' ,$course_id)->where('course_cat_id' ,$course_cat_id)->findAll();
        $view ='no data available';
        foreach ($data as $val) {
            $down = '<a href="'.base_url('assets/upload/courseVideo/'.$val->hand_note).'" download="course_hand_note"  class="btn btn-success" id="edit-form-btn">Download</a>';
            $btn = !empty($value->hand_note)?$down:'';
            $view .= '<tr>
                    <td>'.$val->course_video_id.'</td>
                    <td>'.get_data_by_id('course_name','course','course_id',$val->course_id).'</td>
                    <td>'.get_data_by_id('category_name','course_category','course_cat_id',$val->course_cat_id).'</td>
                    <td>'.$val->title.'</td>
                    <td>'.$btn.'</td>
                    <td>'.statusView($val->status).'</td>
                    <td>
                    <div class="btn-group">	
                    <button type="button" class="btn btn-sm btn-info" onclick="edit(' . $val->course_video_id . ')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $val->course_video_id . ')"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
            </tr>';
        }

        print $view;
    }


}
