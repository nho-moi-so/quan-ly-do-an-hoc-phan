<?php 
namespace App\Models;
use CodeIgniter\Model;


class UserModel extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'maUser';
    
    protected $allowedFields = ['hoTen','matKhau','email','role'];

    public function checkLogin($email, $password)
    {
        $user = $this->where('email', $email)->first();
        
        // Kiểm tra xem có tài khoản không và mật khẩu có khớp không
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}