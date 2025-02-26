<?php

namespace App\Controllers;

use App\Models\KhoaModel;
// use CodeIgniter\Controller;

class QuanLyKhoa extends BaseController
{
    public function index()
    {
        $KhoaModel = new KhoaModel();
        $data['khoa'] = $KhoaModel->orderBy('maKhoa', 'DESC')->findAll();

        return view('quan-ly-khoa/index', $data);
    }

    public function add()
    {
        $KhoaModel = new KhoaModel();

        // Lấy dữ liệu từ form
        $tenKhoa = $this->request->getVar('tenKhoa');
        $moTaKhoa = $this->request->getVar('moTaKhoa');

        // Kiểm tra nếu tên khoa bị trống
        if (empty($tenKhoa)) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Tên khoa không được để trống!');
            return redirect()->back();
        }

        // Chuẩn bị dữ liệu
        $data = [
            'tenKhoa' => $tenKhoa,
            'moTaKhoa' => $moTaKhoa,
        ];

        try {
            if ($KhoaModel->insert($data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Thêm khoa thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Lỗi: ' . $e->getMessage());
        }

        return redirect()->to('/quan-ly-khoa');
    }


    public function edit()
    {
        $KhoaModel = new KhoaModel();
        $id = $this->request->getPost('maKhoa');

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Khoa không tồn tại!');
            return redirect()->to('/quan-ly-khoa');
        }

        if ($this->request->getMethod() === 'POST') {
            $tenKhoa = trim($this->request->getPost('tenKhoa'));
            $moTaKhoa = trim($this->request->getPost('moTaKhoa'));

            // Kiểm tra nếu dữ liệu bị bỏ trống
            if (empty($tenKhoa)) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Tên khoa không được để trống!');
                return redirect()->back();
            }

            $curentKhoa = $KhoaModel->find($id);

            if (!$curentKhoa) {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Khoa không tồn tại!');
                return redirect()->to('/quan-ly-khoa');
            }

            // Dữ liệu cần cập nhật
            $data = [
                'tenKhoa' => $tenKhoa,
                'moTaKhoa' => $moTaKhoa,
            ];

            // Cập nhật và kiểm tra kết quả
            if ($KhoaModel->update($id, $data)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Cập nhật khoa thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        }

        return redirect()->to('/quan-ly-khoa');
    }

    public function delete($id = null)
    {
        $KhoaModel = new KhoaModel();

        if (!$id) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không tìm thấy khoa cần xóa!');
            return redirect()->to('/quan-ly-khoa');
        }

        // Kiểm tra xem khoa có tồn tại không
        $curentKhoa = $KhoaModel->find($id);

        if (!$curentKhoa) {
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Khoa không tồn tại!');
            return redirect()->to('/quan-ly-khoa');
        }

        // Thực hiện xóa
        try {
            if ($KhoaModel->delete($id)) {
                session()->setFlashdata('message_type', 'success');
                session()->setFlashdata('message', 'Xóa khoa thành công!');
            } else {
                session()->setFlashdata('message_type', 'error');
                session()->setFlashdata('message', 'Xóa khoa thất bại, vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            // Bắt lỗi nếu có ràng buộc khóa ngoại
            session()->setFlashdata('message_type', 'error');
            session()->setFlashdata('message', 'Không thể xóa khoa vì đang được sử dụng!');
        }

        return redirect()->to('/quan-ly-khoa');
    }
}
