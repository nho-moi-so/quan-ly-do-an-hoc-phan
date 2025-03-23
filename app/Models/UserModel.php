<?php 
namespace App\Models;
use CodeIgniter\Model;


class UserModel extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'maUser';
    
    protected $allowedFields = ['hoTen','matKhau', 'matKhauDefault', 'email','role'];

    public function checkLogin($email, $password)
    {
        $user = $this->where('email', $email)->first();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}