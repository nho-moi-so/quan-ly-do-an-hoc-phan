<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BoMonSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('bomon');
        $this->db->table('bomon')->where('1=1')->delete(); 

        
        $khoa = $db->table('khoa')->select('MaKhoa')->limit(4)->get()->getResult();

        if (count($khoa) < 4)  {
            return; 
        }

        
        $data = [
            ['TenBoMon' => 'Hệ Thống Thông Tin', 'MaKhoa' => $khoa[0]->MaKhoa],
            ['TenBoMon' => 'Kế Toán', 'MaKhoa' => $khoa[1]->MaKhoa],
            ['TenBoMon' => 'Truyền Thông Đa Phương Tiện', 'MaKhoa' => $khoa[2]->MaKhoa],
            ['TenBoMon' => 'Cơ Khí', 'MaKhoa' => $khoa[3]->MaKhoa],
        ];

        $builder->insertBatch($data);
    }
}
