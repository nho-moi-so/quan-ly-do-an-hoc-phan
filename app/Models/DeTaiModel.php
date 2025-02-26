<?php 
namespace App\Models;
use CodeIgniter\Model;

class DeTaiModel extends Model
{
    protected $table = 'detai';

    protected $primaryKey = 'maDT';
    
    protected $allowedFields = ['maUser','maGiangVien','tenDeTai','moTa','namHoc','hocKi','maNganh'];
}