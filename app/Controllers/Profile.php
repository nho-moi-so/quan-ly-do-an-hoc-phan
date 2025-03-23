<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Profile extends BaseController
{
    public function index()
    {
        $session = session();

        // Kiểm tra xem session có tồn tại không
        if (!$session->has('maUser') || !$session->get('logged_in')) {
            return redirect()->to('/login')->with('message', 'Vui lòng đăng nhập!');
        }

        $userModel = new UserModel();
        $data['user'] = $userModel->find($session->get('maUser'));

        return view('profile', $data);
    }

    public function changePassword()
{
    try {
        $session = session();
        $userModel = new UserModel();

        $userId = $session->get('maUser');
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/profile')->with('error', 'Người dùng không tồn tại!');
        }

        $oldPassword = trim($this->request->getPost('old-password'));
        $newPassword = trim($this->request->getPost('new-password'));
        $confirmPassword = trim($this->request->getPost('confirm-password'));

        if (!password_verify($oldPassword, $user['matKhau'])) {
            return redirect()->to('/profile')->with('error', 'Mật khẩu cũ không đúng!');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->to('/profile')->with('error', 'Mật khẩu xác nhận không khớp!');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu và đặt matKhauDefault = NULL
        $userModel->update($userId, [
            'matKhau' => $hashedPassword,
            'matKhauDefault' => null
        ]);

        return redirect()->to('/profile')->with('message', 'Đổi mật khẩu thành công!');
        
    } catch (\Exception $e) {
        session()->setFlashdata('message_type', 'error');
        session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());

        return redirect()->to('/profile');
    }
}

}
