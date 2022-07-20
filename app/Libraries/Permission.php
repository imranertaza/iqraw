<?php namespace App\Libraries;

class Permission{

    public $admin_permissions = '{"Dashboard":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Student":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Class":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Subject":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Chapter":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Chapter_quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Chapter_video":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"User":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"User_roll":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Settings":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Quiz_question":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Skill_subject":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Skill_video":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Skill_quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"}}';


    public $all_permissions = '{"Dashboard":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Student":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Class":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Subject":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Chapter":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Chapter_quiz":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Chapter_video":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"User":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"User_roll":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Settings":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Quiz":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Quiz_question":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Skill_subject":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Skill_video":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"},"Skill_quiz":{"mod_access":"0","create":"0","read":"0","update":"0","delete":"0"}}';


    public function module_permission_list($role_id, $module_name)
    {
        $table = DB()->table('roles');
        $result = $table->where('role_id',$role_id)->get()->getRow();
        $obj = json_decode($result->permission, true);
        return $obj[$module_name];
    }

}