<?php

namespace App\Controllers;

use App\Models\GiangVienModel;
use App\Models\BoMonModel;
use App\Models\UserModel;

class QuanLyGiangVien extends BaseController
{
    public function index()
    {
        $GiangVienModel = new GiangVienModel();
        $data['giangvien'] = $GiangVienModel->select('giangvien.*, user.hoTen, user.maUser, user.role, user.email, bomon.tenBoMon, bomon.maBoMon')
            ->join('user', 'user.maUser = giangvien.maUser', 'left')
            ->join('bomon', 'bomon.maBoMon = giangvien.maBoMon', 'left')
            ->where('user.role', 'GiangVien')
            ->orderBy('maGiangVien', 'DESC')
            ->findAll();

        $BoMonModel = new BoMonModel();
        $UserModel = new UserModel();

        $data['user'] = $UserModel->where('role', 'GiangVien')->orderBy('maUser', 'DESC')->findAll();
        $data['bomon'] = $BoMonModel->orderBy('maBoMon', 'DESC')->findAll();
        return view('quan-ly-giang-vien/index', $data);
    }

    public function add()
    {
        $UserModel = new UserModel();
        $GiangVienModel = new GiangVienModel();

        $hoTen = $this->request->getPost('hoTen');
        $email = $this->request->getPost('email');

        $userData = [
            'hoTen' => $hoTen,
            'email' => $email,
            'role' => 'GiangVien'

        ];

        try {

            $maUser = $UserModel->insert($userData);

            if ($maUser) {

                $giangVienData = [
                    'maUser' => $maUser,
                    'hoTen' => $this->request->getPost('hoTen'),
                    'maBoMon' => $this->request->getPost('maBoMon')
                ];

                if (
                    $GiangVienModel->insert($giangVienData)
                ) {
                    session()->setFlashdata('message_type', 'success');
                    session()->setFlashdata('message', 'Thêm Giảng Viên thành công!');
                } else {

                    $UserModel->delete($maUser);
                    session()->setFlashdata('message_type', 'error');
                    session()->setFlashdata('message', 'Có lỗi xảy ra khi thêm giảng viên!');
                }
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi tạo tài khoản!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }

        return redirect()->to('/quan-ly-giang-vien');
    }

    public function edit()
    {
        $UserModel = new UserModel();
        $GiangVienModel = new GiangVienModel();


        // var_dump($this->request->getPost());
        // exit();
        $maGiangVien = $this->request->getPost('maGiangVien');

        if (!$maGiangVien) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Giảng Viên không tồn tại!');
            return redirect()->to('/quan-ly-giang-vien');
        }

        if ($this->request->getMethod() === 'POST') {
            $hoTen = trim($this->request->getPost('hoTen'));
            $maBoMon = trim($this->request->getPost('maBoMon'));
            $email = trim($this->request->getPost('email'));
            $maUser = trim($this->request->getPost('maUser'));

            $curentUser = $GiangVienModel->find($maGiangVien);

            if (!$curentUser) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Giảng Viên không tồn tại!');
                return redirect()->to('/quan-ly-giang-vien');
            }

            if (empty($maUser)) {
                $maUser = $curentUser['maUser'];
            }

            if (empty($hoTen)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên Giảng Viên không được để trống!');
                return redirect()->back();
            }

            $user = $UserModel->find($maUser);
            if (!$user) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tài khoản không tồn tại!');
                return redirect()->back();
            }

            if ($user['role'] !== 'GiangVien') {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tài khoản không hợp lệ hoặc không phải Giảng Viên!');
                return redirect()->back();
            }

            try {
                if (!empty($email) || !empty($hoTen)) {
                    $userData = [
                        'hoTen' => $hoTen,
                        'email' => $email
                    ];
                    $UserModel->update($maUser, $userData);
                }
                $giangVienData = [
                    'maUser' => $maUser,
                    'hoTen' => $hoTen,
                    'maBoMon' => $maBoMon
                ];

                if ($GiangVienModel->update($maGiangVien, $giangVienData)) {
                    session()->setFlashdata('message_type', 'success');
                    session()->setFlashdata('message', 'Cập nhật Giảng Viên thành công!');
                } else {
                    session()->setFlashdata('message_type', 'error');
                    session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
                }
            } catch (\Exception $e) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
            }
        }

        return redirect()->to('/quan-ly-giang-vien');
    }

    public function delete($id = null)
    {
        $UserModel = new UserModel();
        $GiangVienModel = new GiangVienModel();

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy Giảng Viên cần xóa!');
            return redirect()->to('/quan-ly-giang-vien');
        }

        $curentGiangVien = $GiangVienModel->find($id);

        if (!$curentGiangVien) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Giảng Viên không tồn tại!');
            return redirect()->to('/quan-ly-giang-vien');
        }

        $maUser = $curentGiangVien['maUser']; 

        try {
          
            if ($GiangVienModel->delete($id)) {
                
                if (!empty($maUser)) {
                    $UserModel->delete($maUser);
                }

                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa Giảng Viên và tài khoản thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa Giảng Viên thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không thể xóa Giảng Viên vì đang được sử dụng!');
        }

        return redirect()->to('/quan-ly-giang-vien');
    }
}
