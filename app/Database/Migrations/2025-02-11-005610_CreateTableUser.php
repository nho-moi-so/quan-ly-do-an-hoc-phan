<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaUser' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'TenDangNhap' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => false,
            ],
            'MatKhau' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => false,
            ],
            'Email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'Role' => [
                'type'       => 'ENUM',
                'constraint' => ['SinhVien', 'GiangVien', 'CBQL', 'Admin'],
                'default'    => 'SinhVien',
            ],
        ]);

        $this->forge->addKey('MaUser', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
