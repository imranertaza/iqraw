<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\ChapterModel;
use App\Models\SubjectModel;


class Chapter extends BaseController
{
    protected $validation;
    protected $session;
    protected $chapterModel;
    protected $subjectModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Chapter';

    public function __construct()
    {
        $this->chapterModel = new ChapterModel();
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
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->chapter_id . ')"><i class="fa fa-edit"></i></button>';
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

    public function get_subject(){
        $id = $this->request->getPost('class_id');
        $data = $this->subjectModel->where('class_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $view .= '<option value="'.$val->subject_id.'">'.$val->name.'</option>';
        }

        print $view;
    }


}
