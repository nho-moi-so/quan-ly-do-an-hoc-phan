<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableBoMon extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaBoMon' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'TenBoMon' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'MaKhoa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addPrimaryKey('MaBoMon');
        $this->forge->addForeignKey('MaKhoa', 'khoa', 'MaKhoa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bomon');
    }


    public function down()
    {
        $this->forge->dropTable('bomon');
    }
}
