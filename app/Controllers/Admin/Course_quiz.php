<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Course_quizModel;
use App\Models\Course_videoModel;


class Course_quiz extends BaseController
{
    protected $validation;
    protected $session;
    protected $course_quizModel;
    protected $course_videoModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Course_quiz';

    public function __construct()
    {
        $this->course_quizModel = new Course_quizModel();
        $this->course_videoModel = new Course_videoModel();
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
            $data['controller'] = 'Admin/Course_quiz';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Course_quiz/list', $data);
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

        $result = $this->course_quizModel->findAll();

        foreach ($result as $key => $value) {
            $course_id = get_data_by_id('course_id','course_video','course_video_id',$value->course_video_id);
            $course_name = get_data_by_id('course_name','course','course_id',$course_id);
            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->course_quiz_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->course_quiz_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(

                $value->course_quiz_id,
                $course_name,
                $value->question,
                $value->one,
                $value->two,
                $value->three,
                $value->four,
                $value->correct_answer,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('course_quiz_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->course_quizModel->where('course_quiz_id', $id)->first();
            $data->course_id = get_data_by_id('course_id','course_video','course_video_id',$data->course_video_id);
            $course_cat_id = get_data_by_id('course_cat_id','course_video','course_video_id',$data->course_video_id);
            $courCatData = getListInOptionParentIdBySub($course_cat_id,'course_cat_id', 'category_name', 'course_category','course_id',$data->course_id);
            $courseVideoData = getListInOptionParentIdBySub($data->course_video_id,'course_video_id', 'title', 'course_video','course_cat_id',$course_cat_id);

            $data->course_cat_id = $courCatData;
            $data->course_video_id = $courseVideoData;
            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['course_video_id'] = $this->request->getPost('course_video_id');
        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'course_video_id' => ['label' => 'course_video_id', 'rules' => 'required'],
            'one' => ['label' => 'one', 'rules' => 'required'],
            'two' => ['label' => 'two', 'rules' => 'required'],
            'three' => ['label' => 'three', 'rules' => 'required'],
            'four' => ['label' => 'four', 'rules' => 'required'],
            'correct_answer' => ['label' => 'correct_answer', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->course_quizModel->insert($fields)) {

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

        $fields['course_quiz_id'] = $this->request->getPost('course_quiz_id');
        $fields['course_video_id'] = $this->request->getPost('course_video_id');
        $fields['question'] = $this->request->getPost('question');
        $fields['one'] = $this->request->getPost('one');
        $fields['two'] = $this->request->getPost('two');
        $fields['three'] = $this->request->getPost('three');
        $fields['four'] = $this->request->getPost('four');
        $fields['correct_answer'] = $this->request->getPost('correct_answer');
        $fields['status'] = $this->request->getPost('status');

        $this->validation->setRules([
            'course_video_id' => ['label' => 'course_video_id', 'rules' => 'required'],
            'one' => ['label' => 'one', 'rules' => 'required'],
            'two' => ['label' => 'two', 'rules' => 'required'],
            'three' => ['label' => 'three', 'rules' => 'required'],
            'four' => ['label' => 'four', 'rules' => 'required'],
            'correct_answer' => ['label' => 'correct_answer', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->course_quizModel->update($fields['course_quiz_id'], $fields)) {

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

    public function course_category(){
        $course_id = $this->request->getPost('course_id');
        $table = DB()->table('course_category');
        $result = $table->where('course_id',$course_id)->get()->getResult();
        $view = '<option value="">Please select</option>';
        if (!empty($result)){
            foreach ($result as $val) {
                $view .= '<option value="'.$val->course_cat_id.'">'.$val->category_name.'</option>';
            }
        }

        print $view;
    }

    public function category_video(){
        $course_cat_id = $this->request->getPost('course_cat_id');
        $table = DB()->table('course_video');
        $result = $table->where('course_cat_id',$course_cat_id)->get()->getResult();
        $view = '<option value="">Please select</option>';
        if (!empty($result)){
            foreach ($result as $val) {
                $view .= '<option value="'.$val->course_video_id.'">'.$val->title.'</option>';
            }
        }

        print $view;
    }

    public function quiz_get(){
        $course_video_id = $this->request->getPost('course_video_id');
        $table = DB()->table('course_quiz');
        $result = $table->where('course_video_id',$course_video_id)->get()->getResult();
        $view = '';
        foreach ($result as $value){
            $course_id = get_data_by_id('course_id','course_video','course_video_id',$value->course_video_id);
            $course_name = get_data_by_id('course_name','course','course_id',$course_id);

            $view .='<tr class="odd"><td class="sorting_1 dtr-control">'.$value->course_quiz_id.'</td><td>'.$course_name.'</td><td>'.$value->question.'</td><td>'.$value->one.'</td><td>'.$value->two.'</td><td>'.$value->three.'</td><td>'.$value->four.'</td><td>'.$value->correct_answer.'</td><td>'.statusView($value->status).'</td><td><div class="btn-group">	<button type="button" class="btn btn-sm btn-info" onclick="edit('.$value->course_quiz_id.')"><i class="fa fa-edit"></i></button>	<button type="button" class="btn btn-sm btn-danger" onclick="remove('.$value->course_quiz_id.')"><i class="fa fa-trash"></i></button></div></td></tr>';
        }

        print $view;
    }


}
