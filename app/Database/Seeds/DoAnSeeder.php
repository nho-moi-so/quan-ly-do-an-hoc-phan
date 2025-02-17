<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DoAnSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('doan');
        $this->db->table('doan')->where('1=1')->delete();

        $sinhvien = $db->table('sinhvien')->select('MaSV')->limit(4)->get()->getResult();
        $giangvien = $db->table('giangvien')->select('MaGiangVien')->limit(4)->get()->getResult();
        $detai = $db->table('detai')->select('MaDT')->limit(4)->get()->getResult();

        if (count($giangvien) < 4 || count($sinhvien) < 4 || count($detai) < 4 ) {
            return;
        }
        $currentDate = date('Y-m-d');
        $data=[
            [   
                'MaDT' => $detai[0]->MaDT,
                'MaSV' => $sinhvien[0]->MaSV,
                'Diem' => 9,
                'MaGiangVien' => $giangvien[0]->MaGiangVien,
                'NgayNop' => '2025-03-15',
                'TrangThai' => 'DaCham'
            ],

            [   
                'MaDT' => $detai[1]->MaDT,
                'MaSV' => $sinhvien[1]->MaSV,
                'Diem' => null,
                'MaGiangVien' => $giangvien[1]->MaGiangVien,
                'NgayNop' => '2025-02-24',
                'TrangThai' => 'ChuaNop'
            ],

            [   
                'MaDT' => $detai[2]->MaDT,
                'MaSV' => $sinhvien[2]->MaSV,
                'Diem' => null,
                'MaGiangVien' => $giangvien[2]->MaGiangVien,
                'NgayNop' => '2025-02-17',
                'TrangThai' => 'DaNop'
            ],

            [   
                'MaDT' => $detai[3]->MaDT,
                'MaSV' => $sinhvien[3]->MaSV,
                'Diem' => 8,
                'MaGiangVien' => $giangvien[3]->MaGiangVien,
                'NgayNop' => '2025-01-01',
                'TrangThai' => 'DaCham'
            ]
        ];
        $builder->insertBatch($data);
    }
}
