<?php

namespace App\Controllers;

use App\Models\SinhVienModel;
use App\Models\LopModel;
use App\Models\UserModel;

class QuanLySinhVien extends BaseController
{
    public function index()
    {
        $SinhVienModel = new SinhVienModel();
        $data['sinhvien'] = $SinhVienModel->select('sinhvien.*, user.hoTen, user.maUser, user.role, user.email, lop.tenLop, lop.maLop')
            ->join('user', 'user.maUser = sinhvien.maUser', 'left')
            ->join('lop', 'lop.maLop = sinhvien.maLop', 'left')
            ->where('user.role', 'SinhVien')
            ->orderBy('maSV', 'DESC')
            ->findAll();

        $LopModel = new LopModel();
        $UserModel = new UserModel();

        $data['user'] = $UserModel->where('role', 'SinhVien')->orderBy('maUser', 'DESC')->findAll();
        $data['lop'] = $LopModel->orderBy('maLop', 'DESC')->findAll();
        return view('quan-ly-sinh-vien/index', $data);
    }

    public function add()
    {
        $UserModel = new UserModel();
        $SinhVienModel = new SinhVienModel();

        $hoTen = trim($this->request->getPost('hoTen'));
        $email = trim($this->request->getPost('email'));
        $maLop = trim($this->request->getPost('maLop'));
        $gioiTinh = trim($this->request->getPost('gioiTinh'));
        $ngaySinh = trim($this->request->getPost('ngaySinh'));

        $userData = [
            'hoTen' => $hoTen,
            'email' => $email,
            'role' => 'SinhVien'

        ];
        if (empty($hoTen) || empty($email) || empty($maLop) || empty($gioiTinh) || empty($ngaySinh)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Vui lòng nhập đầy đủ thông tin!');
            return redirect()->back();
        }
        try {

            $maUser = $UserModel->insert($userData);

            if ($maUser) {

                $sinhvienData = [
                    'maUser' => $maUser,
                    'hoTen' => $hoTen,
                    'maLop' => $maLop,
                    'email' => $email,
                    'gioiTinh' => $gioiTinh,
                    'ngaySinh' => $ngaySinh
                ];

                if (
                    $SinhVienModel->insert($sinhvienData)
                ) {
                    session()->setFlashdata('message_type', 'success');
                    session()->setFlashdata('message', 'Thêm Sinh Viên thành công!');
                } else {

                    $UserModel->delete($maUser);
                    session()->setFlashdata('message_type', 'error');
                    session()->setFlashdata('message', 'Có lỗi xảy ra khi thêm sinh viên!');
                }
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra khi tạo tài khoản!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }

        return redirect()->to('/quan-ly-sinh-vien');
    }

    public function edit()
    {
        $UserModel = new UserModel();
        $SinhVienModel = new SinhVienModel();
        $maSV = $this->request->getPost('maSV');

        if (!$maSV) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Sinh Viên không tồn tại!' );
            return redirect()->to('/quan-ly-sinh-vien');
        }

        if ($this->request->getMethod() === 'POST') {
            $hoTen = trim($this->request->getPost('hoTen'));
            $maLop = trim($this->request->getPost('maLop'));
            $email = trim($this->request->getPost('email'));
            $maUser = trim($this->request->getPost('maUser'));
            $gioiTinh = trim($this->request->getPost('gioiTinh'));
            $ngaySinh = trim($this->request->getPost('ngaySinh'));

            $curentUser = $SinhVienModel->find($maSV);

            if (!$curentUser) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Sinh Viên không tồn tại!');
                return redirect()->to('/quan-ly-sinh-vien');
            }

            if (empty($maUser)) {
                $maUser = $curentUser['maUser'];
            }

            if (empty($hoTen)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên Sinh Viên không được để trống!');
                return redirect()->back();
            }

            $user = $UserModel->find($maUser);
            if (!$user) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tài khoản không tồn tại!');
                return redirect()->back();
            }

            if ($user['role'] !== 'SinhVien') {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tài khoản không hợp lệ hoặc không phải Sinh Viên!');
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
                $sinhvienData = [
                    'maUser' => $maUser,
                    'hoTen' => $hoTen,
                    'maLop' => $maLop,
                    'email' => $email,
                    'gioiTinh' => $gioiTinh,
                    'ngaySinh' => $ngaySinh,
                ];

                if ($SinhVienModel->update($maSV, $sinhvienData)) {
                    session()->setFlashdata('message_type', 'success');
                    session()->setFlashdata('message', 'Cập nhật Sinh Viên thành công!');
                } else {
                    session()->setFlashdata('message_type', 'error');
                    session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
                }
            } catch (\Exception $e) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
            }
        }

        return redirect()->to('/quan-ly-sinh-vien');
    }

    public function delete($id = null)
    {
        $UserModel = new UserModel();
        $SinhVienModel = new SinhVienModel();

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy Sinh Viên cần xóa!');
            return redirect()->to('/quan-ly-sinh-vien');
        }

        $curentGiangVien = $SinhVienModel->find($id);

        if (!$curentGiangVien) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Sinh Viên không tồn tại!');
            return redirect()->to('/quan-ly-sinh-vien');
        }

        try {
            if ($SinhVienModel->delete($id)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa Sinh Viên thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa Sinh Viên thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không thể xóa Sinh Viên vì đang được sử dụng!');
        }

        return redirect()->to('/quan-ly-sinh-vien');
    }
}
