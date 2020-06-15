<?php

namespace App\Database\Seeds;

class CategorySeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Tecnología',
                'state' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Hogar',
                'state' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Oficina',
                'state' => 1,
            ],
        ];

        // Using Query Builder
        foreach ($data as $register) {
            $this->db->table('category')->insert($register);
        }
    }
}
