<?php 
namespace App\Models;
use CodeIgniter\Model;

class DoAnModel extends Model
{
    protected $table = 'doan';

    protected $primaryKey = 'maDA';
    
    protected $allowedFields = ['maDT','maGiangVien','maSV','diem','ngayNop', 'trangThai'];
}