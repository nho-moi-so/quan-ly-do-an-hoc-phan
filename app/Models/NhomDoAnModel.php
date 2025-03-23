<?php 
namespace App\Models;
use CodeIgniter\Model;

class NhomDoAnModel extends Model
{
    protected $table = 'nhom_doan';

    protected $primaryKey = 'maNhom';
    
    protected $allowedFields = ['maLop','tenNhom','sv1','sv2','sv3', 'maDA'];
}