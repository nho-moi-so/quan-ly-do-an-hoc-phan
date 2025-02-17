<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSinhVienTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaSV' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'MaUser' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            
            'MaLop' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unsigned'   => true,
            ],
            'gioitinh' => [
                'type'       => 'ENUM',
                'constraint' => ['Nam', 'Nữ', 'Khác'],
                'default'    => 'Nam',
            ],
            'ngaysinh' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('MaSV', true);
        $this->forge->addForeignKey('MaUser', 'user', 'MaUser', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('MaLop', 'lop', 'MaLop', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sinhvien');
    }

    public function down()
    {
        $this->forge->dropTable('sinhvien');
    }
}
