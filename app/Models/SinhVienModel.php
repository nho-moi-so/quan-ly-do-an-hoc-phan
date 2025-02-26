<?php 
namespace App\Models;
use CodeIgniter\Model;

class SinhVienModel extends Model
{
    protected $table = 'sinhvien';

    protected $primaryKey = 'maSV';
    
    protected $allowedFields = ['maUser','maLop','gioiTinh','ngaySinh'];
}