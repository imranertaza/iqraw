<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'imranertaza12@gmail.com',
                'password' => sha1(12345678),
                'name' => 'Syed Imran Ertaza',
                'mobile' => '1924329315',
                'role_id' => 1,
                'status' => '1',
                'createdBy' => 1,
            ]
        ];

        // Using Query Builder
        $this->db->table('admin')->insertBatch($data);
    }
}
