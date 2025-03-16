<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function login()
    {
        return view('login/index');
    }
    public function doLogin()
    {
        $UserModel = new UserModel();

        $email = trim($this->request->getPost('email'));
        $password = trim($this->request->getPost('password'));

        if (empty($email) || empty($password)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Vui lòng nhập đầy đủ thông tin!');
            return redirect()->back();
        }

        try {
            $user = $UserModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'maUser' => $user['maUser'],
                    'hoTen' => $user['hoTen'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => true
                ]);

                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Đăng nhập thành công!');
                return redirect()->to('/quan-ly-khoa');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Email hoặc mật khẩu không đúng!');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            echo "LỖI SQL: " . $e->getMessage();
            die();
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
