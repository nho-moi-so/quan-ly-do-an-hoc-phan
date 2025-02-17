<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DeTaiSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('detai');
        $this->db->table('detai')->where('1=1')->delete();


        $giangvien = $db->table('giangvien')->select('MaGiangVien')->limit(4)->get()->getResult();

        if (count($giangvien) < 4) {
            return;
        }


        $data = [
            [
                'TenDeTai' => 'Quản Lý Đồ Án Học Phần',
                'MoTa' => 'Hệ thống hỗ trợ đồ án sinh viên và giảng viên',
                'MaGiangVien' => $giangvien[0]->MaGiangVien
            ],
            [
                'TenDeTai' => 'Quản Lý Nhà Hàng',
                'MoTa' => 'Hệ thống hỗ trợ quản lý nhà hàng',
                'MaGiangVien' => $giangvien[1]->MaGiangVien
            ],
            [
                'TenDeTai' => 'Hệ Thống Cơ Cấu Nhà Nước',
                'MoTa' => 'Hệ thống hỗ trợ quản lí nội bộ nhà nước',
                'MaGiangVien' => $giangvien[2]->MaGiangVien
            ],
            [
                'TenDeTai' => 'Quản Lý Thuế',
                'MoTa' => 'Hệ thống hỗ trợ quản lý dòng tiền',
                'MaGiangVien' => $giangvien[3]->MaGiangVien
            ],
        ];

        $builder->insertBatch($data);
    }
}
