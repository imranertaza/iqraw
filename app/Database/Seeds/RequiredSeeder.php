<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RequiredSeeder extends Seeder
{
    public function run()
    {
        $this->call('Settings');
        $this->call('Roles');
        $this->call('Admin');
        $this->call('EducationType');
        $this->call('ClassGroup');
        $this->call('PaymentMethod');
    }
}
