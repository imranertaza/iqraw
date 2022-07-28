<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\SettingsModel;


class Settings extends BaseController
{
    protected $validation;
    protected $session;
    protected $settingsModel;
    protected $crop;
    protected $permission;
    private $module_name = 'Settings';

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
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
            $data['controller'] = 'Admin/Settings';

            $role = $this->session->admin_role;
            //[mod_access] [create] [read] [update] [delete]
            $perm = $this->permission->module_permission_list($role, $this->module_name);
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if ($perm['mod_access'] == 1) {
                echo view('Admin/Settings/settings', $data);
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
        $perm = $this->permission->module_permission_list($role, $this->module_name);

        $response = array();

        $data['data'] = array();

        $result = $this->settingsModel->findAll();

        foreach ($result as $key => $value) {

            $ops = '<div class="btn-group">';
            if ($perm['update'] ==1) {
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit(' . $value->settings_id . ')"><i class="fa fa-edit"></i></button>';
            }
//            if ($perm['delete'] ==1) {
//                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove(' . $value->settings_id . ')"><i class="fa fa-trash"></i></button>';
//            }
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->settings_id,
                $value->label,
                $value->value,
                $ops,
            );
        }

        return $this->response->setJSON($data);
    }


    public function getOne()
    {
        $response = array();

        $id = $this->request->getPost('settings_id');

        if ($this->validation->check($id, 'required|numeric')) {

            $data = $this->settingsModel->where('settings_id', $id)->first();

            return $this->response->setJSON($data);

        } else {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }

    }

    public function add()
    {

        $response = array();


        $fields['label'] = $this->request->getPost('label');
        $fields['value'] = $this->request->getPost('value');
        $fields['createdBy'] = $this->session->user_id;

        $this->validation->setRules([
            'label' => ['label' => 'Label', 'rules' => 'required'],
            'value' => ['label' => 'Value', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();

        } else {

            if ($this->settingsModel->insert($fields)) {

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

        $fields['settings_id'] = $this->request->getPost('settings_id');
        //$fields['label'] = $this->request->getPost('label');
        $fields['value'] = $this->request->getPost('value');

        $this->validation->setRules([
            //'label' => ['label' => 'Label', 'rules' => 'required'],
            'value' => ['label' => 'Value', 'rules' => 'required'],
        ]);

        if ($this->validation->run($fields) == FALSE) {
            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
        } else {
            if ($this->settingsModel->update($fields['settings_id'], $fields)) {

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

        $id = $this->request->getPost('settings_id');

        if (!$this->validation->check($id, 'required|numeric')) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException();

        } else {

            if ($this->settingsModel->where('settings_id', $id)->delete()) {

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
