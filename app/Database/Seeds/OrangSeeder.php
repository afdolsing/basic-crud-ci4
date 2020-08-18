<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class OrangSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {

        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 100; $i++) :
            $data = [
                'nama'      => $faker->name,
                'alamat'    => $faker->address,
                'created_at' => Time::now('Asia/Jakarta', 'en_ID'),
                'updated_at' => Time::now('Asia/Jakarta', 'en_ID')
            ];

            // Using Query Builder
            $this->db->table('orang')->insert($data);

        endfor;
    }
}
