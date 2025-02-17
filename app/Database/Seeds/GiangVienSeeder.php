<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GiangVienSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('giangvien');
        $this->db->table('giangvien')->where('1=1')->delete();


        $user = $db->table('user')->select('MaUser')->where('role', 'GiangVien')->limit(4)->get()->getResult();
        $bomon = $db->table('bomon')->select('MaBoMon')->limit(4)->get()->getResult();
       
        if (count($user) < 4 || count($bomon) < 4) {
            return;
        }
        $data = [
            [
                'MaUser'  => $user[0]->MaUser,
                'MaBoMon' => $bomon[0]->MaBoMon,
            ],

            [
                'MaUser'  => $user[1]->MaUser,
                'MaBoMon' => $bomon[1]->MaBoMon,
            ],

            [
                'MaUser'  => $user[2]->MaUser,
                'MaBoMon' => $bomon[2]->MaBoMon,
            ],

            [
                'MaUser'  => $user[3]->MaUser,
                'MaBoMon' => $bomon[3]->MaBoMon,
            ],

        ];
        $builder->insertBatch($data);
    }
}
