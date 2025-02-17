<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDoAn extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'MaDA' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            
            'MaDT' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
            'MaSV' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
            'Diem' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true
            ],
            'MaGiangVien' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
            'NgayNop' => [
                'type' => 'DATE',
                'null'       => false
            ],
            'TrangThai' => [
                'type'       => 'ENUM',
                'constraint' => ['ChuaNop', 'DaNop', 'DaCham'],
                'default'    => 'ChuaNop',
                'null'       => false
            ],
        ]);

        $this->forge->addPrimaryKey('MaDA');
        $this->forge->addForeignKey('MaDT', 'detai', 'MaDT', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('MaSV', 'sinhvien', 'MaSV', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('MaGiangVien', 'giangvien', 'MaGiangVien', 'CASCADE', 'CASCADE');
        $this->forge->createTable('doan');
    }


    public function down()
    {
        $this->forge->dropTable('doan');
    }
}