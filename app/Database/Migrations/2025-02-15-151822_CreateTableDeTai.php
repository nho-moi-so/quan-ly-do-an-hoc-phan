<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDeTai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaDT' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'TenDeTai' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false
            ],
            'MoTa' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'MaGiangVien' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ]
        ]);

        $this->forge->addPrimaryKey('MaDT');
        $this->forge->addForeignKey('MaGiangVien', 'giangvien', 'MaGiangVien', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detai');
    }

    public function down()
    {
        $this->forge->dropTable('detai');
    }
}
