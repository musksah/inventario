<?php

namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'rol'    => 'Administrador',
            ],
            [
                'id' => 2,
                'username' => 'marta456',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'rol'    => 'Básico',
            ],
            [
                'id' => 3,
                'username' => 'pedro123',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'rol'    => 'Básico',
            ],
        ];

        // Using Query Builder
        foreach ($data as $register) {
            $this->db->table('user')->insert($register);
        }
    }
}
