<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('admins');

        // Lấy danh sách User có quyền 'Admin'
        $users = $db->table('user')->where('Role', 'Admin')->get()->getResult();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'MaUser' => $user->MaUser, // Lấy MaUser từ bảng user
            ];
        }

        // Chỉ chèn nếu có dữ liệu
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
