<?php

namespace App\Controllers\Mobile_app;
use App\Controllers\BaseController;
use App\Models\NoticeModel;


class Notice extends BaseController
{
    protected $validation;
    protected $session;
    protected $noticeModel;

    public function __construct()
    {
        $this->noticeModel = new NoticeModel();
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Dashboard');
            $data['page_title'] = 'Notification';
            $data['footer_icon'] = 'Notice';

            $data['notice'] = $this->noticeModel->findAll(20);

            echo view('Student/header',$data);
            echo view('Student/notice_list',$data);
            echo view('Student/footer');
        }
    }

    public function details($notice_id)
    {
        $isLoggedInStudent = $this->session->isLoggedInStudent;
        if (!isset($isLoggedInStudent) || $isLoggedInStudent != TRUE) {
            return redirect()->to('/Mobile_app/login');
        } else {

            $data['back_url'] = base_url('/Mobile_app/Notice');
            $data['page_title'] = 'Notification Details';
            $data['footer_icon'] = 'Notice';

            $std_id = $this->session->std_id;
            $table = DB()->table('notice_send');
            $check = $table->where('notice_id',$notice_id)->where('receiver_std_id',$std_id)->countAllResults();
            if ($check !=0){
                $tabledelete = DB()->table('notice_send');
                $tabledelete->where('notice_id',$notice_id)->where('receiver_std_id',$std_id)->delete();
            }

            $data['notice'] = $this->noticeModel->where('notice_id',$notice_id)->first();

            echo view('Student/header',$data);
            echo view('Student/notice_details',$data);
            echo view('Student/footer');
        }
    }




}
