<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Chapter_videoModel;
use App\Models\ChapterModel;
use App\Models\SubjectModel;


class Chapter_video extends BaseController
{
    protected $validation;
    protected $session;
    protected $chapterVideoModel;
    protected $subjectModel;
    protected $chapterModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Chapter_video';

    public function __construct()
    {
        $this->chapterVideoModel = new Chapter_videoModel();
        $this->subjectModel = new SubjectModel();
        $this->chapterModel = new ChapterModel();
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
            $data['controller'] = 'Admin/Chapter_video';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Chapter_video/video', $data);
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

        $result = $this->chapterVideoModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->video_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->video_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(

                $value->video_id,
                get_data_by_id('name', 'chapter', 'chapter_id', $value->chapter_id),
                $value->name,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('video_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->chapterVideoModel->where('video_id', $id)->first();

            $subject_id = get_data_by_id('subject_id','chapter','chapter_id',$data->chapter_id);
            $class_id = get_data_by_id('class_id','subject','subject_id',$subject_id);
            $data->class_id = $class_id;
            $data->subject_id = $subject_id;

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['chapter_id'] = $this->request->getPost('chapter_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['URL'] = $this->request->getPost('URL');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'chapter_id' => ['label' => 'Chapter', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'URL' => ['label' => 'URL', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->chapterVideoModel->insert($fields)) {

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

        $video_id = $this->request->getPost('video_id');

        $fields['video_id'] = $this->request->getPost('video_id');
        $fields['chapter_id'] = $this->request->getPost('chapter_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['URL'] = $this->request->getPost('URL');


        $this->validation->setRules([
            'chapter_id' => ['label' => 'Chapter', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'URL' => ['label' => 'URL', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->chapterVideoModel->update($fields['video_id'], $fields)) {

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

        $id = $this->request->getPost('video_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->chapterVideoModel->where('video_id', $id)->delete()) {

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

    public function get_chapter(){
        $id = $this->request->getPost('subject_id');
        $data = $this->chapterModel->where('subject_id',$id)->findAll();
        $view = '<option value="">Please select</option>';
        foreach ($data as $val){
            $view .= '<option value="'.$val->chapter_id.'">'.$val->name.'</option>';
        }

        print $view;
    }


}
