<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaUser' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        // Khóa chính
        $this->forge->addPrimaryKey('MaUser');

        // Khóa ngoại tham chiếu users.MaUser
        $this->forge->addForeignKey('MaUser', 'user', 'MaUser', 'CASCADE', 'CASCADE');

        // Tạo bảng
        $this->forge->createTable('admins');
    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
}
