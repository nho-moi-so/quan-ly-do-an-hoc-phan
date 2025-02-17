<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SinhVienSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sinhvien');
        $this->db->table('sinhvien')->where('1=1')->delete();


        $user = $db->table('user')->select('MaUser')->where('role', 'sinhvien')->limit(4)->get()->getResult();
        $lop = $db->table('lop')->select('MaLop')->limit(4)->get()->getResult();

        if (count($user) < 4 || count($lop) < 4) {
            return;
        }
        $data = [
            [
                'MaUser'  => $user[0]->MaUser,
                'MaLop'   => $lop[0]->MaLop,
                'gioitinh'        => 'Nữ',
                'ngaysinh' => '2002-10-23',
            ],
            [
                'MaUser'  => $user[1]->MaUser,
                'MaLop'   => $lop[1]->MaLop,
                'gioitinh'        => 'Nam',
                'ngaysinh' => '1999-02-23',
            ],
            [
                'MaUser'  => $user[2]->MaUser,
                'MaLop'   => $lop[2]->MaLop,
                'gioitinh'        => 'Nữ',
                'ngaysinh' => '2004-04-04',
            ],
            [
                'MaUser'  => $user[3]->MaUser,
                'MaLop'   => $lop[3]->MaLop,
                'gioitinh'        => 'Nam',
                'ngaysinh' => '2005-11-08',
            ],
        ];
        $builder->insertBatch($data);
    }
}
