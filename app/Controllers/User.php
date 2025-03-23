<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GiangVienModel;
use App\Models\SinhVienModel;
use App\Models\AdminModel;

class User extends BaseController
{
    public function login()
    {
        return view('login/index');
    }
    public function xacThuc()
    {
        $UserModel = new UserModel();
        $SinhVienModel = new SinhVienModel();
        $GiangVienModel = new GiangVienModel();
        $AdminModel = new AdminModel();

        $email = trim($this->request->getPost('email'));
        $password = trim($this->request->getPost('password'));

        if (empty($email) || empty($password)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Vui lòng nhập đầy đủ thông tin!');
            return redirect()->to('/login');
        }

        try {
            $user = $UserModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['matKhau'])) {
                $maSV = null;
                $maGiangVien = null;
                $maAdmin = null;
                $redirectURL = '/';

                if ($user['role'] == 'SinhVien') {
                    $sinhvien = $SinhVienModel->where('maUser', $user['maUser'])->first();
                    $maSV = $sinhvien ? $sinhvien['maSV'] : null;
                    $redirectURL = '/quan-ly-sinh-vien';
                } elseif ($user['role'] == 'GiangVien') {
                    $giangvien = $GiangVienModel->where('maUser', $user['maUser'])->first();
                    $maGiangVien = $giangvien ? $giangvien['maGiangVien'] : null;
                    $redirectURL = '/quan-ly-giang-vien';
                } elseif ($user['role'] == 'Admin') {
                    $admin = $AdminModel->where('maUser', $user['maUser'])->first();
                    $maAdmin = $admin ? $admin['maAdmin'] : null;
                    $redirectURL = '/quan-ly-do-an';
                }

                session()->set([
                    'maUser' => $user['maUser'],
                    'maSV' => $maSV,
                    'maGiangVien' => $maGiangVien,
                    'maAdmin' => $maAdmin,
                    'hoTen' => $user['hoTen'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => true
                ]);

                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Đăng nhập thành công!');
                return redirect()->to($redirectURL);
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
