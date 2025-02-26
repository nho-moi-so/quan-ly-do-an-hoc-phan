<?php 
namespace App\Models;
use CodeIgniter\Model;

class KhoaModel extends Model
{
    protected $table = 'khoa';

    protected $primaryKey = 'maKhoa';
    
    protected $allowedFields = ['tenKhoa', 'moTaKhoa'];
}