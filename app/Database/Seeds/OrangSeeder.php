<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class OrangSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'      => 'Ucup',
                'alamat'    => 'jl sarden abc no 21',
                'created_at' => Time::now('Asia/Jakarta', 'en_ID'),
                'updated_at' => Time::now('Asia/Jakarta', 'en_ID')
            ],
            [
                'nama'      => 'Otong',
                'alamat'    => 'jl ikan tuna no 1',
                'created_at' => Time::now('Asia/Jakarta', 'en_ID'),
                'updated_at' => Time::now('Asia/Jakarta', 'en_ID')
            ]
        ];

        // Simple Queries
        // $this->db->query(
        //     "INSERT INTO orang (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)",
        //     $data
        // );

        // Using Query Builder
        // $this->db->table('orang')->insert($data);
        $this->db->table('orang')->insertBatch($data);
    }
}
