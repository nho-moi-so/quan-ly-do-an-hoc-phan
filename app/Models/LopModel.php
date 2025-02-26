<?php 
namespace App\Models;
use CodeIgniter\Model;

class LopModel extends Model
{
    protected $table = 'lop';

    protected $primaryKey = 'maLop';
    
    protected $allowedFields = ['tenLop', 'maNganh'];
}