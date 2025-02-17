<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableNganh extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaNganh' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'TenNganh' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'MaKhoa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addPrimaryKey('MaNganh');
        $this->forge->addForeignKey('MaKhoa', 'khoa', 'MaKhoa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('nganh');
    }


    public function down()
    {
        $this->forge->dropTable('nganh');
    }
}
