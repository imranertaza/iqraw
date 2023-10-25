<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PaymentMethod extends Seeder
{
    public function run()
    {
        $data = [
            [
                'pymnt_method_id' => '1',
                'type_name' => 'Coin',
                'createdBy' => 1,
            ],
            [
                'pymnt_method_id' => '2',
                'type_name' => 'Bkash',
                'createdBy' => 1,
            ],
        ];

        // Using Query Builder
        $this->db->table('payment_method')->insertBatch($data);
    }
}
