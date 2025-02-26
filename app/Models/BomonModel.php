<?php 
namespace App\Models;
use CodeIgniter\Model;

class BomonModel extends Model
{
    protected $table = 'bomon';

    protected $primaryKey = 'MaBoMon';
    
    protected $allowedFields = ['TenBoMon','tenKhoa'];
}