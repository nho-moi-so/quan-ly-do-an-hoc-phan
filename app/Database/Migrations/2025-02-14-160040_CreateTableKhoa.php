<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableKhoa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaKhoa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'TenKhoa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addPrimaryKey('MaKhoa');
        $this->forge->createTable('khoa');
    }

    public function down()
    {
        $this->forge->dropTable('khoa');
    }
}
