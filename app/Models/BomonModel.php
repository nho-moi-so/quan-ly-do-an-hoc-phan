<?php 
namespace App\Models;
use CodeIgniter\Model;

class BoMonModel extends Model
{
    protected $table = 'bomon';

    protected $primaryKey = 'maBoMon';
    
    protected $allowedFields = ['tenBoMon', 'maKhoa'];
}