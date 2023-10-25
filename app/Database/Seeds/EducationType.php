<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EducationType extends Seeder
{
    public function run()
    {
        $data = [
            [
                'edu_type_id' => '1',
                'type_name' => 'General',
                'sort_order' => '0',
                'status' => 'Active',
            ],
            [
                'edu_type_id' => '2',
                'type_name' => 'Madrasha',
                'sort_order' => '1',
                'status' => 'Active',
            ]
        ];

        // Using Query Builder
        $this->db->table('education_type')->insertBatch($data);
    }
}
