<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Roles extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role_id' => '1',
                'role' => 'Admin',
                'permission' => '{"Dashboard":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Student":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Class":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Subject":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Chapter":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Chapter_quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Chapter_video":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"User":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"User_roll":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Settings":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Quiz_question":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Skill_subject":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Skill_video":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Skill_quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Vocabulary":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Vocabulary_quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Vocabulary_exam":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Store":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"ProductCategory":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Brand":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Product":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Order":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Class_group":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Course":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Course_video":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Subscribe":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Class_subscribe_package":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Class_subscribe":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Course_quiz":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Notice":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Class_description":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"},"Liveclass":{"mod_access":"1","create":"1","read":"1","update":"1","delete":"1"}}',
                'createdBy' => 1,
            ]
        ];

        // Using Query Builder
        $this->db->table('roles')->insertBatch($data);
    }
}
