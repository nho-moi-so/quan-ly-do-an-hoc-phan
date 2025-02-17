<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableLop extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaLop' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'TenLop' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false
            ],
            'MaNganh' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
        ]);

        $this->forge->addPrimaryKey('MaLop');
        $this->forge->addForeignKey('MaNganh', 'nganh', 'MaNganh', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lop');
    }

    public function down()
    {
        $this->forge->dropTable('lop');
    }
}
