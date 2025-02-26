<?php 
namespace App\Models;
use CodeIgniter\Model;

class NganhModel extends Model
{
    protected $table = 'nganh';

    protected $primaryKey = 'maNganh';
    
    protected $allowedFields = ['tenNganh', 'maKhoa'];
}