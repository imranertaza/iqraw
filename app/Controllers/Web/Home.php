<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $validation;
    protected $session;

    public function __construct(){
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index(){


        echo view('Web/header');
        echo view('Web/index');
        echo view('Web/footer');
    }

    public function product(){


        echo view('Web/header');
        echo view('Web/product');
        echo view('Web/footer');
    }

    public function about_us(){


        echo view('Web/header');
        echo view('Web/about_us');
        echo view('Web/footer');
    }

    public function contact_us(){


        echo view('Web/header');
        echo view('Web/contact_us');
        echo view('Web/footer');
    }

    public function refundpolicy(){


        echo view('Web/header');
        echo view('Web/refundpolicy');
        echo view('Web/footer');
    }

    public function privacypolicy(){


        echo view('Web/header');
        echo view('Web/privacypolicy');
        echo view('Web/footer');
    }

    public function tarmsandcondition(){


        echo view('Web/header');
        echo view('Web/tarmsandcondition');
        echo view('Web/footer');
    }

    public function course(){

        $table = DB()->table('course');
        $data['course'] = $table->where('class_id',null)->where('class_group_id',null)->get()->getResult();

        echo view('Web/header');
        echo view('Web/course',$data);
        echo view('Web/footer');
    }

    public function course_detail($course_id){
        $table = DB()->table('course');
        $data['course'] = $table->where('course_id',$course_id)->get()->getRow();

        echo view('Web/header');
        echo view('Web/course_detail',$data);
        echo view('Web/footer');
    }

}
