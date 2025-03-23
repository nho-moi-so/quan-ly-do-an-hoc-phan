<?php

namespace App\Models;

use CodeIgniter\Model;


class UserModel extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'maUser';

    protected $allowedFields = ['hoTen', 'matKhau', 'matKhauDefault', 'email', 'role'];

    public function checkLogin($email, $password)
    {
        $user = $this->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public function getUserById($userId)
    {
        return $this->where('id', $userId)->first();
    }

    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
    public function profile()
    {
        return view('profile');
    }
}
