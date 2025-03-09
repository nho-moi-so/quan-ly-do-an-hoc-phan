<?php 
namespace App\Models;
use CodeIgniter\Model;

class DangKiDeTaiModel extends Model
{
    protected $table = 'dangkidetai';

    protected $primaryKey = 'madangkidetai';
    
    protected $allowedFields = ['maSV','maDT','ThoiGianDangKi'];
}