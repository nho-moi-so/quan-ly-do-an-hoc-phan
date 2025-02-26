<?php 
namespace App\Models;
use CodeIgniter\Model;

class GiangVienModel extends Model
{
    protected $table = 'giangvien';

    protected $primaryKey = 'maGiangVien';
    
    protected $allowedFields = ['maUser','tenGiangVien', 'maBoMon','email','role'];
}