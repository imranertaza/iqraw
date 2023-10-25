<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClassGroup extends Seeder
{
    public function run()
    {
        $data = [
            [
                'class_group_id' => '1',
                'group_name' => 'Arts',
                'status' => 'Active',
                'createdBy' => 1,
            ],
            [
                'class_group_id' => '2',
                'group_name' => 'Science',
                'status' => 'Active',
                'createdBy' => 1,
            ],
            [
                'class_group_id' => '3',
                'group_name' => 'Commerce',
                'status' => 'Active',
                'createdBy' => 1,
            ],
        ];

        // Using Query Builder
        $this->db->table('class_group')->insertBatch($data);
    }
}
