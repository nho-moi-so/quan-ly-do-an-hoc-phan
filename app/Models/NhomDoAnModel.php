<?php 
namespace App\Models;
use CodeIgniter\Model;

class NhomDoAnModel extends Model
{
    protected $table = 'nhom_doan';

    protected $primaryKey = 'maNhom';
    
    protected $allowedFields = ['maLop','tenNhom','SV1','SV2','SV3'];
}