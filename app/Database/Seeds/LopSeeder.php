<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LopSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lop');
        $this->db->table('lop')->where('1=1')->delete(); 

        
        $nganh = $db->table('nganh')->select('MaNganh')->limit(4)->get()->getResult();

        if (count($nganh) < 4) {
            return; 
        }

       
        $data = [
            ['TenLop' => 'HTTT2211', 'MaNganh' => $nganh[0]->MaNganh],
            ['TenLop' => 'KT2211', 'MaNganh' => $nganh[1]->MaNganh],
            ['TenLop' => 'TTDPT2211', 'MaNganh' => $nganh[2]->MaNganh],
            ['TenLop' => 'CK2211', 'MaNganh' => $nganh[3]->MaNganh],
        ];

      
        $builder->insertBatch($data);
    }
}
