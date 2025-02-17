<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->where('1=1')->delete(); 

        $data = [
            [
                'Email'       => 'myngoc123@gmai.com',
                'MatKhau'     => password_hash('123', PASSWORD_BCRYPT),
                'Role'        => 'Admin',
                'TenDangNhap' => 'Mỹ Ngọc',
            ],

            [
                'Email'       => 'khiem456@gmai.com',
                'MatKhau'     => password_hash('456', PASSWORD_BCRYPT),
                'Role'        => 'GiangVien',
                'TenDangNhap' => 'Khiêm',
            ],

            [
                'Email'       => 'tom666@gmai.com',
                'MatKhau'     => password_hash('666', PASSWORD_BCRYPT),
                'Role'        => 'GiangVien',
                'TenDangNhap' => 'Tom',
            ],

            [
                'Email'       => 'han777@gmai.com',
                'MatKhau'     => password_hash('777', PASSWORD_BCRYPT),
                'Role'        => 'GiangVien',
                'TenDangNhap' => 'Hân',
            ],

            [
                'Email'       => 'chang@gmai.com',
                'MatKhau'     => password_hash('888', PASSWORD_BCRYPT),
                'Role'        => 'GiangVien',
                'TenDangNhap' => 'Chang',
            ],
        
            [
                'Email'       => 'havy789@gmai.com',
                'MatKhau'     => password_hash('789', PASSWORD_BCRYPT),
                'Role'        => 'SinhVien',
                'TenDangNhap' => 'Hạ Vy',
            ],

            [
                'Email'       => 'thiloi222@gmai.com',
                'MatKhau'     => password_hash('222', PASSWORD_BCRYPT),
                'Role'        => 'SinhVien',
                'TenDangNhap' => 'Thị Loi',
            ],

            [
                'Email'       => 'thidom333@gmai.com',
                'MatKhau'     => password_hash('333', PASSWORD_BCRYPT),
                'Role'        => 'SinhVien',
                'TenDangNhap' => 'Thị Đốm',
            ],

            [
                'Email'       => 'choco444@gmai.com',
                'MatKhau'     => password_hash('444', PASSWORD_BCRYPT),
                'Role'        => 'SinhVien',
                'TenDangNhap' => 'choco',
            ],

            [
                'Email'       => 'anhthu304@gmai.com',
                'MatKhau'     => password_hash('304', PASSWORD_BCRYPT),
                'Role'        => 'CBQL',
                'TenDangNhap' => 'Anh Thư',
            ],
        ];

        $this->db->table('user')->insertBatch($data);
        echo "Seed dữ liệu thành công!";
    }
}
