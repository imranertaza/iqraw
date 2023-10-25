<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Settings extends Seeder
{
    public function run()
    {
        $data = [
            [
                'settings_id' => '1',
                'label' => 'points_chapter_mcq',
                'value' => '1',
                'createdBy' => 1,
            ],
            [
                'settings_id' => '2',
                'label' => 'points_semister_mcq',
                'value' => '1',
                'createdBy' => 1,
            ],
            [
                'settings_id' => '3',
                'label' => 'points_vocabulary_mcq',
                'value' => '2',
                'createdBy' => 1,
            ],
            [
                'settings_id' => '7',
                'label' => 'points_video_mcq',
                'value' => '1',
                'createdBy' => 1,
            ],
            [
                'settings_id' => '8',
                'label' => 'vocabulary_quiz_view_frontEnd',
                'value' => '5',
                'createdBy' => 1,
            ],
            [
                'settings_id' => '9',
                'label' => 'points_course_mcq',
                'value' => '1',
                'createdBy' => 1,
            ],
            [
                'settings_id' => '10',
                'label' => 'whatsapp_number',
                'value' => '1924329315',
                'createdBy' => 1,
            ],
        ];

        // Using Query Builder
        $this->db->table('settings')->insertBatch($data);
    }
}
