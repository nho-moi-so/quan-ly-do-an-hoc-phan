<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableGiangVien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaGiangVien' => [
                'type'       => 'INT', 
                'constraint' => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'MaUser' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            

            'MaBoMon' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

        ]);

        $this->forge->addPrimaryKey('MaGiangVien');
        $this->forge->addForeignKey('MaBoMon', 'bomon', 'MaBoMon', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('MaUser', 'user', 'MaUser', 'CASCADE', 'CASCADE');
        $this->forge->createTable('giangvien');
    }


    public function down()
    {
        $this->forge->dropTable('giangvien');
    }
}

