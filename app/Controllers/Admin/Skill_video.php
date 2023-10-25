<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\Skill_videoModel;


class Skill_video extends BaseController
{
    protected $validation;
    protected $session;
    protected $skill_videoModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Skill_video';

    public function __construct()
    {
        $this->skill_videoModel = new Skill_videoModel();
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
            $data['controller'] = 'Admin/Skill_video';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Skill_video/skill_video', $data);
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

        $result = $this->skill_videoModel->findAll();

        foreach ($result as $key => $value) {


            $img = (!empty($value->thumb))?$value->thumb:'no img.svg';
            $image = '<img src="'.base_url('assets/upload/skillVideo/'.$img).'"  width="100" alt="">';
            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->skill_video_id . ')"><i class="fa fa-edit"></i></button>';
            }
            if ($perm['delete'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->skill_video_id . ')"><i class="fa fa-trash"></i></button>';
            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->skill_video_id,
                get_data_by_id('name','skill_subject','skill_subject_id',$value->skill_subject_id),
                $value->title,
                $value->author,
                $image,
                statusView($value->status),
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('skill_video_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->skill_videoModel->where('skill_video_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['title'] = $this->request->getPost('title');
        $fields['skill_subject_id'] = $this->request->getPost('skill_subject_id');
        $fields['URL'] = $this->request->getPost('URL');
        $fields['author'] = $this->request->getPost('author');
        $fields['createdBy'] = $this->session->user_id;
        $thumb = $this->request->getFile('thumb');


        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/skillVideo/';
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        if (!empty($_FILES['thumb']['name'])) {
            $name = $thumb->getRandomName();
            $thumb->move($target_dir, $name);

            // Image cropping of the uploaded image
            $thumb_nameimg = 'thumb_' . $thumb->getName();
            $this->crop->withFile($target_dir . '' . $name)->fit(160, 105, 'center')->save($target_dir . '' . $thumb_nameimg);
            unlink($target_dir . '' . $name);

            $fields['thumb'] = $thumb_nameimg;
        }
        // thumb image uploading section (End)




        $this->validation->setRules([
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'skill_subject_id' => ['label' => 'skill_subject_id', 'rules' => 'required'],
            'URL' => ['label' => 'URL', 'rules' => 'required'],
            'author' => ['label' => 'author', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->skill_videoModel->insert($fields)) {

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

        $skill_video_id = $this->request->getPost('skill_video_id');

        $fields['skill_video_id'] = $this->request->getPost('skill_video_id');
        $fields['title'] = $this->request->getPost('title');
        $fields['skill_subject_id'] = $this->request->getPost('skill_subject_id');
        $fields['author'] = $this->request->getPost('author');
        $fields['URL'] = $this->request->getPost('URL');
        $fields['status'] = $this->request->getPost('status');
        $thumb = $this->request->getFile('thumb');

        $oldimg = get_data_by_id('thumb','skill_video','skill_video_id',$skill_video_id);

        // thumb image uploading section (start)
        $target_dir = FCPATH . 'assets/upload/skillVideo/';
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



        $this->validation->setRules([
            'title' => ['label' => 'Title', 'rules' => 'required'],
            'skill_subject_id' => ['label' => 'skill_subject_id', 'rules' => 'required'],
            'URL' => ['label' => 'URL', 'rules' => 'required'],
            'author' => ['label' => 'author', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->skill_videoModel->update($fields['skill_video_id'], $fields)) {

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

        $id = $this->request->getPost('skill_video_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {
            //thumb image unlink(start)
            $oldimg = get_data_by_id('thumb','skill_video','skill_video_id',$id);
            $target_dir = FCPATH . 'assets/upload/skillVideo/';
            unlink($target_dir . '' . $oldimg);
            //thumb image unlink(end)

            if ($this->skill_videoModel->where('skill_video_id', $id)->delete()) {

                $response['success'] = true;
                $response['messages'] = 'Deletion succeeded';

            } else {

                $response['success'] = false;
                $response['messages'] = 'Deletion error!';

            }
        }

        return $this->response->setJSON($response);
    }


}
