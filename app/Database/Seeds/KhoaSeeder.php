<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KhoaSeeder extends Seeder
{
    public function run()
    {
        $data=[
            [
                'TenKhoa'        => 'Công Nghệ Thông Tin',
            ],
            [
                'TenKhoa'        => 'Kinh Tế',
            ],
            [
                'TenKhoa'        => 'Báo Chí và Truyền Thông',
            ],
            [
                'TenKhoa'        => 'Công Nghiệp',
            ],
        ];
        $this->db->table('khoa')->insertBatch($data);
    }
}
