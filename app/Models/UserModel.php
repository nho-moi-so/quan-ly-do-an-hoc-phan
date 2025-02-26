<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'maUser';
    
    protected $allowedFields = ['hoTen','matKhau','email','role'];
}